@extends('layouts.seller.sellerMaster')

@section('content')
<div class="container-fluid pt-3"> <!-- Adding margin-top to create separation -->
    <div class="py-2">
        <h2>My Orders</h2>
    </div>
    <div class="order-table-container">
        <table class="order-table">
            <thead>
                <tr>
                    <th>Order Id</th>
                    <th>Created</th>
                    <th>Customer</th>
                    <th>Contact number</th>
                    <th>Total</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="order-row" onclick="toggleDetails(this, event)">
                    <td data-label="Order Id">1111</td>
                    <td data-label="Created">2 mins ago</td>
                    <td data-label="Customer">Jan Yuri</td>
                    <td data-label="Contact number">098127678998</td>
                    <td data-label="Total">P150</td>
                    <td data-label="Qty">3</td>
                    <td data-label="Status">
                        <select>
                            <option value="Processing">Processing</option>
                            <option value="Preparing">Preparing</option>
                            <option value="Ready">Ready</option>
                        </select>
                    </td>
                    <td data-label="Action">
                        <button class="action-button">Update</button>
                    </td>
                </tr>
                <tr class="details-row">
                    <td colspan="8">
                        <table class="details-table">
                            <tr>
                                <th>Product Id</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                            <tr>
                                <td>$123</td>
                                <td>Tapsilog</td>
                                <td>P55.00</td>
                                <td>1x</td>
                                <td>P55.00</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-right">Total</td>
                                <td>P55.00</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- Additional rows as needed -->
            </tbody>
        </table>
    </div>

    <script>
        function toggleDetails(row, event) {
            // Prevent the details row from toggling if the click target is a button or select element
            if (event.target.tagName.toLowerCase() === 'button' || event.target.tagName.toLowerCase() === 'select') {
                return;
            }

            let nextRow = row.nextElementSibling;
            if (nextRow.classList.contains('details-row')) {
                nextRow.style.display = nextRow.style.display === 'table-row' ? 'none' : 'table-row';
            }
        }
    </script>
</div>
@endsection