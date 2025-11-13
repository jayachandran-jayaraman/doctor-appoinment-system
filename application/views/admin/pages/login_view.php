<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Healthcare Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --patient-color: #3498db;
        --secondary-color: #2c3e50;
        --light-bg: #f8f9fa;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-container {
        max-width: 450px;
        width: 100%;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }

    .login-header {
        background: linear-gradient(135deg, var(--secondary-color), #34495e);
        color: white;
        padding: 25px;
        text-align: center;
    }

    .login-header i {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .login-body {
        padding: 30px;
    }

    .form-control {
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid #e1e5eb;
        transition: all 0.3s;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #e1e5eb;
    }

    .btn-login {
        background: var(--patient-color);
        border: none;
        color: white;
        padding: 12px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s;
        width: 100%;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        opacity: 0.9;
    }

    .alert {
        border-radius: 8px;
        border: none;
        padding: 12px 15px;
    }

    .login-footer {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid #e1e5eb;
        margin-top: 20px;
    }

    .patient-features {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }

    .role-features {
        list-style: none;
        padding: 0;
        margin: 15px 0 0 0;
    }

    .role-features li {
        padding: 5px 0;
        display: flex;
        align-items: center;
    }

    .role-features i {
        margin-right: 8px;
        font-size: 0.8rem;
        color: var(--patient-color);
    }

    .register-section {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-top: 25px;
        text-align: center;
    }

    .btn-register {
        background: transparent;
        border: 2px solid var(--patient-color);
        color: var(--patient-color);
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s;
        margin-top: 10px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-register:hover {
        background: var(--patient-color);
        color: white;
    }

    .demo-accounts {
        background-color: #e8f4f8;
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
        font-size: 0.85rem;
        border-left: 4px solid var(--patient-color);
    }

    .demo-accounts h6 {
        margin-bottom: 10px;
        color: var(--secondary-color);
    }

    .demo-account {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        border-bottom: 1px dashed #dee2e6;
    }

    .demo-account:last-child {
        border-bottom: none;
    }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <i class="fas fa-heartbeat"></i>
            <h3>Healthcare Portal</h3>
            <p class="mb-0">Patient Login & Registration</p>
        </div>

        <div class="login-body">
            <h4 class="text-center mb-4"> Login</h4>



            <!-- Flash message for errors -->
            <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= $error ?>
            </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="<?= base_url('admin/do_login')?>" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"
                            required >
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter your password" required >
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                    <a href="index/forgot_password" class="float-end">Forgot password?</a>
                </div>

                <button type="submit" name ="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> Login to Doctor & Admin Portal
                </button>
            </form>

            <!-- Registration Section -->
            <div class="register-section text-center border-top pt-4 mt-4">
                <p class="mb-2">Don't have an account?</p>
                <a href="<?=base_url('admin/doctor_signup')?>" class="btn btn-register btn-sm">
                    <i class="fas fa-user-plus me-2"></i> Create Account
                </a>
            </div>

            <div class="login-footer">
                <p class="mb-0">
                    Need help? <a href="contact.php" class="text-decoration-none">Contact support</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>