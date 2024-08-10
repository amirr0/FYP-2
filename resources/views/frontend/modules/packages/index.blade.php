@extends('frontend.layouts.app')
@section('title', 'Packages')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <section id="custom-form">
        <div class="container mt-3">
            <div class="setup-business-account">
                <h2>Service Name</h2>
                <div class="accordion">
                    @foreach ($packages as $package)
                        <div class="quest-section">
                            <div class="ct-accor">
                                <a class="quest-title show-accordion" data-package-id="{{ $package->id }}">
                                    <p>{{ $package->name }}</p>
                                    <span>$ {{ $package->price }}</span>
                                </a>
                                <div class="checkbox-ct">
                                    <label class="ct-container">
                                        <input type="checkbox" value="{{ $package->price }}"
                                            data-package-id="{{ $package->id }}"
                                            onchange="selectPackage({{ $package->id }});" class="package-checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="quest-content accordion-content" id="accordion-{{ $package->id }}">
                                <ul>
                                    @foreach ($package->items as $item)
                                        <li>
                                            <label class="ct-container">{{ $item->name }}
                                                <input type="checkbox" value="{{ $item->price }}"
                                                    data-item-id="{{ $item->id }}"
                                                    data-package-id="{{ $package->id }}" onchange="calculateTotal();"
                                                    class="item-checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                            <p>$ {{ $item->price }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="grandTotalBtn" class="total-amount">
                <div class="total-amount-inner">
                    <h6>Total Amount</h6>
                    <p id="grand-total">$ 0</p>
                </div>
                <div class="total-amount-cart mt-lg-0 mt-2">
                    @if (Auth::check())
                        <a href="javascript:;" class="w-100" id="order-btn">
                            <i class="fa fa-check"></i>
                            <p>Order Now</p>
                        </a>
                    @else
                        <a href="{{ route('showLoginForm') }}">Login First!</a>
                    @endif
                </div>
            </div>
        </div>


    </section>


    <div class="modal fade" id="paymentOptionModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Choose Payment Method {{ env('STRIPE_KEY') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-secondary" id="uploadProofButton">Upload Payment Proof</button>
                        <button class="btn btn-primary" id="stripeButton">Pay with Stripe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Proof Modal Start -->
    <div class="modal fade" id="paymentProofModal" tabindex="-1" aria-labelledby="viewpaymentProofModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="paymentProofForm" action="{{ route('payment.proof.submit') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewpaymentProofModalLabel">Submit Payment Proof</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Display account details -->
                        <div class="alert alert-info" role="alert">
                            <strong>Account Details:</strong>
                            <p class="m-0 p-1"><strong> Account Title:</strong> Bentico LLC</p>
                            <p class="m-0 p-1"><strong>Account Number:</strong> +92 316 2971311</p>
                            <p class="m-0 p-1"><strong>Bank Name:</strong> EasyPaisa</p>
                        </div>

                        <div class="mb-3">
                            <label for="transaction_id" class="form-label">Transaction ID</label>
                            <input type="text" class="form-control" id="transaction_id" name="transaction_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>

                        <div class="mb-3">
                            <label for="payment_proof" class="form-label">Payment Proof</label>
                            <input type="file" class="form-control" id="payment_proof" name="payment_proof" required>
                        </div>
                    </div>
                    <input type="hidden" name="order_id" class="order_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Stripe Payment Modal -->
    <div class="modal fade" id="stripeModal" tabindex="-1" aria-labelledby="stripeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stripeModalLabel">Stripe Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('payment.processStripe') }}" method="POST" id="stripe-payment-form">
                        @csrf
                        <div id="card-element">
                            <!-- Stripe Element will be inserted here -->
                        </div>
                        <input type="hidden" name="order_id" class="order_id">
                        <button type="submit" class="btn btn-primary mt-3" id="submit-stripe">Pay with Stripe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function selectPackage(packageId) {
            var isChecked = $('input[data-package-id="' + packageId + '"].package-checkbox').prop('checked');

            // Check/uncheck all items within the package
            $('.item-checkbox[data-package-id="' + packageId + '"]').prop('checked', isChecked);

            calculateTotal();
        }

        function calculateTotal() {
            var totalAmount = 0;

            // Calculate the total for selected packages
            $('.package-checkbox:checked').each(function() {
                totalAmount += parseFloat($(this).val());
            });

            // Calculate the total for individually selected items
            $('.item-checkbox').each(function() {
                var packageId = $(this).data('package-id');
                // Only add item price if the package itself is not selected
                if (!$('input[data-package-id="' + packageId + '"].package-checkbox').prop('checked')) {
                    if ($(this).prop('checked')) {
                        totalAmount += parseFloat($(this).val());
                    }
                }
            });

            $('#grand-total').text('$ ' + totalAmount.toFixed(2));
        }

        $(document).ready(function() {
            $('.show-accordion').click(function() {
                var packageId = $(this).data('package-id');
                $('#accordion-' + packageId).slideToggle(300);
            });





            $('#order-btn').click(function() {
                $('#paymentOptionModal').modal('show');
            });


            $('#uploadProofButton').click(function(e) {
                e.preventDefault();
                $('#paymentOptionModal').modal('hide');
                $('#paymentProofModal').modal('show');
            });

            $('#stripeButton').click(function() {
                $('#paymentOptionModal').modal('hide');
                $('#paymentModal').modal('hide');
                $('#stripeModal').modal('show');
                initializeStripe();
            });


            $(document).on('submit', '#paymentProofForm', function(e) {
                e.preventDefault();
                var selectedItems = [];
                var totalAmount = parseFloat($('#grand-total').text().replace('$ ', ''));

                $('.package-checkbox:checked').each(function() {
                    var packageId = $(this).data('package-id');
                    selectedItems.push({
                        id: packageId,
                        type: 'package',
                        price: parseFloat($(this).val())
                    });

                    // Add all items of this package as individual items
                    $('.item-checkbox[data-package-id="' + packageId + '"]:checked').each(
                        function() {
                            selectedItems.push({
                                id: $(this).data('item-id'),
                                type: 'item',
                                price: parseFloat($(this).val())
                            });
                        });
                });

                $('.item-checkbox:checked').each(function() {
                    var packageId = $(this).data('package-id');
                    if (!$('input[data-package-id="' + packageId + '"].package-checkbox').prop(
                            'checked')) {
                        selectedItems.push({
                            id: $(this).data('item-id'),
                            type: 'item',
                            price: parseFloat($(this).val())
                        });
                    }
                });
                var transaction_id = $('#transaction_id').val();
                var payment_proof = $('#payment_proof')[0].files[0];

                var formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('transaction_id', transaction_id);
                formData.append('payment_proof', payment_proof);
                formData.append('total_price', totalAmount); // Add other data
                formData.append('items', JSON.stringify(
                    selectedItems)); // Convert array/object to JSON string if needed

                $.ajax({
                    url: '{{ route('order.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false, // Don't process the data
                    contentType: false, // Don't set content-type header
                    success: function(response) {
                        $('#paymentProofModal').modal('hide');
                        $('#paymentProofForm')[0].reset();
                        flasher.success(response.message); // Show success message
                    },
                    error: function(response) {
                        flasher.error('Error placing order'); // Show error message
                        alert('Error placing order');
                    }
                });
            });

            let stripe;
            let cardElement;

            function initializeStripe() {
                stripe = Stripe(
                    'pk_test_51PdpVRG5pw69iY75jmpT3xfAzYr38y3ilgVPlKKPnCvlXZcbBQ6Xfx0Bm4BmnADCIZbM1oLk8bykDt8JR3P1lFQs00VhyGESI9'
                );
                const elements = stripe.elements();
                cardElement = elements.create('card');
                cardElement.mount('#card-element');
            }

            // Initialize Stripe when the page loads
            document.addEventListener('DOMContentLoaded', function() {
                initializeStripe();
            });

            const stripeForm = document.getElementById('stripe-payment-form');
            stripeForm.addEventListener('submit', async (event) => {
                event.preventDefault();

                // Ensure stripe and cardElement are initialized
                if (!stripe || !cardElement) {
                    console.error("Stripe is not initialized properly.");
                    return;
                }

                const {
                    token,
                    error
                } = await stripe.createToken(cardElement);

                if (error) {
                    console.error(error.message);
                    document.getElementById('card-errors').textContent = error.message;
                } else {
                    var selectedItems = [];
                    var totalAmount = parseFloat($('#grand-total').text().replace('$ ', ''));

                    $('.package-checkbox:checked').each(function() {
                        var packageId = $(this).data('package-id');
                        selectedItems.push({
                            id: packageId,
                            type: 'package',
                            price: parseFloat($(this).val())
                        });

                        $('.item-checkbox[data-package-id="' + packageId + '"]:checked').each(
                            function() {
                                selectedItems.push({
                                    id: $(this).data('item-id'),
                                    type: 'item',
                                    price: parseFloat($(this).val())
                                });
                            });
                    });

                    $('.item-checkbox:checked').each(function() {
                        var packageId = $(this).data('package-id');
                        if (!$('input[data-package-id="' + packageId + '"].package-checkbox')
                            .prop('checked')) {
                            selectedItems.push({
                                id: $(this).data('item-id'),
                                type: 'item',
                                price: parseFloat($(this).val())
                            });
                        }
                    });


                    var formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('stripeToken', token.id);
                    formData.append('total_price', totalAmount);
                    formData.append('items', JSON.stringify(
                        selectedItems));

                    $.ajax({
                        url: '{{ route('order.store.stripe') }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('#stripeModal').modal('hide');
                            $('#stripe-payment-form')[0].reset();
                            flasher.success(response.message);
                        },
                        error: function(response) {
                            flasher.error('Error placing order');
                            alert('Error placing order');
                        }
                    });
                }
            });
        });
    </script>

    <script src="https://js.stripe.com/v3/"></script>
@endpush
