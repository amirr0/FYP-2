@extends('dashboard.layouts.app')

@section('content')
    <div class="app-content main-content">
        <div class="side-app">
            @include('dashboard.layouts.header')
            <!--Page header-->
            <div class="page-header d-xl-flex d-block">
                <div class="page-leftheader">
                    <h4 class="page-title">
                        Orders List
                    </h4>
                </div>
                <div class="page-rightheader ms-md-auto">
                    <div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
                        <!-- Add any additional buttons or controls here -->
                    </div>
                </div>
            </div>
            <!--End Page header-->
            <!-- Row -->
            <div class="row">
                <div class="col-xl-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h4 class="card-title">Orders Summary</h4>
                            <!-- Add search or filter options if needed -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-vcenter text-nowrap table-bordered border-bottom" id="order-list">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">#ID</th>
                                            <th class="border-bottom-0">Client</th>
                                            <th class="border-bottom-0">Total Price</th>
                                            <th class="border-bottom-0">Status</th>
                                            <th class="border-bottom-0">Progress</th>

                                            <th class="border-bottom-0">Vendor Name</th>
                                            <th class="border-bottom-0">Created At</th>
                                            <th class="border-bottom-0">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            @php
                                                $statusColors = [
                                                    'Pending' => 'badge-warning',
                                                    'Approved' => 'badge-success',
                                                    'Assigned' => 'badge-primary',
                                                    'In Progress' => 'badge-info',
                                                    'Rejected' => 'badge-danger',
                                                    'Cancelled' => 'badge-secondary',
                                                    'Awaiting Payment' => 'badge-warning',
                                                ];

                                                $statusActions = [
                                                    'Pending' => ['Approved', 'Rejected'],
                                                    'Approved' => ['Assigned', 'Rejected'],
                                                    'Assigned' => ['In Progress', 'Cancelled'],
                                                    'In Progress' => ['Cancelled', 'Awaiting Payment'],
                                                    'Awaiting Payment' => ['Cancelled', 'Completed'],
                                                    'Completed' => [],
                                                    'Rejected' => [],
                                                    'Cancelled' => [],
                                                ];
                                            @endphp
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->client->first_name . ' ' . $order->client->last_name }}</td>
                                                <td>{{ $order->total_price }}</td>



                                                <td>
                                                    <span
                                                        class="badge {{ $statusColors[$order->status] ?? 'badge-light' }}">
                                                        {{ $order->status }}
                                                    </span>
                                                </td>
                                                <td class="align-middle" style="width: 14%; ">
                                                    <div class="float-end">
                                                        <h6 class="mb-2 ms-4 fw-semibold">{{ $order->progress_percentage }}%
                                                        </h6>
                                                    </div>
                                                    <div class="progress progress-sm mb-0 mt-1">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                            style="width: {{ $order->progress_percentage }}%"></div>
                                                    </div>

                                                </td>




                                                <td>{{ $order->assignedUser ? $order->assignedUser->first_name . ' ' . $order->assignedUser->last_name : 'Not Assigned' }}
                                                </td>

                                                <td>{{ $order->created_at->format('F d, Y') }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="javascript:void(0)" data-order-id="{{ $order->id }}"
                                                            class="action-btns1 bg-white view-order-btn"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="View Order">
                                                            <i class="feather feather-eye text-primary"></i>
                                                        </a>

                                                        @if ($order->status == 'Awaiting Payment')
                                                            <a class="action-btns1 bg-white upload-payment-proof"
                                                                href="javascript:void(0)"
                                                                data-order-id="{{ $order->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#paymentProofModal"
                                                                title="Add Payment Proof">
                                                                <i class="feather feather-upload"></i>
                                                            </a>
                                                        @endif

                                                        <a class="action-btns1 bg-white upload-payment-proof"
                                                            href="javascript:void(0)" data-order-id="{{ $order->id }}"
                                                           
                                                            title="Add Payment Proof">
                                                            <i class="feather feather-upload"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#proofModal{{ $order->id }}">
                                                            View Payment Proofs
                                                        </button>

                                                        @if (in_array(Auth::user()->role->name, ['Admin', 'Vendor']))
                                                            <a href="javascript:void(0)"
                                                                data-order-id="{{ $order->id }}"
                                                                class="action-btns1 bg-white update-item-progress-btn"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Update Progress">
                                                                <i class="feather feather-edit-2 text-primary"></i>
                                                            </a>

                                                            <div class="dropdown ms-2">
                                                                <button
                                                                    class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                                    type="button"
                                                                    id="dropdownMenuButton{{ $order->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                    Change Status
                                                                </button>
                                                                <ul class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton{{ $order->id }}">
                                                                    @foreach ($statusActions[$order->status] as $action)
                                                                        @if (Auth::user()->role->name == 'Admin' && $action === 'Assigned')
                                                                            <li>
                                                                                <button type="button"
                                                                                    class="dropdown-item assign-vendor-btn"
                                                                                    data-order-id="{{ $order->id }}"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#assignVendorModal">
                                                                                    {{ $action }}
                                                                                </button>
                                                                            </li>
                                                                        @else
                                                                            <li>
                                                                                <form
                                                                                    action="{{ route('orders.updateStatus', $order->id) }}"
                                                                                    method="POST" style="display:inline;">
                                                                                    @csrf
                                                                                    @method('PATCH')
                                                                                    <input type="hidden" name="status"
                                                                                        value="{{ $action }}">
                                                                                    <button type="submit"
                                                                                        class="dropdown-item">{{ $action }}</button>
                                                                                </form>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>


                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Assign Vendor Modal Start -->
                                <div class="modal fade" id="AssignVendorModal" tabindex="-1"
                                    aria-labelledby="AssignVendorModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <form action="{{ route('orders.assign') }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="assignVendorModalLabel">Assign Vendor</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Select a vendor to assign to this order.</p>
                                                    <select name="vendor_id" class="form-control">
                                                        @foreach ($vendors as $vendor)
                                                            <option value="{{ $vendor->id }}">
                                                                {{ $vendor->first_name . ' ' . $vendor->last_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <input type="hidden" name="order_id" class="assign_order_id">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Assign To
                                                        Vendor</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Assign Vendor Modal End -->
                                <!-- Payment Proof Modal Start -->
                                <div class="modal fade" id="paymentProofModal" tabindex="-1"
                                    aria-labelledby="paymentProofModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form id="paymentProofForm" action="{{ route('payment.proof.submit') }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="paymentProofModalLabel">Submit Payment
                                                        Proof</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="transaction_id" class="form-label">Transaction
                                                            ID</label>
                                                        <input type="text" class="form-control" id="transaction_id"
                                                            name="transaction_id" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="payment_proof" class="form-label">Payment
                                                            Proof</label>
                                                        <input type="file" class="form-control" id="payment_proof"
                                                            name="payment_proof" required>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="order_id" class="order_id">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Payment Proof Modal End -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewOrderModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Service Name:</label>
                            <input class="form-control" type="text" id="serviceName" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Package Name:</label>
                            <input class="form-control" type="text" id="packageName" readonly>
                        </div>
                    </div>
                    <!-- Items Section -->
                    <hr>
                    <h5>Ordered Items</h5>
                    <div id="orderedItemsContainer">
                        <!-- Items will be dynamically added here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateItemProgressModal" tabindex="-1" aria-labelledby="updateItemProgressModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="updateItemProgressForm" action="{{ route('orders.updateProgress') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateItemProgressModalLabel">Update Item Progress</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="orderItemsContainer">
                        <!-- Dynamic content will be inserted here -->
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="order_id" class="progress_order_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Progress</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.view-order-btn').click(function() {
                    var orderId = $(this).data('order-id');
                    $.ajax({
                        url: "{{ route('orders.show', '') }}" + "/" + orderId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            // Populate order details in the modal
                            $('#serviceName').val(response.order.service_name);
                            $('#packageName').val(response.order.package_name);

                            // Clear previous items and populate new items
                            $('#orderedItemsContainer').empty();
                            response.items.forEach(function(item) {
                                var itemHtml =
                                    '<div class="row mb-3">' +
                                    '<div class="col-md-4">' +
                                    '<label class="form-label">Item Name:</label>' +
                                    '<input class="form-control" type="text" readonly value="' +
                                    item.name + '">' +
                                    '</div>' +
                                    '<div class="col-md-4">' +
                                    '<label class="form-label">Item Price:</label>' +
                                    '<input class="form-control" type="text" readonly value="' +
                                    item.price + '">' +
                                    '</div>' +
                                    '<div class="col-md-4">' +
                                    '<input type="hidden" name="item_ids[]" value="' + item
                                    .id + '">' +
                                    '<div id="slider-' + item.id +
                                    '" class="noUi-target noUi-ltr noUi-horizontal noUi-txt-dir-ltr"></div>' +
                                    '<input type="hidden" id="progress-percentage-' + item
                                    .id + '" name="progress_percentage[]" value="' + item
                                    .progress_percentage + '">' +
                                    '<div id="slider-value-' + item.id +
                                    '" class="value-display">' + item.progress_percentage +
                                    '%</div>' +
                                    '</div>' +
                                    '</div>';

                                $('#orderedItemsContainer').append(itemHtml);

                                // Initialize slider for this item
                                var slider = document.getElementById('slider-' + item.id);
                                var sliderValue = document.getElementById('slider-value-' +
                                    item.id);
                                var hiddenInput = document.getElementById(
                                    'progress-percentage-' + item.id);

                                noUiSlider.create(slider, {
                                    start: [item.progress_percentage],
                                    range: {
                                        'min': 0,
                                        'max': 100
                                    },
                                    tooltips: false,
                                    connect: [true, false]
                                });

                                // Disable slider handles (make read-only)
                                slider.noUiSlider.updateOptions({
                                    start: [item
                                        .progress_percentage
                                    ], // Ensure the start value is set
                                    disabled: true // Disable user interaction
                                });

                                slider.noUiSlider.on('update', function(values, handle) {
                                    var intValue = parseInt(values[handle]);
                                    sliderValue.innerHTML = intValue + '%';
                                    hiddenInput.value = intValue;
                                });
                            });

                            $('#viewOrderModal').modal('show');
                        },
                        error: function() {
                            alert('Error fetching order details');
                        }
                    });
                });


                $('.upload-payment-proof').click(function(e) {
                    e.preventDefault();
                    var orderId = $(this).data('order-id');
                    $('.order_id').val(orderId);
                    $('#paymentProofModal').modal('show');
                });


                $('.assign-vendor-btn').click(function(e) {
                    e.preventDefault();
                    var orderId = $(this).data('order-id');
                    $('.assign_order_id').val(orderId);
                    $('#AssignVendorModal').modal('show');
                });
                $('.assign-vendor-btn').click(function(e) {
                    e.preventDefault();
                    var orderId = $(this).data('order-id');
                    $('.assign_order_id').val(orderId);
                    $.ajax({
                        url: "{{ route('orders.show', '') }}" + "/" + orderId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {

                        },
                        error: function() {
                            alert('Error fetching order details');
                        }
                    });
                });



                $('.update-item-progress-btn').click(function() {
                    var orderId = $(this).data('order-id');
                    $('.progress_order_id').val(orderId);

                    $.ajax({
                        url: "{{ route('orders.show', '') }}" + "/" + orderId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            $('#orderItemsContainer').empty();

                            response.items.forEach(function(item) {
                                var itemHtml =
                                    '<div class="row mb-3">' +
                                    '<div class="col-md-4">' +
                                    '<label class="form-label">Item Name:</label>' +
                                    '<input class="form-control" type="text" readonly value="' +
                                    item.name + '">' +
                                    '</div>' +
                                    '<div class="col-md-4">' +
                                    '<label class="form-label">Item Price:</label>' +
                                    '<input class="form-control" type="text" readonly value="' +
                                    item.price + '">' +
                                    '</div>' +
                                    '<div class="col-md-4">' +
                                    '<input type="hidden" name="item_ids[]" value="' + item
                                    .id + '">' +
                                    '<div id="slider-' + item.id +
                                    '" class="noUi-target noUi-ltr noUi-horizontal noUi-txt-dir-ltr"></div>' +
                                    '<input type="hidden" id="progress-percentage-' + item
                                    .id + '" name="progress_percentage[]" value="' + item
                                    .progress_percentage + '">' +
                                    '<div id="slider-value-' + item.id +
                                    '" class="value-display">' + item.progress_percentage +
                                    '%</div>' +
                                    '</div>' +
                                    '</div>';

                                $('#orderItemsContainer').append(itemHtml);

                                var slider = document.getElementById('slider-' + item.id);
                                var sliderValue = document.getElementById('slider-value-' +
                                    item.id);
                                var hiddenInput = document.getElementById(
                                    'progress-percentage-' + item.id);

                                noUiSlider.create(slider, {
                                    start: [item.progress_percentage],
                                    range: {
                                        'min': 0,
                                        'max': 100
                                    },
                                    tooltips: false,
                                    connect: [true, false]
                                });

                                slider.noUiSlider.on('update', function(values, handle) {
                                    var intValue = parseInt(values[handle]);
                                    sliderValue.innerHTML = intValue + '%';
                                    hiddenInput.value = intValue;
                                });
                            });

                            $('#updateItemProgressModal').modal('show');
                        },
                        error: function() {
                            alert('Error fetching order details');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
