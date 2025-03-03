<?php
require_once 'includes/Student.php';

$database = new Database();
$db = $database->getConnection();

$student = new Student($db);

// Get page parameters
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$department = isset($_GET['department']) ? $_GET['department'] : '';
$per_page = 5;

// Get students
$result = $student->read($search, $department, $page, $per_page);
$total_students = $student->getTotal($search, $department);
$total_pages = ceil($total_students / $per_page);

// Get unique departments for filter
$dept_query = "SELECT DISTINCT department FROM students ORDER BY department";
$dept_stmt = $db->prepare($dept_query);
$dept_stmt->execute();
$departments = $dept_stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="page-title">Students</h2>
        <p class="text-muted">Manage and view all student records</p>
    </div>
    <?php if ($_SESSION['user_role'] === 'admin'): ?>
    <div class="col-md-6 text-end">
        <a href="index.php?page=add-student" class="btn btn-primary add-student-btn">
            <i class="fas fa-plus me-2"></i>Add New Student
        </a>
    </div>
    <?php endif; ?>
</div>

<div class="card mb-4 search-card">
    <div class="card-body">
        <form method="GET" action="index.php">
            <input type="hidden" name="page" value="students">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Search students..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <select name="department" class="form-control">
                        <option value="">All Departments</option>
                        <?php foreach ($departments as $dept): ?>
                        <option value="<?php echo htmlspecialchars($dept); ?>" <?php echo $department === $dept ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($dept); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card student-list-card">
    <div class="card-body">
        <div class="table-responsive student-table">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Department</th>
                        <th>Enrollment Date</th>
                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['department']); ?></td>
                        <td><?php echo date('M d, Y', strtotime($row['enrollment_date'])); ?></td>
                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <td>
                            <a href="index.php?page=edit-student&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                            <button type="button" class="btn btn-sm btn-danger" 
                                    onclick="deleteStudent(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['name']); ?>')">
                                Delete
                            </button>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endwhile; ?>
                    <?php if ($result->rowCount() === 0): ?>
                    <tr>
                        <td colspan="<?php echo $_SESSION['user_role'] === 'admin' ? '7' : '6'; ?>" class="text-center">
                            No students found.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_pages > 1): ?>
<nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center modern-pagination">
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?page=students&p=<?php echo ($page - 1); ?>&search=<?php echo urlencode($search); ?>&department=<?php echo urlencode($department); ?>">
                        Previous
                    </a>
                </li>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                    <a class="page-link" href="index.php?page=students&p=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&department=<?php echo urlencode($department); ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
                <?php endfor; ?>
                
                <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?page=students&p=<?php echo ($page + 1); ?>&search=<?php echo urlencode($search); ?>&department=<?php echo urlencode($department); ?>">
                        Next
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade modern-modal" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pb-0">
                <div class="delete-icon mb-4">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <h3 class="modal-title mb-3">Delete Confirmation</h3>
                <p class="text-muted mb-4">Are you sure you want to delete <br><strong id="studentName" class="text-dark"></strong>?</p>
                <p class="small text-danger mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-light btn-lg px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <form method="POST" action="actions/delete-student.php" class="d-inline">
                    <input type="hidden" name="id" id="deleteId">
                    <button type="submit" class="btn btn-danger btn-lg px-4">
                        <i class="fas fa-trash-alt me-2"></i>Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function deleteStudent(id, name) {
    document.getElementById('deleteId').value = id;
    document.getElementById('studentName').textContent = name;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
