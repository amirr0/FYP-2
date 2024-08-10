@extends('dashboard.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="app-content main-content">
        <div class="side-app">
            @include('dashboard.layouts.header')
            <!--Page header-->
            <div class="page-header d-xl-flex d-block">
                <div class="page-leftheader">
                    <h4 class="page-title">{{ $authUser->role->name }}<span
                            class="font-weight-normal text-muted ms-2">Dashboard</span></h4>
                </div>

            </div>
            <!--End Page header-->
            <div class="row">
                <div class="col-xl-12 col-md-12 col-lg-12">
                    <div class="row">


                        @can('order_management', 'view_orders')
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="mt-0 text-start">
                                                    <span class="fs-14 font-weight-semibold">Total Orders</span>
                                                    <h3 class="mb-0 mt-1 mb-2">{{ $totalOrders }}</h3>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="icon1 bg-success my-auto float-end"> <i
                                                        class="feather feather-shopping-bag"></i> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan


                        @if (!in_array(Auth::user()->role->name, ['Client', 'Vendor']))
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="mt-0 text-start">
                                                    <span class="fs-14 font-weight-semibold">Total Vendors</span>
                                                    <h3 class="mb-0 mt-1 mb-2">{{ $totalVendors }}</h3>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="icon1 bg-primary my-auto float-end"> <i
                                                        class="feather feather-users"></i> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="mt-0 text-start">
                                                    <span class="fs-14 font-weight-semibold">Total Clients</span>
                                                    <h3 class="mb-0 mt-1 mb-2">{{ $totalClient }}</h3>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="icon1 bg-secondary brround my-auto float-end"> <i
                                                        class="feather feather-users"></i> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div><!-- end app-content-->
@endsection
