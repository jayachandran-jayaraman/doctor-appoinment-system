<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 40px;
        }
        
        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            text-align: center;
            font-weight: 600;
        }
        
        .subtitle {
            color: #7f8c8d;
            text-align: center;
            margin-bottom: 30px;
            font-size: 16px;
            line-height: 1.5;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
        }
        
        .input-field {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        .input-field:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
        }
        
        .btn {
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 14px 20px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #2980b9;
        }
        
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link a {
            color: #3498db;
            text-decoration: none;
            font-size: 15px;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 15px;
        }
        
        .alert-error {
            background-color: #ffebee;
            color: #c62828;
            border-left: 4px solid #f44336;
        }
        
        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #4caf50;
        }
        
        .instructions {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 25px;
            font-size: 14px;
            color: #1565c0;
            border-left: 4px solid #2196f3;
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Forgot Password</h1>
        <p class="subtitle">Enter your email address and we'll send you a link to reset your password.</p>
        
        <!-- Validation Errors -->
        <?php if (isset($validation_errors) && !empty($validation_errors)): ?>
            <div class="alert alert-error">
                <?php echo $validation_errors; ?>
            </div>
        <?php endif; ?>
        
        <!-- Success Message (if applicable) -->
        <?php if (isset($success_message) && !empty($success_message)): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <div class="instructions">
            <strong>Note:</strong> You will receive an email with a password reset link. The link will expire in 1 hour for security reasons.
        </div>
        
        <form method="post" action="<?= base_url('user/send_password') ?>">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="input-field" placeholder="Enter your email address" required>
            </div>
            
            <button type="submit" class="btn">Send Reset Link</button>
        </form>
        
        <div class="back-link">
            <a href="<?= base_url('user/login') ?>">← Back to Login</a>
        </div>
    </div>
</body>
</html>