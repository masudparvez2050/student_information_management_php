<?php
requireAdmin();

$error = '';
$success = '';
$departments = ['Computer Science', 'Business Administration', 'Electrical Engineering', 'Civil Engineering', 'Law'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $student = new Student($db);
    
    // Validate inputs
    $required_fields = ['student_id', 'name', 'email', 'department', 'enrollment_date'];
    $missing_fields = [];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $missing_fields[] = ucfirst(str_replace('_', ' ', $field));
        }
    }
    
    if (!empty($missing_fields)) {
        $error = 'Please fill in the following fields: ' . implode(', ', $missing_fields);
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } elseif ($student->checkStudentIdExists($_POST['student_id'])) {
        $error = 'Student ID already exists';
    } else {
        $student->student_id = $_POST['student_id'];
        $student->name = $_POST['name'];
        $student->email = $_POST['email'];
        $student->phone = $_POST['phone'];
        $student->department = $_POST['department'];
        $student->enrollment_date = $_POST['enrollment_date'];
        
        try {
            if ($student->create()) {
                $success = 'Student added successfully';
                // Clear form data on success
                $_POST = array();
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            if ($e instanceof PDOException) {
                error_log($e->getMessage());
                $error = 'A database error occurred. Please try again.';
            }
        }
    }
}
?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="page-header mb-4">
            <h2 class="page-title">Add New Student</h2>
            <p class="text-muted">Fill in the form below to add a new student to the system</p>
        </div>
        
        <div class="card form-card">
            <div class="card-body p-4">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>

                <form method="POST" action="" class="modern-form">
                    <div class="row">
                        <!-- Personal Information Section -->
                        <div class="col-12 mb-4">
                            <h5 class="form-section-title">Personal Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="student_id" name="student_id" 
                                               placeholder="Enter Student ID"
                                               value="<?php echo isset($_POST['student_id']) ? htmlspecialchars($_POST['student_id']) : ''; ?>"
                                               required>
                                        <label for="student_id">Student ID *</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name" 
                                               placeholder="Enter Full Name"
                                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                                               required>
                                        <label for="name">Full Name *</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="col-12 mb-4">
                            <h5 class="form-section-title">Contact Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" 
                                               placeholder="Enter Email"
                                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                               required>
                                        <label for="email">Email Address *</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="phone" name="phone" 
                                               placeholder="Enter Phone Number"
                                               value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                                        <label for="phone">Phone Number</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Information Section -->
                        <div class="col-12 mb-4">
                            <h5 class="form-section-title">Academic Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-control" id="department" name="department" required>
                                            <option value="">Select Department</option>
                                            <?php foreach ($departments as $dept): ?>
                                            <option value="<?php echo htmlspecialchars($dept); ?>"
                                                    <?php echo (isset($_POST['department']) && $_POST['department'] === $dept) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($dept); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="department">Department *</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="enrollment_date" name="enrollment_date" 
                                               placeholder="Select Date"
                                               value="<?php echo isset($_POST['enrollment_date']) ? htmlspecialchars($_POST['enrollment_date']) : date('Y-m-d'); ?>"
                                               required>
                                        <label for="enrollment_date">Enrollment Date *</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Add Student
                        </button>
                        <a href="index.php?page=students" class="btn btn-light btn-lg">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
