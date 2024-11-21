@extends('layouts.manager.managerMaster')

@section('content')
<div class="container-dash">
    <main>
        <h1>Dashboard</h1>

        <div class="insights">
            <div class="sales shadow">
                <i class="bi bi-envelope-paper-fill"></i>
                <div class="middle">
                    <div class="left">
                        <h3>Applications</h3>
                        <h1> {{ $applications }} </h1>
                    </div>
                </div>
                <small>Last 24 Hours</small>
            </div>

            <div class="expenses shadow">
                <i class="bi bi-shop"></i>
                <div class="middle">
                    <div class="left">
                        <h3>Active Shops</h3>
                        <h1> 0 </h1>
                    </div>
                </div>
                <small>Last 24 Hours</small>
            </div>

            <div class="income shadow">
                <i class="bi bi-patch-check-fill"></i>
                <div class="middle">
                    <div class="left">
                        <h3>Verified Shops</h3>
                        <h1> {{ $verifiedShops }} </h1>
                    </div>
                </div>
                <small>All Time</small>
            </div>
        </div>

    </main>

    <!-- Start Pie and Bar Charts Side by Side -->
    <h2>Analytics</h2>

    <!-- Datepickers for Start Date and End Date -->
    <!-- <form method="GET" action="{{ route('manager.dashboard') }}">
        <div class="row mb-4">
            <div class="col-4">
                <label for="startDate">Filter By Date</label>
                <input type="date" id="startDate" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-4">
                <label for="month">Filter by Month</label>
                <select id="month" name="month" class="form-control">
                    <option value="">Select Month</option>
                    @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form> -->

    <div class="row">
        <div class="charts col-12 col-md-4">
            <div class="chart-container shadow pb-5">
                <h3>Total orders per shop</h3>
                <canvas id="myPieChart"></canvas>
            </div>

        </div>
        <div class="charts col-12 col-md-8">
            <div class="chart-container shadow pb-5">
                <h3>Sales per shop</h3>
                <canvas id="myLineChart"></canvas>
            </div>
        </div>
    </div>

    <!-- End Pie and Bar Charts -->

    <!-- Doughnut Chart for Total Orders per Shop -->
    <script>
        const ordersPerShop = <?= json_encode($ordersPerShop) ?>;
        const pieLabels = ordersPerShop.map(order => order.shop_name);
        const pieData = ordersPerShop.map(order => order.total_orders);

        const pieCtx = document.getElementById('myPieChart').getContext('2d');
        const myPieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    label: 'Total Orders',
                    data: pieData,
                    backgroundColor: ['#7380ec', '#ff7782', '#41f1b6', '#ffcd56'], // Add more colors if needed
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right', // Vertical legend
                    }
                }
            }
        });
    </script>

    <!-- Line Chart for Sales per Shop -->
    <script>
        const salesPerShop = <?= json_encode($salesPerShop) ?>;
        const shops = [...new Set(salesPerShop.map(sale => sale.shop_name))]; // Get unique shop names

        // Create datasets for each shop
        const datasets = shops.map(shop => {
            const salesData = salesPerShop
                .filter(sale => sale.shop_name === shop)
                .map(sale => ({
                    x: sale.sale_date, // Keep the date as a string in 'YYYY-MM-DD' format
                    y: sale.total_sales
                }));

            return {
                label: shop,
                data: salesData,
                fill: true,
                borderColor: getRandomColor(), // Assign a random color to each shop
                tension: 0.1,
                borderWidth: 2, // Thicker lines for better visibility
                pointRadius: 1, // Increase the size of data points
                pointBackgroundColor: 'white', // White center for points
                pointBorderWidth: 3, // Border width for data points
            };
        });

        const lineCtx = document.getElementById('myLineChart').getContext('2d');
        const myLineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top', // Position the legend at the top
                        labels: {
                            usePointStyle: true, // Use circular legend icons
                        }
                    },
                },
                scales: {
                    x: {
                        type: 'time', // Handle dates as x-axis
                        time: {
                            unit: 'day',
                            tooltipFormat: 'DD', // Correct format for the tooltip (e.g., Sep 25, 2024)
                            displayFormats: {
                                day: 'DD' // Display year, month, and day on the axis (2024-Sep-27)
                            }
                        },
                        title: {
                            display: true,
                            text: 'Date' // X-axis title
                        },
                        ticks: {
                            maxRotation: 0, // Prevent labels from rotating
                            autoSkip: true, // Skip overlapping labels
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Sales' // Y-axis title
                        }
                    }
                }
            }
        });

        // Helper function to generate random colors for each shop
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>


    <!-- End of Redesigned Recent Update Section -->
</div>

@endsection