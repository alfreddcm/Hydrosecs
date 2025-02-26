@extends('layout')
@section('title', 'Verify One-time-pin')


@section('content')

    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">

                            <img src="assets/img/logo.png" alt="">
                            <span class="d-none d-lg-block">Hydrosec</span>
                        </div><!-- End Logo -->

                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Email Verfication</h5>
                                    <p class="text-center small">Please enter the 6 Digit One time PIN snt to your email:
                                        {{ $email }}</p>
                                </div>
                                <form method="POST" action="{{ url('reset-password') }}">
                                    @csrf
                                    <label for="password">New Password:</label>
                                    <input type="password" name="password" required>
                                
                                    <label for="password_confirmation">Confirm Password:</label>
                                    <input type="password" name="password_confirmation" required>
                                    
                                    <button type="submit">Reset Password</button>
                                </form>
                                

                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <div class="col-12">
                                        <label for="otp" class="form-label">Enter OTP:</label>
                                        <input type="hidden" class="form-control text-center" id="otp" name="email" value="{{ $email }}" >
                                        <input type="text" class="form-control text-center" id="otp" name="otp"
                                            required maxlength="6" pattern="\d{6}" title="Please enter a 6-digit OTP">

                                    </div>

                            </div>
                            <div class="col-12 p-2">
                                <button class="btn btn-primary w-100" type="submit">Verify</button>
                            </div>
                            </form>
                            <div class="col-12 mb-1 text-center">
                                <p class="small mb-0"> 
                                <a href="{{ route('resendotp') }}">Click here</a>
                                    to resend OTP.</p>
                            </div>
                            <div class="col-12 mb-1 text-center">
                                <p class="small mb-0"> Already have an account?<a href="{{ route('cancel') }}">Login</a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
    </div>

    <script>

    </script>

@endsection
