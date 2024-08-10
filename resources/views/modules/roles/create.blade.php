@extends('dashboard.layouts.app')

@section('content')
<div class="app-content main-content">
    <div class="side-app">
        @include('dashboard.layouts.header')
        <!--Page header-->
        <div class="page-header d-xl-flex d-block">
            <div class="page-leftheader">
                <h4 class="page-title">New Role</h4>
            </div>
            <div class="page-rightheader ms-md-auto">
                <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                    <div class="btn-list">
                        <a href="#" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="E-mail"> <i class="feather feather-mail"></i> </a>
                        <a href="#" class="btn btn-light" data-bs-placement="top" data-bs-toggle="tooltip"
                            title="Contact"> <i class="feather feather-phone-call"></i> </a>
                        <a href="#" class="btn btn-primary" data-bs-placement="top" data-bs-toggle="tooltip"
                            title="Info"> <i class="feather feather-info"></i> </a>
                    </div>
                </div>
            </div>
        </div>
        <!--End Page header-->

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12">
                <form action="{{ route('backend.role.store') }}" method="POST">
                    @csrf

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Role Name</label>
                                        <input class="form-control" name="name" type="text"
                                            placeholder="Enter Role Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="custom-control custom-checkbox success">
                                            <input type="checkbox" id="check-all-permissions"
                                                class="custom-control-input">
                                            <span class="custom-control-label">Check All</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered border-top text-nowrap mb-0 client-perm-table">
                                    <thead>
                                        <tr>
                                            <th>Module Permissions</th>
                                            <th class="text-center">Create</th>
                                            <th class="text-center">Read</th>
                                            <th class="text-center">Edit</th>
                                            <th class="text-center">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-semibold">User Managment</td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="1">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="2">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="3">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="4">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-semibold">Service Managment</td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="5">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="6">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="7">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="8">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-semibold">Package Managment</td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="9">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="10">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="11">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="12">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="font-weight-semibold">Item Managment</td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="13">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="14">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="15">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="16">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-semibold">Role Managment</td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="17">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="18">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="19">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="20">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-semibold">Order Managment</td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="21">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="22">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="23">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label
                                                    class="custom-control custom-checkbox permission-checkbox success">
                                                    <input type="checkbox"
                                                        class="custom-control-input permission-checkbox"
                                                        name="permission[]" value="24">
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <!-- End Row-->
    </div>
</div><!-- end app-content-->
@endsection

@push('scripts')
<script>
    document.getElementById('check-all-permissions').addEventListener('change', function() {
            var permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
            for (var i = 0; i < permissionCheckboxes.length; i++) {
                permissionCheckboxes[i].checked = !permissionCheckboxes[i].checked;
            }
        });
</script>
@endpush
