@section('title', 'Login')
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
                                        <h1 class="mb-2">Login</h1>
                                        <p class="text-muted">Sign In to your account</p>
                                    </div>
                                    <form class="card-body pt-3" id="login" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label class="form-label">Email</label>
                                            <div class="input-group mb-4">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fe fe-mail" aria-hidden="true"></i>
                                                    </span>
                                                    <input class="form-control" placeholder="Email" name="email" value="{{ old('email', session('email')) }}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Password</label>
                                            <div class="input-group mb-4">
                                                <div class="input-group" id="Password-toggle">
                                                    <a href="" class="input-group-text">
                                                        <i class="fe fe-eye-off" aria-hidden="true"></i>
                                                    </a>
                                                    <input class="form-control" type="password" name="password"
                                                        placeholder="Password">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="remember" {{
                                                    old('remember') ? 'checked' : '' }} value="1">
                                                <span class="custom-control-label">Remember me</span>
                                            </label>
                                        </div> --}}
                                        <div class="submit">
                                            <button class="btn btn-primary btn-block" type="submit">Login</button>
                                        </div>
                                        <div class="text-center mt-3">
                                            {{-- <p class="mb-2"><a href="{{ route('show.forget.form') }}">Forgot Password</a></p> --}}
                                            <p class="mb-2">Not have an account? <a href="{{ route('showregisterForm') }}">Register here</a></p>

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
    @endsection()
