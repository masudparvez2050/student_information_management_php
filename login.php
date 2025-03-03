<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        try {
            if (login($email, $password)) {
                header('Location: index.php');
                exit();
            } else {
                $error = 'Invalid email or password';
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Northern University Bangladesh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        .login-header {
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem 0;
            position: relative;
        }
        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            opacity: 0.1;
            z-index: 0;
        }
        .login-logo {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            margin: 0 auto 1rem;
            
            position: relative;
            z-index: 1;
            display: block;
        }
        .login-title {
            color: #1e3c72;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 0.2rem;
            position: relative;
            z-index: 1;
        }
        .login-subtitle {
            color: #1e3c72;
            font-size: 1rem;
            opacity: 0.8;
            position: relative;
            z-index: 1;
        }
        .form-floating > label {
            color: #1e3c72;
            opacity: 0.8;
        }
        .form-control {
            border: 2px solid #e1e5eb;
            border-radius: 12px;
            height: calc(3.5rem + 2px);
            line-height: 1.25;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }
        .form-control:focus {
            border-color: #1e3c72;
            box-shadow: 0 0 0 0.2rem rgba(30, 60, 114, 0.15);
            background: #fff;
        }
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            color: #1e3c72;
            opacity: 1;
            transform: scale(.85) translateY(-1rem) translateX(.15rem);
        }
        .btn-login {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            color: white;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 60, 114, 0.3);
            background: linear-gradient(45deg, #2a5298, #1e3c72);
            color: white;
        }
        .alert {
            border-radius: 12px;
            border: none;
            background: rgba(255, 59, 48, 0.1);
            color: #ff3b30;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-container">
                    <div class="login-header text-center">
                        <img src="assets/images/nub.png" alt="NUB Logo" class="login-logo">
                        <div class="login-title">Northern University Bangladesh</div>
                        <div class="login-subtitle">Student Information Management</div>
                    </div>
                    <div class="card-body p-4">
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                                <label for="email">Email address</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                            <button type="submit" class="btn btn-login w-100">
                                Sign In
                            </button>
                        </form>

                    <div class="text-center mt-3"><small class="text-muted"><i class="fas fa-info-circle me-1"></i>Login with <span class="badge bg-primary">admin@nub.ac.bd</span> / <span class="badge bg-primary">admin123</span></small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
