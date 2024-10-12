@extends('layouts.seller.sellerMaster')

@section('content')
<div class="container-fluid pt-3">
    <div class="py-2">
        <h2>Order History</h2>
    </div>
    <div class="order-table-container">
        <table class="order-table">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center">Reference</th>
                    <th class="text-center">Customer</th>
                    <th class="text-center">Pick-up At</th>
                    <th class="text-center">Order Status</th>
                    <th class="text-center">Mode</th>
                    <th class="text-center">Payment Reference</th>
                    <th class="text-center">Payment Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="order-row">
                    <td class="text-center order-expand"
                        data-bs-toggle="collapse"
                        data-bs-target="#orderDetails{{ $order->id }}"
                        aria-expanded="false"
                        aria-controls="orderDetails{{ $order->id }}">
                        <i class="bi bi-caret-down-fill font-bold" style="font-size: 20px; "></i>
                    </td>
                    <td class="text-center"
                        data-bs-toggle="collapse"
                        data-bs-target="#orderDetails{{ $order->id }}"
                        aria-expanded="false"
                        aria-controls="orderDetails{{ $order->id }}">
                        {{ $order->order_reference }}
                    </td>
                    <td class="text-center text-uppercase"
                        data-bs-toggle="collapse"
                        data-bs-target="#orderDetails{{ $order->id }}"
                        aria-expanded="false"
                        aria-controls="orderDetails{{ $order->id }}">
                        {{ $order->first_name . ' ' . $order->last_name }}
                    </td>
                    <td class="text-center"
                        data-bs-toggle="collapse"
                        data-bs-target="#orderDetails{{ $order->id }}"
                        aria-expanded="false"
                        aria-controls="orderDetails{{ $order->id }}">
                        {{ $order->updated_at->format('M d Y, h:i A') }}
                    </td>
                    <td class="text-center text-uppercase"
                        data-bs-toggle="collapse"
                        data-bs-target="#orderDetails{{ $order->id }}"
                        aria-expanded="false"
                        aria-controls="orderDetails{{ $order->id }}">
                        <strong class="text-success p-1 w-100 rounded-pill bg-success-subtle">
                            {{ $order->order_status }}
                        </strong>
                    </td>
                    <td class="text-center text-uppercase"
                        data-bs-toggle="collapse"
                        data-bs-target="#orderDetails{{ $order->id }}"
                        aria-expanded="false"
                        aria-controls="orderDetails{{ $order->id }}">
                        {{ $order->payment_type }}
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn  {{ $order->payment_status == 'Pending' ? 'bg-primary-subtle' : 'bg-success-subtle' }} w-100 rounded-pill"
                            data-bs-toggle="modal"
                            data-bs-target="#viewPaymentModal"
                            data-payment-image="{{ asset('storage/payments/' . $order->payment_id) }}"
                            data-order-id="{{ $order->id }}"
                            data-payment-status="{{ $order->payment_status }}">
                            <strong class="{{ $order->payment_status == 'Pending' ? 'text-primary' : 'text-success' }} text-uppercase">
                                View
                            </strong>
                        </button>
                    </td>
                    <td class="text-center text-uppercase"
                        data-bs-toggle="collapse"
                        data-bs-target="#orderDetails{{ $order->id }}"
                        aria-expanded="false"
                        aria-controls="orderDetails{{ $order->id }}">
                        <strong class="text-success p-1 w-100 rounded-pill bg-success-subtle">
                            {{ $order->payment_status }}
                        </strong>
                    </td>
                </tr>
                <!-- Wrap details row in a div to enable animation -->
                <tr>
                    <td colspan="9" class="p-0">
                        <div id="orderDetails{{ $order->id }}" class="collapse">
                            <table class="details-table w-100">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach($order->products as $product)
                                    @php $total += $product->price * $product->quantity @endphp
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->type_name }}</td>
                                        <td>₱ {{ $product->price }}</td>
                                        <td>{{ $product->quantity }}x</td>
                                        <td>₱ {{ $product->price * $product->quantity }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong>Order Total</strong></td>
                                        <td><strong>₱ {{ $total }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="container">
                                <hr>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Payment View Modal -->
                <div class="modal fade" id="viewPaymentModal" tabindex="-1" aria-labelledby="viewPaymentModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewPaymentModalLabel">Payment Proof</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img id="paymentImage" src="" class="img-fluid" alt="Payment Image">
                                <!-- Hidden field to store the payment status -->
                                <input type="hidden" id="paymentStatus" value="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                @empty
                <tr>
                    <td class="text-center" colspan="9">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Order status has been updated successfully!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let openRow = null; // Track the currently open row

        // Attach click event to the expand button inside each <td>
        document.querySelectorAll('.order-expand').forEach(function(expandButton) {
            expandButton.addEventListener('click', function(event) {
                event.stopPropagation(); // Stop event propagation on click

                let row = expandButton.closest('.order-row'); // Get the parent row of the clicked expand button
                let target = row.getAttribute('data-bs-target'); // Target collapse element
                let collapseElement = document.querySelector(target); // Get collapse element

                // Check if the row is already open
                if (collapseElement.classList.contains('show')) {
                    // Row is open, close it
                    bootstrap.Collapse.getInstance(collapseElement).hide();
                    openRow = null; // No row is open anymore
                } else {
                    // Close any previously open row
                    if (openRow && openRow !== collapseElement) {
                        bootstrap.Collapse.getInstance(openRow).hide();
                    }
                    // Open the clicked row
                    bootstrap.Collapse.getOrCreateInstance(collapseElement).show();
                    openRow = collapseElement; // Set the new open row
                }
            });
        });

        // Trigger the payment modal with the correct image
        $('#viewPaymentModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var paymentImage = button.data('payment-image'); // Extract info from data-* attributes
            var orderId = button.data('order-id'); // Get the order id
            var paymentStatus = button.data('payment-status');

            var modal = $(this);
            modal.find('#paymentImage').attr('src', paymentImage); // Set the image in the modal
            modal.find('#orderId').val(orderId); // Set order ID for the confirm form
            modal.find('#paymentStatus').val(paymentStatus);

            // Check payment status and show/hide buttons
            if (paymentStatus === 'Completed') {
                // Hide the Confirm and Reject buttons
                $('#confirmButton').hide();
                $('#rejectButton').hide();
            } else {
                // Show the buttons if the payment is still pending
                $('#confirmButton').show();
                $('#rejectButton').show();
            }
        });

        // Attach click event directly to the select dropdowns to stop propagation
        document.querySelectorAll('select.status-dropdown').forEach(function(select) {
            select.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevent event propagation on select dropdown
            });
        });

        @if(session('success'))
        var successModal = new bootstrap.Modal(document.getElementById('successModal'), {});
        successModal.show();
        @endif

    });
</script>
@endsection