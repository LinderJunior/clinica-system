<?php 
include_once __DIR__ . '/../src/components/header.php';
include_once __DIR__ . '/../src/services/DashboardService.php';

// Get dashboard data
$stats = DashboardService::getStatistics();
$monthlyData = DashboardService::getMonthlyData();
$activities = DashboardService::getRecentActivities();
?>

<style>
.dashboard-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.stat-card {
    background: linear-gradient(135deg, var(--card-bg), var(--card-bg-light));
    color: white;
    padding: 25px;
    position: relative;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    transform: translate(30px, -30px);
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 10px 0;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 0;
}

.stat-icon {
    font-size: 2.5rem;
    opacity: 0.8;
}

.chart-container {
    position: relative;
    height: 350px;
    padding: 20px;
}

.feed-item {
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
    transition: background-color 0.3s ease;
}

.feed-item:hover {
    background-color: #f8f9fa;
}

.feed-item:last-child {
    border-bottom: none;
}

.feed-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    margin-right: 15px;
}

.feed-time {
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 5px;
}

.modern-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 2px 15px rgba(0,0,0,0.08);
}

.card-header-modern {
    background: transparent;
    border-bottom: 1px solid #f0f0f0;
    padding: 20px 25px 15px;
}

.card-body-modern {
    padding: 20px 25px;
}

/* Color schemes for stat cards */
.card-orange { --card-bg: #ff6b35; --card-bg-light: #ff8c5a; }
.card-green { --card-bg: #28a745; --card-bg-light: #51c46a; }
.card-red { --card-bg: #dc3545; --card-bg-light: #e55a6a; }
.card-blue { --card-bg: #17a2b8; --card-bg-light: #45b8cc; }
</style>

<div class="pcoded-content">
    <div class="page-header card modern-card">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h4 class="mb-0">Dashboard</h4>
                        <p class="text-muted mb-0">Bem-vindo ao Sistema de Gestão da Clínica Linder</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="link.php?route=1"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    
                    <!-- Statistics Cards Row -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="dashboard-card stat-card card-orange">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="stat-label">Novos Pacientes</p>
                                        <h2 class="stat-value"><?php echo $stats['new_patients']; ?></h2>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="feather icon-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="dashboard-card stat-card card-green">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="stat-label">Receita</p>
                                        <h2 class="stat-value">$<?php echo $stats['income']; ?></h2>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="feather icon-dollar-sign"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="dashboard-card stat-card card-red">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="stat-label">Consultas</p>
                                        <h2 class="stat-value"><?php echo $stats['tickets']; ?></h2>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="feather icon-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="dashboard-card stat-card card-blue">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <p class="stat-label">Médicos</p>
                                        <h2 class="stat-value"><?php echo $stats['orders']; ?></h2>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="feather icon-user-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts and Feed Row -->
                    <div class="row">
                        <!-- Monthly Chart -->
                        <div class="col-xl-8 col-lg-7 mb-4">
                            <div class="card modern-card">
                                <div class="card-header card-header-modern">
                                    <h5 class="mb-0">Visão Mensal</h5>
                                    <small class="text-muted">Para mais detalhes sobre o uso, consulte amCharts licenças.</small>
                                </div>
                                <div class="card-body card-body-modern">
                                    <div class="chart-container">
                                        <canvas id="monthlyChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Feed -->
                        <div class="col-xl-4 col-lg-5 mb-4">
                            <div class="card modern-card">
                                <div class="card-header card-header-modern">
                                    <h5 class="mb-0">Feeds</h5>
                                </div>
                                <div class="card-body p-0">
                                    <?php foreach($activities as $index => $activity): ?>
                                    <div class="feed-item d-flex align-items-start">
                                        <div class="feed-avatar <?php echo $activity['type'] == 'patient' ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo $activity['type'] == 'patient' ? 'P' : 'C'; ?>
                                        </div>
                                        <div class="flex-grow-1">
                                            <p class="mb-1"><?php echo $activity['message']; ?></p>
                                            <div class="feed-time">Agora mesmo</div>
                                        </div>
                                        <div class="text-muted">
                                            <i class="feather icon-settings"></i>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Chart
const ctx = document.getElementById('monthlyChart').getContext('2d');
const monthlyChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($monthlyData['months']); ?>,
        datasets: [{
            label: 'Consultas',
            data: <?php echo json_encode($monthlyData['consults']); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            borderRadius: 8,
            borderSkipped: false,
        }, {
            label: 'Receita',
            data: <?php echo json_encode($monthlyData['revenue']); ?>,
            type: 'line',
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: 'rgba(255, 99, 132, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 20
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0,0,0,0.8)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: 'rgba(255,255,255,0.1)',
                borderWidth: 1,
                cornerRadius: 8,
                displayColors: true,
                mode: 'index',
                intersect: false,
            }
        },
        scales: {
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    color: '#6c757d'
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                },
                ticks: {
                    color: '#6c757d'
                }
            }
        }
    }
});
</script>