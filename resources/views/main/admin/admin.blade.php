@extends('layouts.admin.adminMaster')

@section('content')
<div class="text-center" style="background-color: #D4DFE8;">
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>

<div class="container-dash">
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
                    <div class="progress"></div>
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
                    <div class="progress"></div>
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
                    <div class="progress"></div>
                </div>
                <small>Last 24 Hours</small>
            </div>
            <!-- End income -->
        </div>
        <!-- End insights -->

        <!-- Start Pie and Bar Charts Side by Side -->
        <div class="charts">
            <div class="chart-container">
                <h3>Order Breakdown</h3>
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
            const myPieChart = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: ['Beverages', 'Snacks', 'Meals', 'Desserts'],
                    datasets: [{
                        label: 'Order Breakdown',
                        data: [300, 150, 200, 100],
                        backgroundColor: ['#7380ec', '#ff7782', '#41f1b6', '#ffcd56'],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            const barCtx = document.getElementById('myBarChart').getContext('2d');
            const myBarChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: ['Mini USB', 'Keyboard', 'Monitor', 'Mouse', 'Laptop'], // Sample product names
                    datasets: [{
                        label: 'Recent Orders',
                        data: [4563, 1234, 2345, 987, 3456], // Corresponding product numbers
                        backgroundColor: ['#7380ec', '#ff7782', '#41f1b6', '#ff4edc', '#7d8da1'], // Custom colors for each bar
                        borderRadius: 5,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

    </main>

    <!-- Redesigned Recent Update Section -->
    <div class="recent-update">
        <h2>Recent Update</h2>
        <ul>
            <li>
                <div class="profile-photo">
                    <img src="https://via.placeholder.com/50" alt="Profile Photo">
                </div>
                <div class="message">
                    <b>Babar</b> received his order of food
                </div>
                <div class="time">5 mins ago</div>
            </li>
            <li>
                <div class="profile-photo">
                    <img src="https://via.placeholder.com/50" alt="Profile Photo">
                </div>
                <div class="message">
                    <b>Ali</b> received his order of food
                </div>
                <div class="time">10 mins ago</div>
            </li>
            <!-- Add more recent updates here -->
        </ul>
    </div>
    <!-- End of Redesigned Recent Update Section -->
</div>

@endsection