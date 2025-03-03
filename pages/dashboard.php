<?php
require_once 'includes/Student.php';

$database = new Database();
$db = $database->getConnection();

$student = new Student($db);

// Get total number of students
$total_students = $student->getTotal();

// Get total number of departments
$query = "SELECT COUNT(DISTINCT department) as dept_count FROM students";
$stmt = $db->prepare($query);
$stmt->execute();
$dept_count = $stmt->fetch(PDO::FETCH_ASSOC)['dept_count'];

// Get department-wise statistics
$query = "SELECT department, COUNT(*) as count FROM students GROUP BY department";
$stmt = $db->prepare($query);
$stmt->execute();
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate percentage for each department
$total = array_sum(array_column($departments, 'count'));
foreach ($departments as &$dept) {
    $dept['percentage'] = $total > 0 ? round(($dept['count'] / $total) * 100) : 0;
}
unset($dept);

// Get latest enrollments
$query = "SELECT * FROM students ORDER BY enrollment_date DESC, created_at DESC LIMIT 5";
$stmt = $db->prepare($query);
$stmt->execute();
$latest_students = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get monthly enrollment stats for current year
$query = "SELECT COUNT(*) as count, MONTH(enrollment_date) as month 
          FROM students 
          WHERE YEAR(enrollment_date) = YEAR(CURRENT_DATE)
          GROUP BY MONTH(enrollment_date)
          ORDER BY month";
$stmt = $db->prepare($query);
$stmt->execute();
$monthly_stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

$months = array_fill(1, 12, 0);
foreach ($monthly_stats as $stat) {
    $months[$stat['month']] = $stat['count'];
}
$monthly_data = implode(',', array_values($months));
?>

<style>
.stat-trend {
    font-size: 0.9rem;
    padding: 0.2rem 0.5rem;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}
.trend-up {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}
.trend-down {
    background: rgba(255, 59, 48, 0.1);
    color: #ff3b30;
}
.activity-item {
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 0.5rem;
    background: rgba(255, 255, 255, 0.6);
    transition: all 0.3s ease;
}
.activity-item:hover {
    background: rgba(255, 255, 255, 0.9);
    transform: translateX(5px);
}
.chart-container {
    position: relative;
    height: 300px;
    margin-top: 1rem;
}
</style>

<div class="container py-4">
    <h2 class="dashboard-title mb-4">
        <i class="fas fa-tachometer-alt me-2"></i>Dashboard Overview
    </h2>


    <div class="row mb-4" >
        <div class="col-md-4" >
            <div class="stat-card position-relative overflow-hidden" style="background: linear-gradient(135deg,rgb(99, 26, 128) 0%,rgb(76, 29, 206) 100%); padding: 1rem;">
            <div class="position-absolute top-0 end-0 mt-3 me-3">
                <div class="stat-icon">
                <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="position-relative text-center" >
                <div class="text-white stat-label display-6 fw-bold">Total Students</div>
                <div class="stat-numbers mt-3 mb-3 display-5 fw-bold text-white"><?php echo $total_students; ?></div>
                <div class="text-white d-flex align-items-center">
                <div class="stat-trend trend-up me-2">
                    <i class="fas fa-arrow-up me-1"></i>
                    12%
                </div>
                <span class="stat-period ">vs last month</span>
                </div>
            </div>
            <div class="card-glass"></div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="stat-card p-4" style="background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);">
                <div class="text-white display-6 fw-bold">Total Departments</div>
                <div class="stat-numbers mt-2 text-center text-white display-5 fw-bold"><?php echo $dept_count; ?></div>
                <div class="text-white mt-2">
                    <i class="fas fa-building me-1"></i>
                    Active Departments
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="stat-card p-4" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <div class="text-white stat-label text-center display-6 fw-bold">New Enrollments</div>
                <div class="stat-numbers mt-2 text-center text-white display-5 fw-bold"><?php echo array_sum(array_slice($months,1)); ?></div>
                <div class="text-white mt-2">
                    <i class="fas fa-user-plus me-1"></i>
                    Recent Months
                    <span class="stat-trend trend-up ms-2">
                        <i class="fas fa-arrow-up"></i>
                        8%
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="stat-card p-4">
                <h5 class="card-title">
                    <i class="fas fa-chart-line me-2"></i>
                    Enrollment Trends
                </h5>
                <div class="chart-container">
                    <canvas id="enrollmentChart"></canvas>
                </div>
            </div>
            <br>
             <div class="stat-card p-4">
                <h5 class="card-title mb-4">
                    <i class="fas fa-history me-2"></i>
                    Recent Enrollments
                </h5>
                <?php foreach ($latest_students as $student): ?>
                <div class="activity-item" style="background: #e6e9f0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1"><?php echo htmlspecialchars($student['name']); ?></h6>
                            <small class="text-muted">
                                <i class="fas fa-id-card me-1"></i>
                                <?php echo htmlspecialchars($student['student_id']); ?> |
                                <i class="fas fa-building me-1"></i>
                                <?php echo htmlspecialchars($student['department']); ?>
                            </small>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Enrolled on</div>
                            <strong><?php echo date('M d, Y', strtotime($student['enrollment_date'])); ?></strong>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="stat-card p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>
                        Department Distribution
                    </h5>
                    <div class="card-actions">
                        <button class="btn btn-sm btn-light rounded-circle" title="Refresh">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="departments-list">
                    <?php foreach ($departments as $dept): ?>
                    <div class="dept-item mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <div class="dept-icon me-2 mb-1">
                                    <i class="fas fa-building"></i>
                                </div>
                                <span class="dept-name"><?php echo htmlspecialchars($dept['department']); ?></span>
                            </div>
                            <span class="dept-count"><?php echo $dept['count']; ?> students</span>
                        </div>
                        <div class="dept-progress">
                            <div class="dept-progress-bar" style="width: <?php echo $dept['percentage']; ?>%">
                                <span class="progress-label"><?php echo $dept['percentage']; ?>%</span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="stat-card p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="quick-actions-grid">
                    <a href="index.php?page=students" class="quick-action-card">
                        <div class="quick-action-icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="quick-action-text">
                            <h6>View All</h6>
                            <span>Students List</span>
                        </div>
                    </a>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <a href="index.php?page=add-student" class="quick-action-card">
                        <div class="quick-action-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="quick-action-text">
                            <h6>Add New</h6>
                            <span>Student</span>
                        </div>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    

    
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('enrollmentChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Monthly Enrollments',
                data: [<?php echo $monthly_data; ?>],
                borderColor: '#1e3c72',
                backgroundColor: 'rgba(30, 60, 114, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
