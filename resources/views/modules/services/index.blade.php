@extends('dashboard.layouts.app')
@section('content')
    <div class="app-content main-content">
        <div class="side-app">
            @include('dashboard.layouts.header')
            <!--Page header-->
            <div class="page-header d-xl-flex d-block">
                <div class="page-leftheader">
                    <h4 class="page-title">
                        @if (request('trashed'))
                            Deleted
                        @endif Services List
                    </h4>
                </div>
                <div class="page-rightheader ms-md-auto">
                    <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                        <div class="btn-list">
                            @can('service_management', 'create_service')
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#newServiceModal"><i
                                        class="feather feather-plus fs-15 my-auto me-2"></i>Create New Service</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            <!--End Page header-->

            <!-- Row -->
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-12">
                    <div class="card">
                        <a href="#">
                            <div class="card-body text-center">
                                <span
                                    class="avatar avatar-lg bradius fs-20 bg-primary-transparent">{{ $totalServicesCount }}</span>
                                <h5 class="mb-0 mt-3">Total Services</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12">
                    <div class="card">
                        <a href="#">
                            <div class="card-body text-center">
                                <span
                                    class="avatar avatar-lg bradius fs-20 bg-success-transparent">{{ $activeServicesCount }}</span>
                                <h5 class="mb-0 mt-3">Active Services</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12">
                    <div class="card">
                        <a href="#">
                            <div class="card-body text-center">
                                <span
                                    class="avatar avatar-lg bradius fs-20 bg-danger-transparent">{{ $inactiveServicesCount }}</span>
                                <h5 class="mb-0 mt-3">Inactive Services</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12">
                    <div class="card">
                        <a href="#">
                            <div class="card-body text-center">
                                <span
                                    class="avatar avatar-lg bradius fs-20 bg-secondary-transparent">{{ $trashedServicesCount }}</span>
                                <h5 class="mb-0 mt-3">Trashed Services</h5>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
            <!-- End Row-->

            <!-- Row -->
            <div class="row">
                <div class="col-xl-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header  border-0">
                            <h4 class="card-title">Services Summary</h4>
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
                            <form action="{{ route('backend.services.index') }}" method="GET">
                                <div class="row">


                                    <div class="col-md-12 col-xl-5">
                                        <div class="form-group">
                                            <label class="form-label">Select Status:</label>
                                            <select name="status" class="form-control custom-select select2"
                                                data-placeholder="Select Status">
                                                <option label="Select Status"></option>
                                                <option value="Acive">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xl-2">
                                        <div class="form-group mt-5">
                                            <button type="submit" class="btn btn-primary btn-block">Search</button>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-vcenter text-nowrap table-bordered border-bottom"
                                    id="project-list">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">#ID</th>
                                            <th class="border-bottom-0">Name</th>
                                            <th class="border-bottom-0">Icon</th>
                                            <th class="border-bottom-0">Description</th>
                                            <th class="border-bottom-0">Created At</th>
                                            <th class="border-bottom-0">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services as $service)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $service->name }}</td>
                                                <td><i class="{{ $service->icon }}" style="font-size: 24px"></i></td>
                                                <td>
                                                    @if (strlen($service->description) > 40)
                                                        {{ substr($service->description, 0, 40) }}...
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#descriptionModal{{ $service->id }}">Read
                                                            more</a>
                                                        <div class="modal fade" id="descriptionModal{{ $service->id }}"
                                                            tabindex="-1" aria-labelledby="descriptionModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="descriptionModalLabel">
                                                                            Service Description</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <textarea class="form-control b-none" name="description" id="editServiceDescription">  {{ $service->description }} </textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <p>{{ $service->description }}</p>
                                                    @endif
                                                </td>



                                                <style>
                                                    .description-toggle .full-description {
                                                        display: none;
                                                    }

                                                    .description-toggle .full-description.show {
                                                        display: inline;
                                                    }
                                                </style>

                                                <td>{{ $service->created_at->format('F d, Y') }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        @if (request('trashed'))
                                                            <form
                                                                action="{{ route('backend.service.permanent.delete', ['id' => $service->id]) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type='submit' class="action-btns1 bg-white"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Permanent Delete Service">
                                                                    <i class="feather feather-trash-2 text-danger"></i>
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ route('backend.service.restore', ['id' => $service->id]) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="action-btns1 bg-white"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Restore Service">
                                                                    <i class="feather feather-rotate-ccw text-success"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            {{-- <a href="{{ route('backend.service.show', ['service' => $service]) }}"
                                                                class="action-btns1 bg-white" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="View Service">
                                                                <i class="feather feather-eye text-primary"></i>
                                                            </a> --}}
                                                            <a href="#" class="action-btns1 bg-white edit-service"
                                                                data-id="{{ $service->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#editServiceModal"
                                                                data-bs-tooltip="tooltip" data-bs-placement="top"
                                                                title="Edit Service">
                                                                <i class="feather feather-edit-2 text-success"></i>
                                                            </a>
                                                            <form
                                                                action="{{ route('backend.service.destroy', ['service' => $service]) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type='submit' class="action-btns1 bg-white"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Delete Service">
                                                                    <i class="feather feather-trash-2 text-danger"></i>
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ route('backend.service.updateStatus', ['service' => $service]) }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="status"
                                                                    value="{{ $service->status == 'Active' ? 'Inactive' : 'Active' }}">
                                                                <button type="submit" class="action-btns1 bg-white"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ $service->status == 'Active' ? 'Inative service' : 'Activate service' }}">
                                                                    <i
                                                                        class="feather {{ $service->status == 'Active' ? 'feather-x-circle text-danger' : 'feather-check-circle text-success' }}"></i>
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
            <!-- New Service Modal -->
            <div class="modal fade" id="newServiceModal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form action="{{ route('backend.service.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Service</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Service Name:</label>
                                        <input class="form-control" type="text" name="name"
                                            placeholder="Service Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Service Icon:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="serviceIcon"
                                                placeholder="Select an icon" name="icon">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary ">
                                                    <i id="selected-icon" class="fas fa-icons"></i>
                                                </button>
                                                <div class="dropdown-menu IconPickerDropdown">
                                                    <div class="icon-picker">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Description:</label>
                                    <textarea class="form-control" name="description" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-primary"
                                    data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-success" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- New Service Modal End -->

            <!-- Edit Service Modal -->
            <div class="modal fade" id="editServiceModal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form id="editServiceForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Service</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Service Name:</label>
                                        <input class="form-control" type="text" name="name" id="editServiceName"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Service Icon:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="editServiceIcon"
                                                name="icon">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary">
                                                    <i id="editSelectedIcon" class="fas fa-icons"></i>
                                                </button>
                                                <div class="dropdown-menu IconPickerDropdown">
                                                    <div class="icon-picker">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Description:</label>
                                    <textarea class="form-control" name="description" id="editServiceDescription" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-primary"
                                    data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-success" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Service Modal End -->
        </div>
    </div><!-- end app-content-->

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#serviceIcon').iconpicker({
                    placement: 'bottom',
                    animation: false
                });

                $('#serviceIcon').on('iconpickerSelected', function(event) {
                    $('#selected-icon').attr('class', event.iconpickerValue);
                });

                $('#editServiceIcon').iconpicker({
                    placement: 'bottom',
                    animation: false
                });

                $('#editDropdownMenuButton').on('iconpickerSelected', function(event) {
                    $('#editSelectedIcon').attr('class', event.iconpickerValue);
                });

                $('#editServiceIcon').on('iconpickerSelected', function(event) {
                    $('#editSelectedIcon').attr('class', event.iconpickerValue);
                });

                $('.edit-service').on('click', function() {
                    var serviceId = $(this).data('id');

                    $.ajax({
                        url: "{{ route('backend.service.edit', ':serviceId') }}".replace(':serviceId',
                            serviceId),
                        method: 'GET',
                        success: function(data) {
                            console.log(data);
                            $('#editServiceForm').attr('action',
                                "{{ route('backend.service.update', ':serviceId') }}".replace(
                                    ':serviceId', serviceId));
                            $('#editServiceName').val(data.name);
                            $('#editServiceIcon').val(data.icon);
                            $('#editSelectedIcon').attr('class', data.icon);
                            $('#editServiceDescription').val(data.description);
                            $('#editServiceModal').modal('show');
                            $('#editServiceForm').find('input[name="_method"]').val('PUT');

                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
