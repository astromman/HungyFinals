@extends('layouts.seller.sellerMaster')

@section('content')
<div class="container1">
    <main>
        <h1>Dashboard</h1>

        <div class="date">
            <input type="date">
        </div>

        <div class="insights">
            <div class="sales">
                <span class="material-symbols-sharp">trending_up</span>
                <div class="middle">
                    <div class="left">
                        <h3>Pending Orders</h3>
                        <h1>{{ $pending }}</h1>
                    </div>
                </div>
                <small>Last 24 Hours</small>
            </div>

            <div class="expenses">
                <span class="material-symbols-sharp">local_mall</span>
                <div class="middle">
                    <div class="left">
                        <h3>Completed Orders</h3>
                        <h1>{{ $totalNumberOfOrders }}</h1>
                    </div>
                </div>
                <small>Last 24 Hours</small>
            </div>

            <div class="income">
                <span class="material-symbols-sharp">stacked_line_chart</span>
                <div class="middle">
                    <div class="left">
                        <h3>Total Income</h3>
                        <h1>P{{ number_format($totalIncome, 2) }}</h1>
                    </div>
                </div>
                <small>All Time</small>
            </div>
        </div>


        <div class="recent_order">
            <h2>Recent Orders</h2>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Product Number</th>
                        <th>Payments</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="borderless">
                    <tr>
                        <td>Mini USB</td>
                        <td>4563</td>
                        <td>Due</td>
                        <td class="warning">Pending</td>
                        <td class="primary">Details</td>
                    </tr>
                    <!-- Repeat rows as needed -->
                </tbody>
            </table>
            <a href="#">Show All</a>
        </div>
    </main>
    <div class="right-sidebar">
        <h2>Recent Update</h2>
        <div class="recent-update">
            <ul>
                <li>
                    <p><b>Babar</b> received his order of food</p>
                </li>
                <li>
                    <p><b>Ali</b> received his order of food</p>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection