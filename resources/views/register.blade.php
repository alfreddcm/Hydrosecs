@extends('layout')
@section('title', 'Registration')
@section('content')
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h4>SIGN UP</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('register.post') }}" method="POST">
                            @csrf
                            @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{ request('email') }}" class="form-control" id="email" placeholder="Email" readonly>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="firstName">Full Name</label>
                                <input type="text" name="fullName" class="form-control" id="fullName" placeholder="Full Name">
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" id="confirmPassword" placeholder="Confirm Password">
                            </div>
                            <div class="form-group form-check">
                                <div class="g-recaptcha" data-sitekey="6LebogwqAAAAAJ47BvpYsyGSY5z2szywzZzJ6rMA"></div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block">SIGN UP</button>

                                <button type="button" class="btn btn-secondary btn-block" onclick="window.location.href='{{ url('/') }}'">RETURN</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
