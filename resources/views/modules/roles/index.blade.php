@section('title', 'Roles')
@extends('dashboard.layouts.app')
@section('content')
<div class="app-content main-content">
    <div class="side-app">
        @include('dashboard.layouts.header')
        <!--Page header-->
        <div class="page-header d-xl-flex d-block">
            <div class="page-leftheader">
                <h4 class="page-title">Role List</h4>
            </div>
            <div class="page-rightheader ms-md-auto">
                <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                    {{-- <div class="btn-list">
                        <a href="{{ route('backend.role.create') }}" class="btn btn-primary"><i
                                class="feather feather-plus fs-15 my-auto me-2"></i>Create
                            New Role</a>

                    </div> --}}
                </div>
            </div>
        </div>
        <!--End Page header-->
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header  border-0">
                        <h4 class="card-title">Role Summary</h4>
                        <div class="ms-auto">
                            <div class="input-group">
                                <input class="form-control" placeholder="Search....." type="text">
                                <span class="input-group-btn">
                                    <button class="btn btn-light br-ts-0 br-bs-0">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-vcenter text-nowrap table-bordered border-bottom"
                                id="project-list">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">#ID</th>
                                        <th class="border-bottom-0">Name</th>

                                        <th class="border-bottom-0">Created at</th>
                                        <th class="border-bottom-0">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            <a href="project-view.html" class="d-flex sidebarmodal-collpase">
                                                <span> {{ $role->name }}</span>
                                            </a>
                                        </td>



                                        <td>{{ $role->created_at }}</td>

                                        <td>
                                            <div class="d-flex">

                                                @if(request('trashed'))
                                                <form action="{{ route('backend.role.permanent.delete', ['id' => $role->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type='submit' class="action-btns1 bg-white"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Permanent Delete Role">
                                                        <i class="feather feather-trash-2 text-danger"></i>
                                                    </button>
                                                </form>

                                                <form action="{{ route('backend.role.restore', ['id' => $role->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')

                                                    <button type="submit" class="action-btns1 bg-white"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Restore Role">
                                                        <i class="feather feather-rotate-ccw text-success"></i>
                                                    </button>

                                                </form>
                                                @else


                                                <a href="{{ route('backend.role.edit',$role->id) }}"
                                                    class="action-btns1 bg-white" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Edit Role"><i
                                                        class="feather feather-edit-2 text-success"></i></a>


                                                <a href="{{ route('backend.permission.show',$role->id) }}"
                                                    class="action-btns1 bg-white" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="View Permissions"><i
                                                        class="feather feather-lock text-primary"></i></a>
                                                <form action="{{ route('backend.role.destroy', ['role' => $role]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type='submit' class="action-btns1 bg-white"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Delete Role">
                                                        <i class="feather feather-trash-2 text-danger"></i>
                                                    </button>
                                                </form>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end app-content-->
@endsection
