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
                        @endif Packages List
                    </h4>
                </div>
                <div class="page-rightheader ms-md-auto">
                    <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                        <div class="btn-list">
                            @can('package_management', 'create_package')
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#newPackageModal"><i
                                        class="feather feather-plus fs-15 my-auto me-2"></i>Create New Package</a>
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
                                    class="avatar avatar-lg bradius fs-20 bg-primary-transparent">{{ $totalPackagesCount }}</span>
                                <h5 class="mb-0 mt-3">Total Packages</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12">
                    <div class="card">
                        <a href="#">
                            <div class="card-body text-center">
                                <span
                                    class="avatar avatar-lg bradius fs-20 bg-success-transparent">{{ $activePackagesCount }}</span>
                                <h5 class="mb-0 mt-3">Active Packages</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12">
                    <div class="card">
                        <a href="#">
                            <div class="card-body text-center">
                                <span
                                    class="avatar avatar-lg bradius fs-20 bg-danger-transparent">{{ $inactivePackagesCount }}</span>
                                <h5 class="mb-0 mt-3">Inactive Packages</h5>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12">
                    <div class="card">
                        <a href="#">
                            <div class="card-body text-center">
                                <span
                                    class="avatar avatar-lg bradius fs-20 bg-secondary-transparent">{{ $trashedPackagesCount }}</span>
                                <h5 class="mb-0 mt-3">Trashed Packages</h5>
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
                            <h4 class="card-title">Packages Summary</h4>
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
                            <form action="{{ route('backend.packages.index') }}" method="GET">
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
                                            <th class="border-bottom-0">Price</th>
                                            <th class="border-bottom-0">Created At</th>
                                            <th class="border-bottom-0">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($packages as $package)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $package->name }}</td>
                                                <td>{{ $package->price }}</td>
                                                <td>{{ $package->created_at->format('F d, Y') }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        @if (request('trashed'))
                                                            <form
                                                                action="{{ route('backend.package.permanent.delete', ['id' => $package->id]) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type='submit' class="action-btns1 bg-white"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Permanent Delete Pacakge">
                                                                    <i class="feather feather-trash-2 text-danger"></i>
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ route('backend.package.restore', ['id' => $package->id]) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="action-btns1 bg-white"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Restore Package">
                                                                    <i class="feather feather-rotate-ccw text-success"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <a href="#" class="action-btns1 bg-white edit-package"
                                                                data-id="{{ $package->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#editPackageModal" data-bs-tooltip="tooltip"
                                                                data-bs-placement="top" title="Edit Package">
                                                                <i class="feather feather-edit-2 text-success"></i>
                                                            </a>

                                                            <form
                                                                action="{{ route('backend.package.destroy', ['package' => $package]) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type='submit' class="action-btns1 bg-white"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Delete Package">
                                                                    <i class="feather feather-trash-2 text-danger"></i>
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ route('backend.package.updateStatus', ['package' => $package]) }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="status"
                                                                    value="{{ $package->status == 'Active' ? 'Inactive' : 'Active' }}">
                                                                <button type="submit" class="action-btns1 bg-white"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ $package->status == 'Active' ? 'Inactive package' : 'Activate package' }}">
                                                                    <i
                                                                        class="feather {{ $package->status == 'Active' ? 'feather-x-circle text-danger' : 'feather-check-circle text-success' }}"></i>
                                                                </button>
                                                            </form>
                                                            <a href="{{ route('backend.items.index', ['package' => $package]) }}"
                                                                class="action-btns1 bg-white" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="View Items">
                                                                <i class="feather feather-eye text-primary"></i>
                                                            </a>
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
            <!-- New Package Modal -->
            <div class="modal fade" id="newPackageModal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form action="{{ route('backend.package.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Package</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" id="item-list">
                                <div class="row mt-3">
                                    <div class="col">
                                        <button type="button" class="btn btn-primary float-end" id="add-item">Add New
                                            Item</button>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Servcies:</label>

                                        <select name="service_id" class="form-control">
                                            <option disabled selected>Select Service</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Package Name:</label>
                                        <input class="form-control" type="text" name="package_name"
                                            placeholder="Package Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Package Price:</label>
                                        <input class="form-control" type="text" name="package_price"
                                            placeholder="Package Price" required>
                                    </div>
                                </div>
                                <!-- Default item row -->
                                <div class="row mb-3 item-row">
                                    <div class="col-md-6">
                                        <label class="form-label">Item Name:</label>
                                        <input class="form-control" type="text" name="item_name[]"
                                            placeholder="Item Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Item Price:</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input class="form-control" type="number" step="0.01"
                                                name="item_price[]" placeholder="Item Price" required>
                                        </div>
                                    </div>

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


            <!-- New Package Modal End -->

            <!-- Edit Package Modal -->
            <div class="modal fade" id="editPackageModal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form id="editPackageForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Package</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Package Name:</label>
                                        <input class="form-control" type="text" name="name" id="editPackageName"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Package Price:</label>
                                        <input class="form-control" type="text" name="price" id="editPackagePrice"
                                            required>
                                    </div>
                                </div>
                                <!-- Edit Item Section -->
                                <hr>
                                <h5>Edit Items</h5>
                                <div id="editItemContainer">
                                    <!-- Items will be dynamically added here -->
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


        </div>
    </div><!-- end app-content-->

    @push('scripts')
        <script>
            let itemCounter = 0;

            $(document).ready(function() {

                $('.edit-package').on('click', function() {
                    var packageId = $(this).data('id');

                    $.ajax({
                        url: "{{ route('backend.package.edit', ':packageId') }}".replace(':packageId',
                            packageId),
                        method: 'GET',
                        success: function(data) {
                            console.log(data);
                            $('#editPackageForm').attr('action',
                                "{{ route('backend.package.update', ':packageId') }}".replace(
                                    ':packageId', packageId));
                            $('#editPackageName').val(data.name);
                            $('#editPackagePrice').val(data.price);

                            // Populate items
                            $('#editItemContainer').empty(); // Clear existing items
                            if (data.items.length > 0) {
                                data.items.forEach(function(item, index) {
                                    var itemHtml = `
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Item Name:</label>
                                    <input class="form-control" type="text" name="items[${index}][name]" value="${item.name}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Item Price:</label>
                                    <input class="form-control" type="text" name="items[${index}][price]" value="${item.price}" required>
                                </div>
                            </div>
                        `;
                                    $('#editItemContainer').append(itemHtml);
                                });
                            }

                            $('#editPackageModal').modal('show');
                            $('#editPackageForm').find('input[name="_method"]').val('PUT');
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                });
                // Add new item button click event
                $('#add-item').click(function() {
                    addNewItem();
                });

                // Remove item button click event
                $(document).on('click', '.btn-remove-item', function() {
                    let itemIndex = $(this).data('item');
                    let itemRow = $(this).closest('.item-row');

                    if ($('#item-list').children('.item-row').length > 1) {
                        itemRow.remove();
                    }
                });

                function addNewItem() {
                    itemCounter++;
                    let newItemRow = `
                    <div class="row mb-3 item-row">
                        <div class="col-md-6">
                            <label class="form-label">Item Name:</label>
                            <input class="form-control" type="text" name="item_name[]" placeholder="Item Name" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Item Price:</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input class="form-control" type="number" step="0.01" name="item_price[]" placeholder="Item Price" required>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label"></label>
                            <button type="button" class="btn btn-danger btn-remove-item mt-4" data-item="${itemCounter}"><i class="feather feather-trash sidemenu_icon"></i></button>
                        </div>
                    </div>`;

                    // Append new item row
                    $('#item-list').append(newItemRow);
                }
            });
        </script>
    @endpush
@endsection
