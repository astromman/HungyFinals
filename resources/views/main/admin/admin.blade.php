@extends('layouts.admin.adminMaster')

@section('content')
<div class="container-fluid">
    <main>
        <h1>Dashboard</h1>

        <div class="insights">
            <div class="sales shadow">
                <i class="bi bi-person-badge"></i>
                <div class="middle">
                    <div class="left">
                        <h3>Managers</h3>
                        <h1> {{ $managers }} </h1>
                    </div>
                </div>
                <small>Last 24 Hours</small>
            </div>

            <div class="expenses shadow">
                <i class="bi bi-person-circle"></i>
                <div class="middle">
                    <div class="left">
                        <h3>Buyers</h3>
                        <h1> {{ $buyers }} </h1>
                    </div>
                </div>
                <small>Last 24 Hours</small>
            </div>

            <div class="income shadow">
                <i class="bi bi-patch-check-fill"></i>
                <div class="middle">
                    <div class="left">
                        <h3>Verified Shops</h3>
                        <h1> {{ $shops }} </h1>
                    </div>
                </div>
                <small>All Time</small>
            </div>
        </div>

    </main>

    <!-- Start Pie and Bar Charts Side by Side -->
    <h2>Analytics</h2>
    <div class="row">
        <div class="charts col-12 col-md-4">
            <div class="chart-container shadow pb-5">
                <h3>Total orders per Canteen</h3>
                <canvas id="myPieChart"></canvas>
            </div>

        </div>
        <div class="charts col-12 col-md-8">
            <div class="chart-container shadow pb-5">
                <h3>Sales per Canteen</h3>
                <canvas id="myLineChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Prepare the data for the pie chart
        var completedOrders = <?= json_encode($completedOrders) ?>;

        var buildingNames = [];
        var orderCounts = [];

        // Extract the building names and the total order count for each
        completedOrders.forEach(function(order) {
            buildingNames.push(order.building_name);
            orderCounts.push(order.total_orders);
        });

        // Create the Pie Chart
        var ctx = document.getElementById('myPieChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: buildingNames, // Display shop and building names
                datasets: [{
                    data: orderCounts, // Total orders for each shop
                    backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#ff6384', '#36a2eb', '#cc65fe'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>

    <script>
        // Prepare the data for the line chart (Sales per Canteen per Day)
        var salesData = <?= json_encode($salesData) ?>;
        var groupedSales = {};

        // Group the sales data by building and date
        salesData.forEach(function(sale) {
            if (!groupedSales[sale.building_name]) {
                groupedSales[sale.building_name] = {};
            }
            if (!groupedSales[sale.building_name][sale.order_date]) {
                groupedSales[sale.building_name][sale.order_date] = 0;
            }
            groupedSales[sale.building_name][sale.order_date] += sale.total_sales;
        });

        // Prepare datasets for each canteen
        var dates = [];
        var datasets = [];
        var colors = ['#36a2eb', '#cc65fe', '#ffce56']; // Add more colors as needed
        var colorIndex = 0;

        Object.keys(groupedSales).forEach(function(building_name) {
            var sales = [];
            Object.keys(groupedSales[building_name]).forEach(function(date) {
                if (!dates.includes(date)) {
                    dates.push(date); // Collect unique dates
                }
                sales.push(groupedSales[building_name][date]);
            });

            datasets.push({
                label: building_name,
                data: sales,
                fill: true,
                borderColor: colors[colorIndex],
                tension: 0.1,
                borderWidth: 2,
                pointRadius: 5,
            });
            colorIndex = (colorIndex + 1) % colors.length;
        });

        // Create the Line Chart for Sales per Canteen per Day
        var ctx2 = document.getElementById('myLineChart').getContext('2d');
        var myLineChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: dates, // The dates on the x-axis
                datasets: datasets // Each canteen's sales data
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Sales Amount (PHP)'
                        }
                    },
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            tooltipFormat: 'DD',
                            displayFormats: {
                                day: 'DD'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Date'
                        },
                        ticks: {
                            autoSkip: true,
                            maxRotation: 0
                        }
                    }
                }
            }
        });
    </script>


</div>

@endsection