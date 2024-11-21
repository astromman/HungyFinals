@extends('layouts.seller.sellerMaster')

@section('content')
<div class="container-fluid">
    <main>
        <div>
            <table>
                <tbody>
                    <tr>
                        <td>
                            <h1>Dashboard</h1>
                        </td>
                        <td class="px-2">
                            @if($shop->is_reopen)
                            <div class="px-3 rounded-2 bg-primary-subtle">
                                <span class="text-success">Online</span>
                                <i class="bi bi-circle-fill text-success"></i>
                            </div>
                            ‎
                            @else
                            <div class="px-3 rounded-2 bg-primary-subtle">
                                <span class="text-danger">Offline</span>
                                <i class="bi bi-circle-fill text-danger"></i>
                            </div>
                            ‎
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Add a label to indicate that all data refers to online orders -->
        <div class="insights">
            <div class="sales shadow ">
                <i class="bi bi-hourglass-split"></i>
                <div class="middle">
                    <div class="left">
                        <h3>Pending Orders</h3> <!-- Indicating online-only orders -->
                        <h1>{{ $pending }}</h1>
                    </div>
                </div>
                <small>Last 24 Hours (Online)</small> <!-- Online Orders Label -->
            </div>

            <div class="expenses shadow">
                <i class="bi bi-check2-circle"></i>
                <div class="middle">
                    <div class="left">
                        <h3>Completed Orders</h3> <!-- Indicating online-only orders -->
                        <h1>{{ $totalNumberOfOrders }}</h1>
                    </div>
                </div>
                <small>Last 24 Hours (Online)</small> <!-- Online Orders Label -->
            </div>

            <div class="income shadow">
                <i class="bi bi-cash-stack"></i>
                <div class="middle">
                    <div class="left">
                        <h3>Total Income</h3> <!-- Indicating online-only orders -->
                        <h1>₱ {{ number_format($totalIncome, 2) }}</h1>
                    </div>
                </div>
                <small>All Time (Online)</small> <!-- Online Orders Label -->
            </div>
        </div>
    </main>

    <h2 class="pt-2">Analytics</h2>
    <!-- Start Pie and Bar Charts Side by Side -->
    <div class="row">
        <div class="charts col-lg-4 col-12">
            <div class="chart-container shadow pb-5">
                <h3>Sold Items per Categories</h3>
                <canvas id="myPieChart"></canvas>
                <p class="text-muted" style="font-size: 0.8rem;">(Data from Online Orders Only)</p> <!-- Online Orders Label -->
            </div>
        </div>

        <div class="charts col-lg-8 col-12">
            <div class="chart-container shadow pb-5">
                <h3>Most Sold Products</h3>
                <canvas id="myBarChart"></canvas>
                <p class="text-muted" style="font-size: 0.8rem;">(Data from Online Orders Only)</p> <!-- Online Orders Label -->
            </div>
        </div>
    </div>

    <div class="charts">
        <div class="chart-container shadow pb-5">
            <h3>Overall Income</h3>
            <canvas id="myLineChart"></canvas>
            <p class="text-muted" style="font-size: 0.8rem;">(Data from Online Orders Only)</p> <!-- Online Orders Label -->
        </div>
    </div>

    <!-- Add a footer note to indicate all data refers to online orders -->
    <footer class="text-center mt-4">
        <small class="text-muted">(All data displayed here represents online transactions only. No offline/POS data is included.)</small>
    </footer>
</div>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/luxon@3/build/global/luxon.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1"></script>

<!-- Doughnut chart script -->
<script>
    const pieCtx = document.getElementById('myPieChart').getContext('2d');
    const categoryLabels = <?= json_encode(array_keys($categoriesData)) ?>;
    const categoryValues = <?= json_encode(array_values($categoriesData)) ?>;
    const totalSoldItems = <?= $totalSoldItems ?>;

    // Function to generate random colors
    function generateRandomColors(numColors) {
        const colors = [];
        for (let i = 0; i < numColors; i++) {
            const randomColor = `hsl(${Math.floor(Math.random() * 360)}, 100%, 75%)`; // HSL for vibrant colors
            colors.push(randomColor);
        }
        return colors;
    }

    const pieChartBGColors = generateRandomColors(categoryLabels.length);

    const myPieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: categoryLabels,
            datasets: [{
                label: 'Sold Items',
                data: categoryValues,
                backgroundColor: pieChartBGColors,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: `Sold Items (Total: ${totalSoldItems})`,
                },
                datalabels: {
                    color: '#fff',
                    formatter: (value, context) => {
                        const percentage = ((value / totalSoldItems) * 100).toFixed(2);
                        return `${percentage}%`;
                    },
                    font: {
                        weight: 'bold'
                    }
                },
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
    const lineCtx = document.getElementById('myLineChart').getContext('2d');
    const salesData = <?= json_encode($salesPerShop) ?>;
    const saleDates = salesData.map(sale => sale.sale_date);
    const totalSales = salesData.map(sale => sale.total_sales);

    const myLineChart = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: saleDates,
            datasets: [{
                label: 'Total Sales',
                data: totalSales,
                borderColor: getRandomColor(),
                tension: 0.1,
                borderWidth: 2,
                pointRadius: 5,
                pointBackgroundColor: '#fff',
                pointBorderWidth: 3
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

<!-- Bar chart script -->
<script>
    const barCtx = document.getElementById('myBarChart').getContext('2d');
    const mostSoldProducts = <?= json_encode($mostSoldProducts) ?>;
    const productNames = mostSoldProducts.map(product => product.product_name);
    const soldQuantities = mostSoldProducts.map(product => product.sold);

    const barGraphBGColor = generateRandomColors(productNames.length);

    const myBarChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: productNames,
            datasets: [{
                label: 'Sold Items',
                data: soldQuantities,
                backgroundColor: barGraphBGColor,
                borderRadius: 5,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'right', // Position legend vertically
                    labels: {
                        generateLabels: function(chart) {
                            return productNames.map(function(name, i) {
                                return {
                                    text: name,
                                    fillStyle: barGraphBGColor[i],
                                    strokeStyle: barGraphBGColor[i],
                                    lineWidth: 0
                                };
                            });
                        }
                    }
                }
            },
            scales: {
                x: {
                    display: false // Hide x-axis labels
                },
                y: {
                    beginAtZero: true // Start y-axis at 0
                }
            }
        }
    });
</script>

@endsection