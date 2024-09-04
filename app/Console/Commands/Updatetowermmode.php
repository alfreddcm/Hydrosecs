<?php

namespace App\Console\Commands;

use App\Models\Tower;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UpdateTowerMode extends Command
{
    protected $signature = 'tower:update-mode';
    protected $description = 'Update the mode of the Tower model based on the time of day';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $hour = now()->hour;

        if ($hour >= 6 && $hour < 18) {
            $mode = 1; 
        } elseif ($hour >= 18 && $hour < 22) {
            $mode = 2; 
        } else {
            $mode = 0;
        }
        
        $encryptedMode = Crypt::encryptString($mode);
        Tower::query()->update(['mode' => $encryptedMode]);
        $this->info("Tower mode updated to {$mode}");
        Log::info("Tower mode updated to {$mode} at " . now());


        $now = Carbon::now();
        $oneDayLater = $now->copy()->addDay();
        $daysBefore = 1;

        $towers = Tower::whereNotNull('enddate')
            ->where(function ($query) use ($now, $oneDayLater, $daysBefore) {
                $query->whereBetween('enddate', [$now->copy()->addDays($daysBefore), $oneDayLater])
                    ->orWhereBetween('enddate', [$oneDayLater, $oneDayLater]);
            })
            ->get();

        foreach ($towers as $tower) {
            $owner = Owner::find($tower->OwnerID);
            if ($owner) {
                $ownerEmail = Crypt::decryptString($owner->email);
                if ($tower->enddate->isSameDay($oneDayLater)) {
                    $subject = "Reminder: Tower Harvest Date Today";
                    $body = "Dear Owner,\n\nThis is a reminder that today is the end date for tower {$tower->id}. Please take the necessary actions.\n\nBest regards,\nYour Team";
                    $mode='4';
                    $encryptedMode = Crypt::encryptString($mode);
                    Tower::query()->update(['mode' => $encryptedMode]);

                } elseif ($tower->enddate->isSameDay($oneDayLater->addDay())) {
                    $subject = "Reminder: Tower Harvest Date Tomorrow";
                    $body = "Dear Owner,\n\nThis is a reminder that the end date for tower {$tower->id} is tomorrow on {$tower->enddate->format('Y-m-d')}. Please take the necessary actions.\n\nBest regards,\nYour Team";
                } else {
                    continue;
                }

                try {
                    Mail::to($ownerEmail)->send(new Harvest($subject, $body));
                    $mailStatus = 'Sent';
                    Log::info('Alert email sent to', ['email' => $ownerEmail, 'tower_id' => $tower->id]);
                } catch (\Exception $e) {
                    $mailStatus = 'Failed';
                    Log::error('Failed to send alert email', ['email' => $ownerEmail, 'tower_id' => $tower->id, 'error' => $e->getMessage()]);
                } finally {
                    // Encrypt and log the activity, regardless of email success or failure
                    $activityLog = Crypt::encryptString("Alert: Conditions detected - " . json_encode(['body' => $body]) . " Mail Status: " . $mailStatus);

                    TowerLogs::create([
                        'ID_tower' => $tower->id,
                        'activity' => $activityLog,
                    ]);

                    Log::info('Alert logged in tbl_towerlogs', ['tower_id' => $tower->id, 'activity' => $body]);
                }

            } else {
                $this->error("Owner not found for tower ID {$tower->id}.");
            }
        }

        // public function handle()
        // {

        //         Log::info('Test scheduled command ran at ' . now());
        //         $this->info('Test scheduled command ran');

        // }
    }
}