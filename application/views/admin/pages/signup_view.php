<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patient Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    * {
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: 0;
        padding: 20px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    input[type=text],
    input[type=email],
    input[type=tel],
    input[type=password],
    select,
    textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        resize: vertical;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    input:focus,
    select:focus {
        border-color: #1a73e8;
        box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.2);
        outline: none;
    }

    label {
        padding: 12px 12px 12px 0;
        display: inline-block;
        font-weight: 500;
        color: #333;
    }

    input[type=submit] {
        background-color: #1a73e8;
        color: white;
        padding: 14px 30px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 10px;
    }

    input[type=submit]:hover {
        background-color: #0d62d9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .container {
        border-radius: 10px;
        background-color: white;
        padding: 30px;
        width: 100%;
        max-width: 600px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .col-25 {
        float: left;
        width: 30%;
        margin-top: 12px;
    }

    .col-75 {
        float: left;
        width: 70%;
        margin-top: 12px;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    .login-header {
        background: linear-gradient(135deg, #2c3e50, #34495e);
        color: white;
        padding: 25px;
        text-align: center;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .login-header i {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .login-header h3 {
        margin: 0 0 10px 0;
        font-size: 24px;
    }

    .login-header p {
        margin: 0;
        opacity: 0.9;
    }

    .form-footer {
        text-align: center;
        margin-top: 20px;
        color: #666;
    }

    .form-footer a {
        color: #1a73e8;
        text-decoration: none;
        font-weight: 500;
    }

    .form-footer a:hover {
        text-decoration: underline;
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }

    .input-icon input {
        padding-left: 40px;
    }

    /* Responsive layout */
    @media screen and (max-width: 600px) {

        .col-25,
        .col-75 {
            width: 100%;
            margin-top: 8px;
        }

        .container {
            padding: 20px;
        }
    }

    .required::after {
        content: " *";
        color: #e53935;
    }

    .error-message {
        color: #e53935;
        font-size: 14px;
        margin-top: 5px;
        display: none;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-header">
            <i class="fas fa-heartbeat"></i>
            <h3>Healthcare Portal</h3>
            <p class="mb-0">Doctor & Admin Registration</p>
        </div>

        <form method="post" action="<?=base_url('admin/do_doctor_signup')?>" onsubmit="return validatePasswords()">
            <!-- Name Field -->
            <div class="row">
                <div class="col-25">
                    <label for="name" class="required">Full Name</label>
                </div>
                <div class="col-75 input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                </div>
            </div>

            <!-- Email Field -->
            <div class="row">
                <div class="col-25">
                    <label for="email" class="required">Email Address</label>
                </div>
                <div class="col-75 input-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                </div>
            </div>

            <!-- Phone Field -->
            <div class="row">
                <div class="col-25">
                    <label for="phone" class="required">Phone Number</label>
                </div>
                <div class="col-75 input-icon">
                    <i class="fas fa-phone"></i>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div>
            </div>
             <div class="row">
                <div class="col-25">
                    <label for="spicialist" class="required">Spicialist</label>
                </div>
                <div class="col-75 input-icon">
                    <i class="fas fa-user-doctor"></i>
                    <input type="tel" id="spicialist" name="spicialist" placeholder="Enter your phone number" required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="role" class="required">Select Your Role</label>
                </div>
                <div class="col-75 input-icon">
                    <select name="role" class="form-select" required>
                        <option value="" selected disabled>Choose Your</option>
                        <option value="1">Adimin Registration</option>
                        <option value="2">Doctor Registration</option>
                    </select>
                </div>
            </div>
            <!-- Password Field -->
            <div class="row">
                <div class="col-25">
                    <label for="password" class="required">Password</label>
                </div>
                <div class="col-75 input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                </div>
            </div>

            <!-- Confirm Password Field -->
            <div class="row">
                <div class="col-25">
                    <label for="confirm_password" class="required">Confirm Password</label>
                </div>
                <div class="col-75 input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="confirm_password" name="confirm_password"
                        placeholder="Re-enter your password" required>
                </div>
            </div>

            <!-- Error Message -->
            <div class="row">
                <div class="error-message" id="password-error">Passwords do not match</div>
            </div>

            <!-- Submit Button -->
            <div class="row">
                <input type="submit" value="Create Account">
            </div>

            <div class="form-footer">
                <p>Already have an account? <a href="<?=base_url('admin/login')?>">Sign In</a></p>
            </div>
        </form>
    </div>

    <script>
    function validatePasswords() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        var errorElement = document.getElementById("password-error");

        if (password !== confirmPassword) {
            errorElement.style.display = "block";
            return false;
        }

        return true;
    }
    </script>
</body>

</html>