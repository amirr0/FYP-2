@section('title', 'Users')
@extends('dashboard.layouts.app')
@section('content')
<div class="app-content main-content">
    <div class="side-app">
        @include('dashboard.layouts.header')
        <!--Page header-->
        <div class="page-header d-xl-flex d-block">
            <div class="page-leftheader">
                <h4 class="page-title">Employee</h4>
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
                                src="../../assets/images/users/1.jpg">
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
                            <li class="ms-4"><a href="#tab5" class="active" data-bs-toggle="tab">Personal Details</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body hremp-tabs1 p-0">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab5">
                            <form action="{{ route('backend.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="card-body">
                                    <h4 class="mb-4 font-weight-bold">Basic</h4>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0 mt-2">First Name</label>
                                            <input type="text" class="form-control" placeholder="First Name"
                                                name="first_name" value="{{ $user->first_name }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label mb-0 mt-2">Last Name</label>
                                            <input type="text" name="last_name" class="form-control"
                                                placeholder="Last Name" value="{{ $user->last_name }}">
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label mb-0 mt-2">Upload Photo</label>
                                            <input class="form-control" name="profile_picture" type="file">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label mb-0 mt-2">Email</label>
                                            <input type="email" name="email" class="form-control" placeholder="email"
                                                value="{{ $user->email }}">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label mb-0 mt-2">Status</label>
                                        <select name="status" class="form-control custom-select select2"
                                            data-placeholder="Select Status" required>
                                            <option value="Active" {{ $user->status == "Active" ? 'selected' : '' }}
                                                >Active</option>
                                            <option value="Inactive" {{ $user->status == "Inactive" ? 'selected' :
                                                '' }} >Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label mb-0 mt-2">Password</label>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="password" value="">
                                    </div>
                                </div>

                                <div class="card-footer text-end">
                                    <button class="btn btn-outline-primary">Back</button>
                                    <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
            <!-- End Row-->

        </div><!-- end app-content-->
    </div>
    @endsection
