<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

//Schedule::command('tower:update-mode')->everyMinute();
// Schedule::command('app:harvestremainder')->everyTenSeconds();
Schedule::command('app:pumpreminder')->everyTenSeconds();
Schedule::command('app:ifoff')->everyTenSeconds();
