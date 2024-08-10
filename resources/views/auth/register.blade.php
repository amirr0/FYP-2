@extends('auth.layouts.app')

@section('title', 'Register')

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
                                    <h1 class="mb-2">Register</h1>
                                    <p class="text-muted">Create your account</p>
                                </div>
                                <form class="card-body pt-3" id="register" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label">First Name</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fe fe-user" aria-hidden="true"></i>
                                                </span>
                                                <input class="form-control" placeholder="First Name" name="first_name" value="{{ old('first_name') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Last Name</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fe fe-user" aria-hidden="true"></i>
                                                </span>
                                                <input class="form-control" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fe fe-mail" aria-hidden="true"></i>
                                                </span>
                                                <input class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required>
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
                                                <input class="form-control" type="password" name="password" placeholder="Password" required>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="form-label">Profile Picture</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group">
                                                <input type="file" class="form-control" name="profile_picture" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit">
                                        <button class="btn btn-primary btn-block" type="submit">Register</button>
                                    </div>
                                    <div class="text-center mt-3">
                                        <p class="mb-2">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
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
