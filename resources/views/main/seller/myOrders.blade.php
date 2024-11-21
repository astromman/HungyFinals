@extends('layouts.seller.sellerMaster')

@section('content')
<div class="pt-3">
    <div class="py-2">
        <h2>My Orders</h2>
    </div>
    <div class="pt-3">
        <legend>Legends</legend>
        <div class="pt-2">
            <table class="table table-responsive table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>Color</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <td class="bg-success-subtle text-success fw-bold">Green</td>
                        <td>Ready or Completed</td>
                    </tr>
                    <tr>
                        <td class="bg-warning-subtle text-warning fw-bold">Yellow</td>
                        <td>Pending</td>
                    </tr>
                    <tr>
                        <td class="bg-info-subtle text-info fw-bold">Cyan</td>
                        <td>Preparing</td>
                    </tr>
                    <tr>
                        <td class="bg-primary-subtle text-primary fw-bold">Blue</td>
                        <td>Enabled</td>
                    </tr>
                    <tr>
                        <td class="bg-secondary-subtle text-secondary fw-bold">Gray</td>
                        <td>Disabled</td>
                    </tr>
                </tbody>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class="py-3">
        <div class="row">
            @forelse($orders as $order)
            <div class="col-12 col-md-6 col-lg-4 pb-3">
                <div class="card" style="width: 21.5rem; height: 33rem;">
                    <div class="card-body">
                        <span>Customer: {{ $order->first_name . ' ' . $order->last_name }}</span>
                        <div class="pb-3">
                            <div>
                                <span>Reference: {{ $order->order_reference }}</span>
                            </div>
                            <div>
                                <span>Created At: {{ $order->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <h5 class="card-title">Payment Reference</h5>
                        <div class="pb-3">
                            <button type="button"
                                class="btn fw-bold rounded-pill w-100 p-1 
                                {{ 
                                    $order->payment_status == 'Pending' ? 'bg-warning-subtle text-warning' : 'bg-success-subtle text-success' 
                                }}"
                                data-bs-toggle="modal"
                                data-bs-target="#viewPaymentModal"
                                data-payment-image="{{ asset('storage/payments/' . $order->payment_id) }}"
                                data-order-id="{{ $order->id }}"
                                data-order-reference="{{ $order->order_reference }}"
                                data-payment-status="{{ $order->payment_status }}"
                                data-customer-name="{{ $order->first_name . ' ' . $order->last_name }}">View Payment</button>
                        </div>

                        <!-- ORDER STATUS -->
                        <h5 class="card-title">Order Status</h5>
                        <div class="pb-3">
                            <form id="orderStatusForm{{ $order->order_reference }}" method="POST" action="{{ route('update.order', $order->order_reference) }}" onsubmit="return handleFormSubmit(event, '{{ $order->order_reference }}')">
                                @csrf
                                <div class="d-flex justify-content-between align-items-center pb-3 card-status-btn">
                                    <input class="order-status" type="hidden" value="{{$order->order_status }}" />
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- Pending Radio Button -->
                                        <div class="pending-status">
                                            <input type="radio" class="btn-check " name="order_status" id="pendingRadio{{ $order->order_reference }}"
                                                value="Pending"
                                                autocomplete="off"
                                                {{ $order->payment_status != 'Completed' ? 'disabled' : '' }}
                                                {{ $order->order_status == 'Pending' && $order->payment_status == 'Completed' ? 'checked' : '' }}
                                                {{ $order->order_status == 'Preparing' || $order->order_status == 'Ready' ? 'disabled' : '' }}>

                                            <label class="btn fw-bold rounded-pill p-1 me-3
                                                {{ $order->payment_status == 'Completed' ? 'bg-warning-subtle text-warning' : 'bg-secondary-subtle text-secondary' }}"
                                                for="pendingRadio{{ $order->order_reference }}">
                                                Pending
                                            </label>
                                        </div>

                                        <div class="pending-to-preparing me-3 fw-bold text-primary">
                                            <i class="bi bi-chevron-double-right"></i>
                                        </div>

                                        <!-- Preparing Radio Button -->
                                        <div class="preparing-status">
                                            <input type="radio" class="btn-check preparing-status" name="order_status" id="preparingRadio{{ $order->order_reference }}"
                                                value="Preparing"
                                                autocomplete="off"
                                                {{ $order->payment_status != 'Completed' ? 'disabled' : '' }}
                                                {{ $order->order_status == 'Preparing' ? 'checked' : '' }}
                                                {{ $order->order_status == 'Ready' ? 'disabled' : '' }}>

                                            <label class="btn fw-bold rounded-pill p-1 me-3
                                                {{ $order->payment_status == 'Completed' ? 'bg-info-subtle text-info' : 'bg-secondary-subtle text-secondary' }}"
                                                for="preparingRadio{{ $order->order_reference }}">
                                                Preparing
                                            </label>
                                        </div>

                                        <div class="preparing-to-ready me-3 fw-bold text-primary">
                                            <i class="bi bi-chevron-double-right"></i>
                                        </div>

                                        <!-- Ready Radio Button -->
                                        <div class="ready-status">
                                            <input type="radio" class="btn-check ready-status" name="order_status" id="readyRadio{{ $order->order_reference }}"
                                                value="Ready"
                                                autocomplete="off"
                                                {{ $order->payment_status != 'Completed' ? 'disabled' : '' }}
                                                {{ $order->order_status == 'Ready' ? 'checked' : '' }}>

                                            <label class="btn fw-bold rounded-pill p-1 me-3 w-100 bg-success-subtle text-success"
                                                for="readyRadio{{ $order->order_reference }}">
                                                Ready
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-flex align-items-end">
                                        @if($order->order_status == 'Ready')
                                        <input type="hidden" name="order_status" value="Completed">

                                        <button type="submit"
                                            class="btn border-0 bg-success-subtle text-success rounded-pill mx-2"
                                            id="saveButton{{ $order->order_reference }}"
                                            {{ $order->payment_status != 'Completed' ? 'disabled' : '' }}>
                                            <i class="bi bi-check-all"></i>
                                        </button>
                                        @else
                                        <button type="submit"
                                            disabled
                                            class="btn update-status-btn border-0 bg-secondary-subtle text-secondary rounded-pill mx-2"
                                            id="saveButton{{ $order->order_reference }}"
                                            {{ $order->payment_status != 'Completed' ? 'disabled' : '' }}>
                                            <i class="bi bi-floppy"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>

                        <h5 class="card-title">Order Details</h5>
                        <div class="pb-3">
                            <div class="table-responsive" style="max-height: 150px; overflow-y: auto;">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            @php $total = 0; @endphp
                                            @foreach($order->products as $product)
                                            @php $total += $product->total @endphp
                                        <tr>
                                            <td style="max-width: 100px">{{ $product->product_name }}</td>
                                            <td>{{ $product->category_name }}</td>
                                            <td>₱{{ number_format($product->price, 2) }}</td>
                                            <td>{{ $product->quantity }}x</td>
                                            <td>₱{{ number_format($product->total,2) }}</td>
                                        </tr>
                                        @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="pt-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Total: </span>
                                <h4 class="text-primary">₱ {{ number_format($total,2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center">
                        <img src="{{ asset('img/empty.png') }}" alt="empty" style="width: 100px;">
                        <h5 class="text-muted">No orders found.</h5>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

    </div>

    <!-- Payment View Modal -->
    <div class="modal fade" id="viewPaymentModal" tabindex="-1" aria-labelledby="viewPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewPaymentModalLabel">Payment Proof</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img id="paymentImage" src="" class="img-fluid" alt="Payment Image">
                    </div>
                    <p class="text-center">Order Reference: <span id="orderReference"></span></p>
                    <p class="text-center">Customer: <span class="text-uppercase" id="customerName"></span></p>
                </div>
                <div class="modal-footer">
                    <form id="confirmPaymentForm" method="POST" action="{{ route('confirm.payment') }}">
                        @csrf
                        <input type="hidden" name="order_id" id="orderId">
                        <button type="submit" id="confirmButton" class="btn btn-success">Confirm</button>
                    </form>
                    @if($orders->isNotEmpty())
                    <button type="button" id="rejectButton" class="btn btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#rejectPaymentModal"
                        data-order-reference="">
                        Reject
                    </button>
                    @endif
                    <button type="button" id="closeButton" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Payment Modal -->
    <div class="modal fade" id="rejectPaymentModal" tabindex="-1" aria-labelledby="rejectPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectPaymentModalLabel">Reject Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="rejectPaymentForm" method="POST" action="{{ route('reject.payment') }}">
                        @csrf
                        <input type="hidden" name="order_reference" id="rejectOrderReference">
                        <div class="mb-3">
                            <label for="feedback" class="form-label">Reason for Rejection</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">Submit Rejection</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@if(session('updateOrder'))
<script>
    Swal.fire({
        position: "center",
        icon: "success",
        title: "{{ session('orderStatus') == 'Completed' ? 'Order Completed' : 'Order status updated.' }}",
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif

@if(session('confirmPayment'))
<script>
    Swal.fire({
        position: "center",
        icon: "success",
        title: "{{ session('confirmPayment') }}",
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif

@if(session('rejectPayment'))
<script>
    Swal.fire({
        position: "center",
        icon: "success",
        title: "{{ session('rejectPayment') }}",
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif

<style>
    button:disabled {
        cursor: not-allowed;
        pointer-events: all !important;
    }
</style>

<script>
    $(document).ready(function() {
        updateStatusBTN();
        btnDisablingBtn();
    });

    document.addEventListener('DOMContentLoaded', function() {

        // Loop through each dropdown in the table
        // document.querySelectorAll('.status-dropdown').forEach(function(dropdown) {
        //     const orderId = dropdown.getAttribute('data-order-id');
        //     const updateButton = document.getElementById('updateButton' + orderId);
        //     const updateButtonText = document.getElementById('updateButtonText' + orderId);
        //     let currentStatus = dropdown.getAttribute('data-current-status'); // Get the initial current status

        //     // Initially set the button to disabled if the status hasn't changed
        //     if (dropdown.value === currentStatus) {
        //         updateButton.setAttribute('disabled', true);
        //         updateButton.classList.add('bg-secondary-subtle', 'text-secondary');
        //         updateButton.classList.remove('bg-primary-subtle', 'text-primary');
        //         updateButtonText.classList.add('text-secondary');
        //         updateButtonText.classList.remove('text-primary');
        //     } else {
        //         updateButton.removeAttribute('disabled');
        //         updateButton.classList.add('bg-primary-subtle', 'text-primary');
        //         updateButton.classList.remove('bg-secondary-subtle', 'text-secondary');
        //         updateButtonText.classList.add('text-primary');
        //         updateButtonText.classList.remove('text-secondary');
        //     }

        //     // Event listener for dropdown change
        //     dropdown.addEventListener('change', function() {
        //         const selectedStatus = dropdown.value;

        //         // If the selected status is different from the current status, enable the button
        //         if (selectedStatus !== currentStatus) {
        //             updateButton.removeAttribute('disabled');
        //             updateButton.classList.remove('bg-secondary-subtle', 'text-secondary');
        //             updateButton.classList.add('bg-primary-subtle', 'text-primary');
        //             updateButtonText.classList.remove('text-secondary');
        //             updateButtonText.classList.add('text-primary');
        //         } else {
        //             // If no change, disable the button
        //             updateButton.setAttribute('disabled', true);
        //             updateButton.classList.remove('bg-primary-subtle', 'text-primary');
        //             updateButton.classList.add('bg-secondary-subtle', 'text-secondary');
        //             updateButtonText.classList.remove('text-primary');
        //             updateButtonText.classList.add('text-secondary');
        //         }
        //     });
        // });

        let openRow = null; // Track the currently open row

        // Attach click event to each <tr> excluding select and button columns
        document.querySelectorAll('.order-row').forEach(function(orderRow) {
            orderRow.addEventListener('click', function(event) {
                // Prevent toggling if clicked inside the order status or action column
                const clickedColumn = event.target.closest('td');
                const ignoreColumns = ['order-status-column', 'action-column'];
                if (ignoreColumns.includes(clickedColumn.getAttribute('class'))) {
                    return;
                }

                let collapseElement = document.querySelector(orderRow.getAttribute('data-bs-target')); // Get collapse element
                let collapseInstance = bootstrap.Collapse.getOrCreateInstance(collapseElement); // Get or create the Bootstrap collapse instance

                // Check if the row is already open
                if (collapseElement.classList.contains('show')) {
                    // Row is open, close it
                    collapseInstance.hide();
                    document.querySelector('#icon-' + orderRow.getAttribute('data-bs-target').replace('#orderDetails', '')).classList.remove('bi-caret-up-fill');
                    document.querySelector('#icon-' + orderRow.getAttribute('data-bs-target').replace('#orderDetails', '')).classList.add('bi-caret-down-fill');
                    openRow = null; // No row is open anymore
                } else {
                    // Close any previously open row
                    if (openRow && openRow !== collapseElement) {
                        bootstrap.Collapse.getOrCreateInstance(openRow).hide();
                        document.querySelector('#icon-' + openRow.id.replace('orderDetails', '')).classList.remove('bi-caret-up-fill');
                        document.querySelector('#icon-' + openRow.id.replace('orderDetails', '')).classList.add('bi-caret-down-fill');
                    }
                    // Open the clicked row
                    collapseInstance.show();
                    document.querySelector('#icon-' + orderRow.getAttribute('data-bs-target').replace('#orderDetails', '')).classList.remove('bi-caret-down-fill');
                    document.querySelector('#icon-' + orderRow.getAttribute('data-bs-target').replace('#orderDetails', '')).classList.add('bi-caret-up-fill');
                    openRow = collapseElement; // Set the new open row
                }
            });
        });

        // Ensure dropdown click event does not propagate (if dropdowns exist in your rows)
        document.querySelectorAll('select.status-dropdown').forEach(function(select) {
            select.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevent event propagation on select dropdown
            });
        });

        // Trigger the payment modal with the correct image
        $('#viewPaymentModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var paymentImage = button.data('payment-image'); // Extract info from data-* attributes
            var orderId = button.data('order-id'); // Get the order id
            var orderReference = button.data('order-reference');
            var paymentStatus = button.data('payment-status');
            var customerName = button.data('customer-name');

            var modal = $(this);
            modal.find('#paymentImage').attr('src', paymentImage); // Set the image in the modal
            modal.find('#paymentImageLink').attr('href', paymentImage); // Set the href for clickable image
            modal.find('#orderId').val(orderId); // Set order ID for the confirm form
            modal.find('#orderReference').text(orderReference);
            modal.find('#paymentStatus').val(paymentStatus);
            modal.find('#customerName').text(customerName);

            $('#rejectButton').on('click', function(event) {
                var orderReference = $('#orderReference').text(); // Get the displayed order reference
                $('#rejectPaymentModal').find('#rejectOrderReference').val(orderReference); // Set the order reference in the reject form
            });

            // Check payment status and show/hide buttons
            if (paymentStatus === 'Completed') {
                // Hide the Confirm and Reject buttons
                $('#confirmButton').hide();
                $('#rejectButton').hide();
                $('#closeButton').show();
            } else {
                // Show the buttons if the payment is still pending
                $('#confirmButton').show();
                $('#rejectButton').show();
                $('#closeButton').hide();
            }
        });

        // Trigger the reject payment modal and set the order reference in the hidden field
        $('#rejectPaymentModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var orderReference = button.data('order-reference'); // Extract the order reference

            var modal = $(this);
            modal.find('#rejectOrderReference').val(orderReference); // Set the order reference in the hidden input
        });

    });

    function updateStatusBTN() {
        $(".card-status-btn").each(function() {
            var status = $(this).find('.order-status').val();

            if (status == 'Pending') {
                $(this).find(".pending-status").show();
                $(this).find(".preparing-status").show();
                $(this).find(".ready-status").hide();
                $(this).find(".pending-to-preparing").show();
                $(this).find(".preparing-to-ready").hide();
            } else if (status == 'Preparing') {
                $(this).find(".pending-status").hide();
                $(this).find(".preparing-status").show();
                $(this).find(".ready-status").show();
                $(this).find(".pending-to-preparing").hide();
                $(this).find(".preparing-to-ready").show();
            } else if (status == 'Ready') {
                $(this).find(".pending-status").hide();
                $(this).find(".preparing-status").hide();
                $(this).find(".ready-status").show();
                $(this).find(".pending-to-preparing").hide();
                $(this).find(".preparing-to-ready").hide();
            }

        });
    }

    function btnDisablingBtn() {

        $(".card-status-btn input[type='radio']").on('change', function() {
            $(this).find(".update-status-btn").addClass("bg-primary-subtle text-primary");

            var currentStatus = $(this).parents(".card-status-btn").find('.order-status').val();
            var statusSelected = $(this).val();

            if (currentStatus != statusSelected) {
                $(this).parents(".card-status-btn").find('.update-status-btn').prop('disabled', false);
                $(this).parents(".card-status-btn").find('.update-status-btn').removeClass("bg-secondary-subtle text-secondary");
                $(this).parents(".card-status-btn").find('.update-status-btn').addClass("bg-primary-subtle text-primary");
            } else {
                $(this).parents(".card-status-btn").find('.update-status-btn').prop('disabled', true);
                $(this).parents(".card-status-btn").find('.update-status-btn').addClass("bg-secondary-subtle text-secondary");
                $(this).parents(".card-status-btn").find('.update-status-btn').removeClass("bg-primary-subtle text-primary");
            }
        });

    }
</script>



@endsection