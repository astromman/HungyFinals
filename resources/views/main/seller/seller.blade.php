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
                        <h1>₱ {{ number_format($totalIncome, 2) }}</h1>
                    </div>
                </div>
                <small>All Time</small>
            </div>
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

    <!-- Start Pie and Bar Charts Side by Side -->
    <div class="charts">
        <div class="chart-container">
            <h3>Sold Items per Categories</h3>
            <canvas id="myPieChart"></canvas>
        </div>

        <div class="chart-container">
            <h3>Recent Orders</h3>
            <canvas id="myBarChart"></canvas>
        </div>
    </div>
    <!-- End Pie and Bar Charts -->

    <script>
        const pieCtx = document.getElementById('myPieChart').getContext('2d');
        const categoryLabels = <?= json_encode(array_keys($categoriesData)) ?>; // Category names
        const categoryValues = <?= json_encode(array_values($categoriesData)) ?>; // Total sold count per category

        const myPieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Sold Items per Category',
                    data: categoryValues,
                    backgroundColor: ['#7380ec', '#ff7782', '#41f1b6', '#ffcd56'], // Custom colors
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>

    <script>
        const barCtx = document.getElementById('myBarChart').getContext('2d');

        // Use json_encode() to pass the data from PHP to JavaScript
        const orderDates = <?= json_encode(array_keys($dailyOrders)) ?>; // Get the order dates
        const orderCounts = <?= json_encode(array_values($dailyOrders)) ?>; // Get the order counts for each day

        const myBarChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: orderDates, // Dates as labels
                datasets: [{
                    label: 'Total Orders',
                    data: orderCounts, // Order counts as data
                    backgroundColor: '#7380ec', // Bar color
                    borderRadius: 5,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true // Start y-axis at 0
                    }
                }
            }
        });
    </script>



    <!-- End of Redesigned Recent Update Section -->
</div>
@endsection