<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedCare - Doctor Appointment System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header Styles */
        header {
            background: linear-gradient(135deg, #1a73e8, #6c8ef5);
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            display: flex;
            align-items: center;
        }
        
        .logo i {
            margin-right: 10px;
            font-size: 32px;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 25px;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        nav ul li a:hover {
            color: #e0e0e0;
        }
        
        .auth-buttons {
            display: flex;
            gap: 15px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-outline:hover {
            background: white;
            color: #1a73e8;
        }
        
        .btn-primary {
            background-color: white;
            color: #1a73e8;
        }
        
        .btn-primary:hover {
            background-color: #f0f0f0;
        }
        
        /* Hero Section */
        .hero {
            padding: 80px 0;
            background: linear-gradient(rgba(26, 115, 232, 0.9), rgba(108, 142, 245, 0.9)), url('https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .hero p {
            font-size: 20px;
            max-width: 700px;
            margin: 0 auto 30px;
        }
        
        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        
        .btn-large {
            padding: 15px 30px;
            font-size: 18px;
        }
        
        /* Features Section */
        .features {
            padding: 80px 0;
            background-color: white;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-title h2 {
            font-size: 36px;
            color: #1a73e8;
            margin-bottom: 15px;
        }
        
        .section-title p {
            font-size: 18px;
            color: #5f6368;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .feature-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: #e8f0fe;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: #1a73e8;
            font-size: 32px;
        }
        
        .feature-card h3 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #1a73e8;
        }
        
        .feature-card p {
            color: #5f6368;
        }
        
        /* How It Works Section */
        .how-it-works {
            padding: 80px 0;
            background-color: #f5f7fa;
        }
        
        .steps {
            display: flex;
            justify-content: space-between;
            max-width: 900px;
            margin: 0 auto;
            position: relative;
        }
        
        .steps::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 10%;
            right: 10%;
            height: 3px;
            background: #1a73e8;
            z-index: 1;
        }
        
        .step {
            text-align: center;
            position: relative;
            z-index: 2;
            flex: 1;
            padding: 0 15px;
        }
        
        .step-number {
            width: 80px;
            height: 80px;
            background: #1a73e8;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: bold;
            margin: 0 auto 20px;
            box-shadow: 0 4px 10px rgba(26, 115, 232, 0.3);
        }
        
        .step h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #1a73e8;
        }
        
        /* Testimonials */
        .testimonials {
            padding: 80px 0;
            background-color: white;
        }
        
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .testimonial-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
            color: #5f6368;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
        }
        
        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: #5f6368;
            font-weight: bold;
        }
        
        .author-info h4 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .author-info p {
            color: #5f6368;
            font-size: 14px;
        }
        
        /* CTA Section */
        .cta {
            padding: 80px 0;
            background: linear-gradient(135deg, #1a73e8, #6c8ef5);
            color: white;
            text-align: center;
        }
        
        .cta h2 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        
        .cta p {
            font-size: 18px;
            max-width: 600px;
            margin: 0 auto 30px;
        }
        
        /* Footer */
        footer {
            background: #202124;
            color: #e8eaed;
            padding: 50px 0 20px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-column h3 {
            font-size: 18px;
            margin-bottom: 20px;
            color: white;
        }
        
        .footer-column ul {
            list-style: none;
        }
        
        .footer-column ul li {
            margin-bottom: 10px;
        }
        
        .footer-column ul li a {
            color: #e8eaed;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-column ul li a:hover {
            color: #1a73e8;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            background: #5f6368;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: background 0.3s ease;
        }
        
        .social-links a:hover {
            background: #1a73e8;
        }
        
        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #5f6368;
            font-size: 14px;
            color: #9aa0a6;
        }
        
        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            
            nav ul {
                margin: 20px 0;
                justify-content: center;
            }
            
            .hero h1 {
                font-size: 36px;
            }
            
            .hero p {
                font-size: 18px;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .steps {
                flex-direction: column;
                gap: 40px;
            }
            
            .steps::before {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <i class="fas fa-stethoscope"></i>
                    MedCare
                </div>
                <nav>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Features</a></li>
                        <li><a href="#">How It Works</a></li>
                        <li><a href="#">Testimonials</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </nav>
                <div class="auth-buttons">
                    <a href="<?=base_url('index/login')?>" class="btn btn-outline">Log In</a>
                    <a href="<?=base_url('index/signup')?>" class="btn btn-primary">Sign Up</a>
                </div>
            </div>
        </div>
    </header>