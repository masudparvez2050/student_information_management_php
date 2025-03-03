<?php
$user = getCurrentUser();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($current_password)) {
        $error = 'Current password is required';
    } elseif (empty($new_password)) {
        $error = 'New password is required';
    } elseif (empty($confirm_password)) {
        $error = 'Please confirm your new password';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New passwords do not match';
    } else {
        // Verify current password
        $query = "SELECT password FROM users WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($current_password, $row['password'])) {
                // Update password
                $query = "UPDATE users SET password = :password WHERE id = :id";
                $stmt = $db->prepare($query);
                $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $new_hash);
                $stmt->bindParam(':id', $_SESSION['user_id']);
                
                if ($stmt->execute()) {
                    $success = 'Password updated successfully';
                } else {
                    $error = 'Error updating password';
                }
            } else {
                $error = 'Current password is incorrect';
            }
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="page-header mb-4">
            <h2 class="page-title">My Profile</h2>
            <p class="text-muted">Manage your account settings and change your password</p>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="card profile-card">
                    <div class="card-body text-center">
                        <div class="profile-avatar mb-4">
                            <?php
                            $initials = strtoupper(substr($user['email'], 0, 2));
                            ?>
                            <div class="avatar-circle-lg">
                                <?php echo htmlspecialchars($initials); ?>
                            </div>
                        </div>
                        <h4 class="mb-3"><?php echo htmlspecialchars($user['email']); ?></h4>
                        <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">
                            <?php echo ucfirst(htmlspecialchars($user['role'])); ?>
                        </span>
                        <p class="text-muted mb-0">Last login: Today at 9:30 AM</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card form-card">
                    <div class="card-body p-4">
                        <form method="POST" action="" class="modern-form">
                            <h5 class="form-section-title">Change Password</h5>
                            
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="current_password" 
                                           name="current_password" placeholder="Enter current password" required>
                                    <label for="current_password">Current Password</label>
                                </div>
                            </div>

                            <div class="password-section mb-4">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="new_password" 
                                           name="new_password" placeholder="Enter new password" required>
                                    <label for="new_password">New Password</label>
                                </div>

                                <div class="form-floating">
                                    <input type="password" class="form-control" id="confirm_password" 
                                           name="confirm_password" placeholder="Confirm new password" required>
                                    <label for="confirm_password">Confirm New Password</label>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-key me-2"></i>Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
