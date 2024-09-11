@extends('layouts.seller.sellerMaster')

@section('content')
<div class="container-fluid pt-3">
    <div class="py-2">
        <h2>My Orders</h2>
    </div>
    <div class="order-table-container">
        <table class="order-table">
            <thead>
                <tr>
                    <th class="text-center">Expand</th>
                    <th class="text-center">Reference</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Customer</th>
                    <th class="text-center">Contact number</th>
                    <th class="text-center">Payment</th>
                    <th class="text-center">Mode</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
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
                        data-label="Order Id"
                        data-bs-toggle="collapse"
                        data-bs-target="#orderDetails{{ $order->id }}"
                        aria-expanded="false"
                        aria-controls="orderDetails{{ $order->id }}">
                        {{ $order->order_reference }}
                    </td>
                    <td class="text-center"
                        data-label="Created"
                        data-bs-toggle="collapse"
                        data-bs-target="#orderDetails{{ $order->id }}"
                        aria-expanded="false"
                        aria-controls="orderDetails{{ $order->id }}">
                        {{ $order->created_at->diffForHumans() }}
                    </td>
                    <td class="text-center text-uppercase"
                        data-label="Customer"
                        data-bs-toggle="collapse"
                        data-bs-target="#orderDetails{{ $order->id }}"
                        aria-expanded="false"
                        aria-controls="orderDetails{{ $order->id }}">
                        {{ $order->first_name . ' ' . $order->last_name }}
                    </td>
                    <td class="text-center"
                        data-label="Contact number"
                        data-bs-toggle="collapse"
                        data-bs-target="#orderDetails{{ $order->id }}"
                        aria-expanded="false"
                        aria-controls="orderDetails{{ $order->id }}">
                        {{ $order->contact_num }}
                    </td>
                    <td class="text-center" data-label="Payment"
                        data-bs-toggle="collapse"
                        data-bs-target="#orderDetails{{ $order->id }}"
                        aria-expanded="false"
                        aria-controls="orderDetails{{ $order->id }}">
                        {{ $order->payment_status }}
                    </td>
                    <td class="text-center text-uppercase"
                        data-label="Mode"
                        data-bs-toggle="collapse"
                        data-bs-target="#orderDetails{{ $order->id }}"
                        aria-expanded="false"
                        aria-controls="orderDetails{{ $order->id }}">
                        {{ $order->payment_type }}
                    </td>
                    <td class="text-center" data-label="Status">
                        <select class="status-dropdown">
                            <option value="Processing" {{ $order->order_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Preparing" {{ $order->order_status == 'Preparing' ? 'selected' : '' }}>Preparing</option>
                            <option value="Ready" {{ $order->order_status == 'Ready' ? 'selected' : '' }}>Ready</option>
                        </select>
                    </td>
                    <td class="text-center" data-label="Action">
                        <button type="submit" class="action-button btn-primary rounded-pill bg-primary-subtle">
                            <strong class="text-primary text-uppercase">
                                Update
                            </strong>
                        </button>
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
                @empty
                <tr>
                    <td class="text-center" colspan="9">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
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

            // Attach click event directly to the select dropdowns to stop propagation
            document.querySelectorAll('select.status-dropdown').forEach(function(select) {
                select.addEventListener('click', function(event) {
                    event.stopPropagation(); // Prevent event propagation on select dropdown
                });
            });
        });
    </script>

</div>
@endsection