@extends('auth.layouts.app')

@section('content')
<div class="page login-bg">
    <div class="page-single">
        <div class="container">
            <div class="row">
                <div class="col mx-auto">
                    <div class="row justify-content-center">
                        <div class="col-md-7 col-lg-5">
                            <div class="card">
                                <div class="p-4 pt-6 text-center">
                                    <h1 class="mb-2">Reset Password</h1>
                                    <p class="text-muted">Enter your email and new password</p>
                                </div>
                                <form action="{{ route('password.update') }}" method="POST" class="card-body pt-3">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group" id="Password-toggle1">
                                                <input class="form-control" name="email" type="email" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">New Password</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group" id="Password-toggle1">
                                                <input class="form-control" name="password" type="password" placeholder="Password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group" id="Password-toggle2">
                                                <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit">
                                        <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                                    </div>
                                    <div class="text-center mt-4">
                                        <p class="text-dark mb-0">Remembered your password?<a class="text-primary ms-1" href="{{ route('login') }}">Login</a></p>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
