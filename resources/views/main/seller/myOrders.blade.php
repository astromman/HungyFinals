@extends('layouts.seller.sellerMaster')

@section('content')
<div class="container-fluid pt-3">
    <div class="py-2">
        <h2>My Orders</h2>
    </div>
    <div class="order-table-container">
        <table class="order-table">
            <thead>
                <tr class="text-center">
                    <th>Order Reference</th>
                    <th>Created</th>
                    <th>Customer</th>
                    <th>Contact number</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="order-row" data-bs-toggle="collapse" data-bs-target="#orderDetails{{ $order->id }}" aria-expanded="false" aria-controls="orderDetails{{ $order->id }}">
                    <td data-label="Order Id">{{ $order->order_reference }}</td>
                    <td data-label="Created">{{ $order->created_at->diffForHumans() }}</td>
                    <td data-label="Customer" class="text-uppercase">{{ $order->first_name . ' ' . $order->last_name }}</td>
                    <td data-label="Contact number">{{ $order->contact_num }}</td>
                    <td data-label="Total">{{ '₱ ' . $order->total }}</td>
                    <td data-label="Status">
                        <select>
                            <option value="Processing" {{ $order->order_status == 'Processing' ? 'selected' : '' }}>Processing</option>
                            <option value="Preparing" {{ $order->order_status == 'Preparing' ? 'selected' : '' }}>Preparing</option>
                            <option value="Ready" {{ $order->order_status == 'Ready' ? 'selected' : '' }}>Ready</option>
                        </select>
                    </td>
                    <td data-label="Action">
                        <button class="action-button">Update</button>
                    </td>
                </tr>
                <!-- Wrap details row in a div to enable animation -->
                <tr>
                    <td colspan="7" class="p-0">
                        <div id="orderDetails{{ $order->id }}" class="collapse">
                            <table class="details-table w-100">
                                <thead>
                                    <tr>
                                        <th>Name</th>
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
                                        <td>{{ $product->product_name }}</td>
                                        <td>₱ {{ $product->price }}</td>
                                        <td>{{ $product->quantity }}x</td>
                                        <td>₱ {{ $product->price * $product->quantity }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Order Total</strong></td>
                                        <td><strong>₱ {{ $total }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="text-center" colspan="7">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let openRow = null; // Track the currently open row
            
            // Attach click event to all rows that are expandable
            document.querySelectorAll('.order-row').forEach(function (row) {
                row.addEventListener('click', function (event) {
                    // Prevent toggle if interacting with the dropdown or button
                    if (event.target.tagName.toLowerCase() === 'button' || event.target.tagName.toLowerCase() === 'select') {
                        event.stopPropagation();
                        return;
                    }

                    let target = row.getAttribute('data-bs-target');
                    let collapseElement = document.querySelector(target);

                    // If a row is clicked that is already open, toggle it (close)
                    if (collapseElement.classList.contains('show')) {
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
        });
    </script>
</div>
@endsection
