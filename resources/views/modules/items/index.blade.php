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
                        @endif Items List
                    </h4>
                </div>
                <div class="page-rightheader ms-md-auto">
                    <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                        <div class="btn-list">
                            @can('item_management', 'create_item')
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#newPackageModal"><i
                                        class="feather feather-plus fs-15 my-auto me-2"></i>Create New Item</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            <!--End Page header-->
            <!-- Row -->
            <div class="row">
                <div class="col-xl-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header  border-0">
                            <h4 class="card-title">Items Summary</h4>
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
                                            <th>#ID</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Created At</th>
                                            <th class="border-bottom-0">Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>{{ $item->created_at->format('F d, Y') }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        @if (request('trashed'))
                                                            <form
                                                                action="{{ route('backend.item.permanent.delete', ['id' => $item->id]) }}"
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
                                                                action="{{ route('backend.item.restore', ['id' => $item->id]) }}"
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
                                                            <a href="#" class="action-btns1 bg-white edit-item"
                                                                data-id="{{ $item->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#editItemModal" data-bs-tooltip="tooltip"
                                                                data-bs-placement="top" title="Edit Item">
                                                                <i class="feather feather-edit-2 text-success"></i>
                                                            </a>
                                                            <form action="{{ route('backend.item.destroy', ['item' => $item]) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type='submit' class="action-btns1 bg-white"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Delete Item">
                                                                    <i class="feather feather-trash-2 text-danger"></i>
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ route('backend.item.updateStatus', ['item' => $item]) }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="status"
                                                                    value="{{ $item->status == 'Active' ? 'Inactive' : 'Active' }}">
                                                                <button type="submit" class="action-btns1 bg-white"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="{{ $item->status == 'Active' ? 'Inactive item' : 'Activate item' }}">
                                                                    <i
                                                                        class="feather {{ $item->status == 'Active' ? 'feather-x-circle text-danger' : 'feather-check-circle text-success' }}"></i>
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
            <!-- New Package Modal -->
            <div class="modal fade" id="newPackageModal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form action="{{ route('backend.item.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Item</h5>
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
                                <div class="row mb-3 item-row">
                                    <div class="col-md-12">
                                        <label class="form-label">Packages:</label>
                                        <select name="package_id" class="form-control">
                                            <option readonly selected disabled>Select Package</option>
                                            @foreach ($packages as $package)
                                                <option value="{{ $package->id }}">{{ $package->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="row mb-3 item-row">
                                    <div class="col-md-6">
                                        <label class="form-label">Item Name:</label>
                                        <input class="form-control" type="text" name="item_name[]"
                                            placeholder="Item Name" required>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Item Price:</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input class="form-control" type="number" step="0.01"
                                                name="item_price[]" placeholder="Item Price" required>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label"></label>
                                        <!-- Initially hidden delete button for the first row -->
                                        <button type="button" class="btn btn-danger btn-remove-item mt-4" data-item="1"
                                            style="display: none;"><i
                                                class="feather feather-trash sidemenu_icon"></i></button>
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
            <div class="modal fade" id="editItemModal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <form id="editServiceForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Item Name:</label>
                                        <input class="form-control" type="text" name="name" id="editItemName"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Item Price:</label>
                                        <input class="form-control" type="text" name="price" id="editItemPrice"
                                            required>
                                    </div>

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
            <!-- Edit Package Modal End -->
        </div>
    </div><!-- end app-content-->

    @push('scripts')
        <script>
            let itemCounter = 0;

            $(document).ready(function() {

                $('.edit-item').on('click', function() {
                    var itemId = $(this).data('id');

                    $.ajax({
                        url: "{{ route('backend.item.edit', ':itemId') }}".replace(':itemId',
                            itemId),
                        method: 'GET',
                        success: function(data) {
                            console.log(data);
                            $('#editServiceForm').attr('action',
                                "{{ route('backend.item.update', ':itemId') }}".replace(
                                    ':itemId', itemId));
                            $('#editItemName').val(data.name);
                            $('#editItemPrice').val(data.price);
                            $('#editItemModal').modal('show');
                            $('#editServiceForm').find('input[name="_method"]').val('PUT');

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
