@extends('layouts.seller.sellerMaster')

@section('content')
<div class="container1">
    <main>
        <h1>Dashboard</h1>

        <div class="date">
            <input type="date">
        </div>

        <div class="insights">
            <!-- Start sales -->
            <div class="sales">
                <span class="material-symbols-sharp">trending_up</span>
                <div class="middle">
                    <div class="left">
                        <h3>Total Sales</h3>
                        <h1>$25,024</h1>
                    </div>
                    <div class="progress">
                        <svg>
                            <circle r="30" cy="40" cx="40"></circle>
                        </svg>
                        <div class="number">
                            <p>80%</p>
                        </div>
                    </div>
                </div>
                <small>Last 24 Hours</small>
            </div>
            <!-- End sales -->

            <!-- Start expenses -->
            <div class="expenses">
                <span class="material-symbols-sharp">local_mall</span>
                <div class="middle">
                    <div class="left">
                        <h3>Total Expenses</h3>
                        <h1>$25,024</h1>
                    </div>
                    <div class="progress">
                        <svg>
                            <circle r="30" cy="40" cx="40"></circle>
                        </svg>
                        <div class="number">
                            <p>80%</p>
                        </div>
                    </div>
                </div>
                <small>Last 24 Hours</small>
            </div>
            <!-- End expenses -->

            <!-- Start income -->
            <div class="income">
                <span class="material-symbols-sharp">stacked_line_chart</span>
                <div class="middle">
                    <div class="left">
                        <h3>Total Income</h3>
                        <h1>$25,024</h1>
                    </div>
                    <div class="progress">
                        <svg>
                            <circle r="30" cy="40" cx="40"></circle>
                        </svg>
                        <div class="number">
                            <p>80%</p>
                        </div>
                    </div>
                </div>
                <small>Last 24 Hours</small>
            </div>
            <!-- End income -->
        </div>
        <!-- End insights -->

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
                    <img src="sample.jpg">
                    <p><b>Babar</b> received his order of food</p>
                </li>
                <li>
                    <img src="sample.jpg">
                    <p><b>Ali</b> received his order of food</p>
                </li>
            </ul>
        </div>
        <h2>Sales Analytics</h2>
        <div class="sales-analytics">
            <ul>
                <li>
                    <span class="material-symbols-sharp">shopping_cart</span>
                    <ul>
                        <li>
                            <h3>Online Orders</h3>
                        </li>
                        <li>
                            <p>Last seen 2 hours ago</p>
                        </li>
                        <li>
                            <p>-17%</p>
                        </li>
                        <li>
                            <p><b>3849</b></p>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="sales-analytics">
            <ul>
                <li>
                    <span class="material-symbols-sharp">shopping_cart</span>
                    <ul>
                        <li>
                            <h3>Online Orders</h3>
                        </li>
                        <li>
                            <p>Last seen 2 hours ago</p>
                        </li>
                        <li>
                            <p>-17%</p>
                        </li>
                        <li>
                            <p><b>3849</b></p>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="sales-analytics">
            <ul>
                <li>
                    <span class="material-symbols-sharp">shopping_cart</span>
                    <ul>
                        <li>
                            <h3>Online Orders</h3>
                        </li>
                        <li>
                            <p>Last seen 2 hours ago</p>
                        </li>
                        <li>
                            <p>-17%</p>
                        </li>
                        <li>
                            <p><b>3849</b></p>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection