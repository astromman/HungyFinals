@extends('layouts.seller.sellerMaster')

@section('content')
<div class="container-dash">
    <main>
        <h1>Dashboard</h1>
        <div class="insights">
            <div class="sales shadow ">
                <i class="bi bi-hourglass-split"></i>
                <div class="middle">
                    <div class="left">
                        <h3>Pending Orders</h3>
                        <h1>{{ $pending }}</h1>
                    </div>
                </div>
                <small>Last 24 Hours</small>
            </div>

            <div class="expenses shadow">
                <i class="bi bi-check2-circle"></i>
                <div class="middle">
                    <div class="left">
                        <h3>Completed Orders</h3>
                        <h1>{{ $totalNumberOfOrders }}</h1>
                    </div>
                </div>
                <small>Last 24 Hours</small>
            </div>

            <div class="income shadow">
                <i class="bi bi-cash-stack"></i>
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

    <h2>Analytics</h2>
    <!-- Start Pie and Bar Charts Side by Side -->
    <div class="row">
        <div class="charts col-4">
            <div class="chart-container shadow pb-5">
                <h3>Sold Items per Categories</h3>
                <canvas id="myPieChart"></canvas>
            </div>

        </div>

        <div class="charts col-8">
            <div class="chart-container shadow pb-5">
                <h3>Most Popular Product</h3>
                <canvas id="myBarChart"></canvas>
            </div>
        </div>
    </div>

    <div class="charts">
        <div class="chart-container shadow pb-5">
            <h3>Overall Income</h3>
            <canvas id="myLineChart"></canvas>
        </div>
    </div>


    <!-- End Pie and Bar Charts -->

    <!-- doughnut chart script -->
    <script>
        const pieCtx = document.getElementById('myPieChart').getContext('2d');
        const categoryLabels = <?= json_encode(array_keys($categoriesData)) ?>; // Category names
        const categoryValues = <?= json_encode(array_values($categoriesData)) ?>; // Total sold count per category
        const totalSoldItems = <?= $totalSoldItems ?>; // Total sold items

        // Function to generate random colors
        function generateRandomColors(numColors) {
            const colors = [];
            for (let i = 0; i < numColors; i++) {
                const randomColor = `hsl(${Math.floor(Math.random() * 360)}, 100%, 75%)`; // HSL for vibrant colors
                colors.push(randomColor);
            }
            return colors;
        }

        const backgroundColors = generateRandomColors(categoryLabels.length); // Generate distinct colors

        const myPieChart = new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Sold Items',
                    data: categoryValues,
                    backgroundColor: backgroundColors, // Use generated colors
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: `Sold Items (Total: ${totalSoldItems})`, // Display total items in the title
                    },
                    datalabels: {
                        color: '#fff', // Set the label text color
                        formatter: (value, context) => {
                            const percentage = ((value / totalSoldItems) * 100).toFixed(2); // Calculate percentage
                            return `${percentage}%`; // Return only the percentage
                        },
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            }
        });
    </script>

    <!-- Line Chart for Sales per Shop -->
    <script>
        // Line Chart for displaying total sales per day for the user's shop
        const lineCtx = document.getElementById('myLineChart').getContext('2d');

        // Parse the sales data from the backend
        const salesData = <?= json_encode($salesPerShop) ?>;

        // Extract dates and sales totals for the line chart
        const saleDates = salesData.map(sale => sale.sale_date); // X-axis: sale dates
        const totalSales = salesData.map(sale => sale.total_sales); // Y-axis: total sales

        const myLineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: saleDates, // Dates for the x-axis
                datasets: [{
                    label: 'Total Sales',
                    data: totalSales, // Total sales for each date
                    borderColor: getRandomColor(),
                    tension: 0.1,
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            tooltipFormat: 'DD ',
                            displayFormats: {
                                day: 'DD '
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
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Sales (₱)'
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

    <!-- bar chart script -->
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