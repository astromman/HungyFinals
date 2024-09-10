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
                @forelse($groupedOrders as $order)
                <tr class="order-row" onclick="toggleAccordion(this, event)">
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
                <tr class="details-row" style="display: none;">
                    <td colspan="7">
                        <table class="details-table">
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
                                    <td colspan="4" class="text-right"><strong>Order Total</strong></td>
                                    <td><strong>₱ {{ $total }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
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
        function toggleAccordion(row, event) {
            // Prevent toggle if interacting with the dropdown or button
            if (event.target.tagName.toLowerCase() === 'button' || event.target.tagName.toLowerCase() === 'select') {
                return;
            }

            let allDetailsRows = document.querySelectorAll('.details-row');
            let nextRow = row.nextElementSibling;

            // Hide all open detail rows
            allDetailsRows.forEach(function(detailsRow) {
                detailsRow.style.display = 'none';
            });

            // Toggle the visibility of the clicked row's details
            if (nextRow.classList.contains('details-row')) {
                nextRow.style.display = nextRow.style.display === 'table-row' ? 'none' : 'table-row';
            }
        }
    </script>
</div>
@endsection
