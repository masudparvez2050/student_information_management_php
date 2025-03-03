<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/images/nub.png" alt="NUB Logo" class="navbar-logo me-2" width="40" height="40">
            <div class="brand-text">
                <div class="brand-title">Northern University Bangladesh</div>
                <div class="brand-subtitle">Student Information Management</div>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center <?php echo empty($_GET['page']) || $_GET['page'] === 'dashboard' ? 'active' : ''; ?>" href="index.php">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center <?php echo isset($_GET['page']) && $_GET['page'] === 'students' ? 'active' : ''; ?>" href="index.php?page=students">
                        <i class="fas fa-users me-2"></i>
                        Students
                    </a>
                </li>
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center <?php echo isset($_GET['page']) && $_GET['page'] === 'add-student' ? 'active' : ''; ?>" href="index.php?page=add-student">
                        <i class="fas fa-user-plus me-2"></i>
                        Add Student
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar-circle me-2">
                            <i class="fas fa-user"></i>
                        </div>
                        <span><?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="index.php?page=profile">
                                <i class="fas fa-user-circle me-2"></i>
                                Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center text-danger" href="logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
