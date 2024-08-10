@extends('dashboard.layouts.app')
@section('title', 'Profile')
@section('content')
    <div class="app-content main-content">
        <div class="side-app">
            @include('dashboard.layouts.header')
            <!--Page header-->
            <div class="page-header d-xl-flex d-block">
                <div class="page-leftheader">
                    <h4 class="page-title">{{ $user->fullName() }} Profile</h4>
                </div>
                <div class="page-rightheader">
                    <a class="btn btn-primary" href="{{ route('backend.users.index') }}">Back</a>
                </div>

            </div>
            <!--End Page header-->

            <!-- Row -->
            <div class="row">
                <div class="col-xl-3 col-md-12 col-lg-12">
                    <div class="card box-widget widget-user">
                        <div class="card-body text-center">
                            <div class="widget-user-image mx-auto text-center">
                                <img class="avatar avatar-xxl brround rounded-circle" alt="img"
                                    src="{{ $user->profile_picture ? asset($user->profile_picture) : asset('dashboard-assets/assets/images/users/16.jpg') }}">
                            </div>
                            <div class="pro-user mt-3">
                                <h5 class="pro-user-username text-dark mb-1 fs-16">{{ $user->fullName() }}</h5>
                                <h6 class="pro-user-desc text-muted fs-12">{{ $user->role->name }}</h6>
                            </div>

                        </div>
                        <div class="card-footer p-0">

                        </div>
                    </div>

                </div>
                <div class="col-xl-9 col-md-12 col-lg-12">
                    <div class="tab-menu-heading hremp-tabs p-0 ">
                        <div class="tabs-menu1">
                            <!-- Tabs -->
                            <ul class="nav panel-tabs">
                                <li class="ms-4"><a href="#tab5" class="active" data-bs-toggle="tab">Personal
                                        Details</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body tabs-menu-body hremp-tabs1 p-0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab5">
                                <div class="card-body">

                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label mb-0 mt-2">User Name</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input readonly type="text" class="form-control mb-md-0 mb-5"
                                                            placeholder="First Name" name="first_name"
                                                            value="{{ $user->first_name }}">
                                                        <span class="text-muted"></span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input readonly type="text" name="last_name" class="form-control"
                                                            placeholder="Last Name" value="{{ $user->last_name }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label mb-0 mt-2">Date Of Birth</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input readonly type="text" name="dob" class="form-control"
                                                    placeholder="DD-MM-YYY" value="{{ $user->dob }}">
                                            </div>
                                        </div>
                                    </div> --}}

                                    {{-- <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label mb-0 mt-2">Address</label>
                                            </div>
                                            <div class="col-md-9">
                                                <textarea rows="3" readonly name="address" class="form-control" placeholder="Address1">{{ $user->address }}</textarea>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label mb-0 mt-2">Email</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input readonly type="email" name="email" class="form-control"
                                                    placeholder="email" value="{{ $user->email }}">
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <!-- End Row-->

            </div><!-- end app-content-->
        </div>
    @endsection
