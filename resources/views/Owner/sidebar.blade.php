@php
    use Illuminate\Support\Facades\Crypt;
    use Carbon\Carbon;
    use App\Models\Owner;

    if (Auth::check()) {
    $user = Owner::where('id', Auth::id())->first();
    if ($user) {
        $decryptedName = Crypt::decryptString($user->name);
    }
}


@endphp
<!doctype html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/date-fns@2.28.0/date-fns.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </script>
</head>

<body>
    <main class="containe">
        <div class="row g-0">
            <div class="col-2 side">
                <div class="p-2 text-white">
                    <a
                        href="#"class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-4">

                            <div class="dropdown ps-1">
                                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                                   id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('images/logo.png') }}" alt="logo" class="rounded-circle" style="width: 50px; height: 50px; margin-right: 8px;">
                                    <strong>{{ $decryptedName }}</strong>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                                    <li><a class="dropdown-item" href="{{ route('ownermanageprofile') }}">Manage Account</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
                                </ul>
                            </div>
                        </span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="/Owner/dashboard"
                                class="nav-link {{ request()->is('Owner/dashboard') ? 'active' : 'text-white' }}"
                                aria-current="page">
                                <svg class="bi me-2" width="16" height="16">
                                    <use xlink:href="#home"></use>
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="/Owner/ManageTower"
                                class="nav-link {{ request()->is('Owner/ManageTower') ? 'active' : 'text-white' }}">
                                <svg class="bi me-2" width="16" height="16">
                                    <use xlink:href="#speedometer2"></use>
                                </svg>
                                Towers
                            </a>
                        </li>
                        <li>
                            <a href="/Owner/WorkerAccounts"
                                class="nav-link {{ request()->is('Owner/WorkerAccounts') ? 'active' : 'text-white' }}">
                                <svg class="bi me-2" width="16" height="16">
                                    <use xlink:href="#table"></use>
                                </svg>
                                Worker Accounts
                            </a>
                        </li>

                    </ul>
                </div>

            </div>
            <div class="col-10 main">
                <div class="dashboard-header">
                    <div class="row">
                        <div class="col ps-3">
                            <h2>@yield('title')</h2>
                        </div>
                        <div class="col text-end time">
                            <p>{{ Carbon::now()->format('D | M d, Y') }}</p>
                            <p id="current-time"></p>

                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    @yield('content')

                </div>
            </div>
    </main>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- Bootstrap JavaScript Libraries -->
    <!-- <script src="{{ asset('js/jquery.min.js') }}"></script> -->
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script>
        function updateTime() {
        const now = new Date();
        let hours = now.getHours();
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';

        hours = hours % 12;
        hours = hours ? hours : 12;
        hours = String(hours).padStart(2, '0');

        document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds} ${ampm}`;
    }

    updateTime();
    setInterval(updateTime, 1000);    </script>

</body>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });
</script>

</html>
