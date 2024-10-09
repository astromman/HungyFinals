@extends('layouts.seller.sellerMaster')

@section('content')
<div class="container-fluid pt-3">
    <div class="py-2">
        <h2>My Orders</h2>
    </div>
    <div class="order-table-container">
        <div class="accordion" id="orderAccordion">
            <table class="order-table">
                <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center">Reference</th>
                        <th class="text-center">Customer</th>
                        <th class="text-center">Created At</th>
                        <th class="text-center">Payment Status</th>
                        <th class="text-center">Mode</th>
                        <th class="text-center">Payment Reference</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="orderTable">
                    @forelse($orders as $order)
                    <tr class="order-row">
                        <td class="text-center accordion-toggle" data-bs-toggle="collapse" data-bs-target="#orderDetails{{ $order->id }}" aria-expanded="false" aria-controls="orderDetails{{ $order->id }}">
                            <i class="bi bi-caret-down-fill font-bold" id="icon-{{ $order->id }}" style="font-size: 20px;"></i>
                        </td>
                        <td class="text-center accordion-toggle" data-bs-toggle="collapse" data-bs-target="#orderDetails{{ $order->id }}" aria-expanded="false" aria-controls="orderDetails{{ $order->id }}">
                            {{ $order->order_reference }}
                        </td>
                        <td class="text-center text-uppercase accordion-toggle" data-bs-toggle="collapse" data-bs-target="#orderDetails{{ $order->id }}" aria-expanded="false" aria-controls="orderDetails{{ $order->id }}">
                            {{ $order->first_name . ' ' . $order->last_name }}
                        </td>
                        <td class="text-center accordion-toggle" data-bs-toggle="collapse" data-bs-target="#orderDetails{{ $order->id }}" aria-expanded="false" aria-controls="orderDetails{{ $order->id }}">
                            {{ $order->created_at->diffForHumans() }}
                        </td>
                        <td class="text-center accordion-toggle" data-bs-toggle="collapse" data-bs-target="#orderDetails{{ $order->id }}" aria-expanded="false" aria-controls="orderDetails{{ $order->id }}">
                            {{ $order->payment_status }}
                        </td>
                        <td class="text-center text-uppercase accordion-toggle" data-bs-toggle="collapse" data-bs-target="#orderDetails{{ $order->id }}" aria-expanded="false" aria-controls="orderDetails{{ $order->id }}">
                            {{ $order->payment_type }}
                        </td>
                        <td class="text-center" {{ $order->payment_type != 'qr' ? 'data-bs-toggle=collapse data-bs-target=#orderDetails' . $order->id : '' }}>
                            @if($order->payment_type == 'qr')
                            <button type="button" class="btn p-1 {{ $order->payment_status == 'Pending' ? 'bg-warning-subtle' : 'bg-success-subtle' }} w-100 rounded-pill"
                                data-bs-toggle="modal"
                                data-bs-target="#viewPaymentModal"
                                data-payment-image="{{ asset('storage/payments/' . $order->payment_id) }}"
                                data-order-id="{{ $order->id }}"
                                data-order-reference="{{ $order->order_reference }}"
                                data-payment-status="{{ $order->payment_status }}">
                                <strong class="{{ $order->payment_status == 'Pending' ? 'text-warning' : 'text-success' }} text-uppercase">
                                    View Payment
                                </strong>
                            </button>
                            @elseif(($order->payment_type == 'gcash' || $order->payment_type == 'paypal'))
                            {{ $order->payment_id }}
                            @endif
                        </td>
                        <td class="text-center">
                            <form id="orderStatusForm{{ $order->order_reference }}" method="POST" action="{{ route('update.order', $order->order_reference) }}">
                                @csrf
                                @if($order->order_status == 'Ready')
                                <input name="order_status" type="hidden" value="Completed">
                                @endif
                                <select name="order_status" class="status-dropdown p-1 rounded-pill fw-bold 
                                {{ ($order->payment_status != 'Completed' && $order->order_status == 'Pending') ? 'bg-secondary-subtle text-secondary' : '' }}
                                {{ ($order->payment_status == 'Completed' && $order->order_status == 'Pending') ? 'bg-warning-subtle text-warning' : '' }}
                                {{ $order->order_status == 'Ready' ? 'bg-success-subtle text-success' : '' }} 
                                {{ $order->order_status == 'Preparing' ? 'bg-info-subtle text-info' : '' }}"
                                    id="statusDropdown{{ $order->order_reference }}"
                                    data-order-id="{{ $order->order_reference }}"
                                    data-current-status="{{ $order->order_status }}"
                                    {{ $order->order_status == 'Ready' || ($order->payment_type == 'qr' && $order->payment_status != 'Completed') ? 'disabled' : '' }}>
                                    <option value="Pending" class="text-center"
                                        {{ $order->order_status == 'Pending' ? 'selected' : '' }}
                                        {{ $order->order_status == 'Preparing' ? 'disabled' : '' }}
                                        {{ $order->order_status == 'Ready' ? 'disabled' : '' }}>Pending</option>

                                    <option value="Preparing" class="text-center"
                                        {{ $order->order_status == 'Preparing' ? 'selected' : '' }}
                                        {{ $order->order_status == 'Ready' ? 'disabled' : '' }}>Preparing</option>

                                    <option value="Ready" class="text-center"
                                        {{ $order->order_status == 'Pending' ? 'disabled' : '' }}
                                        {{ $order->order_status == 'Preparing' ? 'able' : '' }}
                                        {{ $order->order_status == 'Ready' ? 'selected' : '' }}>Ready</option>
                                </select>
                            </form>
                        </td>
                        <td class="text-center">
                            @if($order->order_status == 'Ready')
                            <button type="submit" class="action-button p-1 btn-success w-100 rounded-pill bg-success-subtle" form="orderStatusForm{{ $order->order_reference }}">
                                <strong class="text-success text-uppercase">Complete</strong>
                            </button>
                            @else
                            <button type="submit" id="updateButton{{ $order->order_reference }}" form="orderStatusForm{{ $order->order_reference }}" class="action-button p-1 bg-secondary-subtle w-100 rounded-pill" {{ $order->order_status == 'Pending' || ($order->payment_type == 'qr' && $order->payment_status != 'Completed') ? 'disabled' : '' }}>
                                <strong id="updateButtonText{{ $order->order_reference }}" class="text-secondary text-uppercase">Update</strong>
                            </button>
                            @endif
                        </td>
                    </tr>
                    <!-- Accordion row for products details -->
                    <tr>
                        <td colspan="9" class="p-0">
                            <div id="orderDetails{{ $order->id }}" class="accordion-collapse collapse" data-bs-parent="#orderAccordion">
                                <div class="accordion-body">
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
                                            @php $total += $product->total @endphp
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->category_name }}</td>
                                                <td>₱ {{ number_format($product->price, 2) }}</td>
                                                <td>{{ $product->quantity }}x</td>
                                                <td>₱ {{ number_format($product->total,2) }}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><strong>Order Total</strong></td>
                                                <td><strong>₱ {{ number_format($total,2) }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                                    <p class="text-center">Order Reference: <span id="orderReference"></span></p>
                                    <p class="text-center">Customer: <span class="text-uppercase">{{ $order->first_name . ' ' . $order->last_name }}</span></p>
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

                    @empty
                    <tr>
                        <td class="text-center" colspan="9">No orders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
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

            var modal = $(this);
            modal.find('#paymentImage').attr('src', paymentImage); // Set the image in the modal
            modal.find('#orderId').val(orderId); // Set order ID for the confirm form
            modal.find('#orderReference').text(orderReference);
            modal.find('#paymentStatus').val(paymentStatus);

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

        // Loop through each dropdown in the table and maintain the color styling
        document.querySelectorAll('.status-dropdown').forEach(function(dropdown) {
            var orderId = dropdown.getAttribute('data-order-id');
            var updateButton = document.getElementById('updateButton' + orderId);
            var updateButtonText = document.getElementById('updateButtonText' + orderId);
            var currentStatus = dropdown.getAttribute('data-current-status'); // Get the current status

            // Initially check if the current status matches the dropdown value
            if (dropdown.value === currentStatus) {
                updateButton.setAttribute('disabled', true);
                updateButton.classList.remove('bg-primary-subtle', 'text-primary');
                updateButton.classList.add('bg-secondary-subtle', 'text-secondary');
                updateButtonText.classList.add('text-secondary');
                updateButtonText.classList.remove('text-primary');
            }

            // Event listener for dropdown change
            dropdown.addEventListener('change', function() {
                var selectedStatus = dropdown.value;

                // Enable or disable the button based on the selected status vs current status
                if (selectedStatus === currentStatus) {
                    updateButton.setAttribute('disabled', true);
                    updateButton.classList.remove('bg-primary-subtle', 'text-primary');
                    updateButton.classList.add('bg-secondary-subtle', 'text-secondary');
                    updateButtonText.classList.remove('text-primary');
                    updateButtonText.classList.add('text-secondary');
                } else {
                    updateButton.removeAttribute('disabled');
                    updateButton.classList.remove('bg-secondary-subtle', 'text-secondary');
                    updateButton.classList.add('bg-primary-subtle', 'text-primary');
                    updateButtonText.classList.remove('text-secondary');
                    updateButtonText.classList.add('text-primary');
                }
            });
        });

    });
</script>

@endsection