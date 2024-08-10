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
                                    <h1 class="mb-2">Forgot Password</h1>
                                    <p class="text-muted">Enter the email address registered on your account</p>
                                </div>
                                <form action="{{ route('forget.password') }}" method="POST" class="card-body pt-3">
                                    @csrf

                                    <div class="form-group">
                                        <label class="form-label">E-Mail</label>
                                        <div class="input-group mb-4">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fe fe-mail""></i>
                                                </span>
                                                <input class="form-control" placeholder="Email" name="email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit">
                                    <button class="btn btn-primary btn-block" type="submit">Submit</button>
                                    </div>
                                    <div class="text-center mt-4">
                                        <p class="text-dark mb-0">Forgot It?<a class="text-primary ms-1" href="{{ route('login') }}">Send me Back</a></p>
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
