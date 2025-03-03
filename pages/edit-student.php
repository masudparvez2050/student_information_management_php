<?php
requireAdmin();

if (!isset($_GET['id'])) {
    header('Location: index.php?page=students');
    exit();
}

$database = new Database();
$db = $database->getConnection();
$student = new Student($db);

$student->id = $_GET['id'];
if (!$student->readOne()) {
    header('Location: index.php?page=students');
    exit();
}

$error = '';
$success = '';
$departments = ['Computer Science', 'Business Administration', 'Electrical Engineering', 'Civil Engineering', 'Law'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $required_fields = ['name', 'email', 'department', 'enrollment_date'];
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
    } else {
        $student->name = $_POST['name'];
        $student->email = $_POST['email'];
        $student->phone = $_POST['phone'];
        $student->department = $_POST['department'];
        $student->enrollment_date = $_POST['enrollment_date'];
        
        try {
            if ($student->update()) {
                $success = 'Student updated successfully';
                // Refresh student data
                $student->readOne();
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
            <h2 class="page-title">Edit Student</h2>
            <p class="text-muted">Update student information in the form below</p>
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
                                        <input type="text" class="form-control" id="student_id" 
                                               placeholder="Student ID"
                                               value="<?php echo htmlspecialchars($student->student_id); ?>"
                                               disabled>
                                        <label for="student_id">Student ID</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name" 
                                               placeholder="Enter Full Name"
                                               value="<?php echo htmlspecialchars($student->name); ?>"
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
                                               value="<?php echo htmlspecialchars($student->email); ?>"
                                               required>
                                        <label for="email">Email Address *</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="phone" name="phone" 
                                               placeholder="Enter Phone Number"
                                               value="<?php echo htmlspecialchars($student->phone); ?>">
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
                                                    <?php echo $student->department === $dept ? 'selected' : ''; ?>>
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
                                               value="<?php echo htmlspecialchars($student->enrollment_date); ?>"
                                               required>
                                        <label for="enrollment_date">Enrollment Date *</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Update Student
                        </button>
                        <a href="index.php?page=students" class="btn btn-light btn-lg">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
