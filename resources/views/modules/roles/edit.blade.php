@section('title', 'Edit Role')

@extends('dashboard.layouts.app')
@section('content')
    <div class="app-content main-content">
        <div class="side-app">
            @include('dashboard.layouts.header')
            <!--Page header-->
            <div class="page-header d-xl-flex d-block">
                <div class="page-leftheader">
                    <h4 class="page-title">Edit Role</h4>
                </div>
                <div class="page-rightheader ms-md-auto">
                    <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                        <div class="btn-list">
                            <a href="#" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="E-mail">
                                <i class="feather feather-mail"></i>
                            </a>
                            <a href="#" class="btn btn-light" data-bs-placement="top" data-bs-toggle="tooltip"
                                title="Contact">
                                <i class="feather feather-phone-call"></i>
                            </a>
                            <a href="#" class="btn btn-primary" data-bs-placement="top" data-bs-toggle="tooltip"
                                title="Info">
                                <i class="feather feather-info"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Page header-->
            <!-- Row -->
            <div class="row">
                <div class="col-xl-12 col-md-12 col-lg-12">
                    <form action="{{ route('backend.role.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Role Name</label>
                                            <input class="form-control" name="name" type="text"
                                                placeholder="Enter Role Name" value="{{ $role->name }}">
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
                                                <td class="font-weight-semibold">User Management</td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="1"
                                                            {{ $role->permissions->contains('id', 1) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="2"
                                                            {{ $role->permissions->contains('id', 2) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="3"
                                                            {{ $role->permissions->contains('id', 3) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="4"
                                                            {{ $role->permissions->contains('id', 4) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-semibold">Service Management</td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="5"
                                                            {{ $role->permissions->contains('id', 5) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="6"
                                                            {{ $role->permissions->contains('id', 6) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="7"
                                                            {{ $role->permissions->contains('id', 7) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="8"
                                                            {{ $role->permissions->contains('id', 8) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-semibold">Package Management</td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="9"
                                                            {{ $role->permissions->contains('id', 9) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="10"
                                                            {{ $role->permissions->contains('id', 10) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="11"
                                                            {{ $role->permissions->contains('id', 11) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="12"
                                                            {{ $role->permissions->contains('id', 12) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="font-weight-semibold">Item Management</td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="13"
                                                            {{ $role->permissions->contains('id', 13) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="14"
                                                            {{ $role->permissions->contains('id', 14) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="15"
                                                            {{ $role->permissions->contains('id', 15) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="16"
                                                            {{ $role->permissions->contains('id', 16) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="font-weight-semibold">Role Management</td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="17"
                                                            {{ $role->permissions->contains('id', 17) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="18"
                                                            {{ $role->permissions->contains('id', 18) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="19"
                                                            {{ $role->permissions->contains('id', 19) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="20"
                                                            {{ $role->permissions->contains('id', 20) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="font-weight-semibold">Order Management</td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="21"
                                                            {{ $role->permissions->contains('id', 21) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="22"
                                                            {{ $role->permissions->contains('id', 22) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="23"
                                                            {{ $role->permissions->contains('id', 23) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td class="text-center">
                                                    <label
                                                        class="custom-control custom-checkbox permission-checkbox success">
                                                        <input type="checkbox"
                                                            class="custom-control-input permission-checkbox"
                                                            name="permission[]" value="24"
                                                            {{ $role->permissions->contains('id', 24) ? 'checked' : '' }}>
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-outline-primary" type="button"
                                    data-bs-dismiss="modal">Close</button>
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
            var isChecked = this.checked;
            permissionCheckboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
        });
    </script>
@endpush
