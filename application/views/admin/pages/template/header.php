<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #3498db;
      --secondary-color: #2c3e50;
      --accent-color: #1abc9c;
      --light-bg: #f8f9fa;
      --dark-text: #2c3e50;
      --border-color: #e0e0e0;
    }
    
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f7fa;
      color: var(--dark-text);
    }
    
    /* Header Styles */
    .dashboard-header {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      color: white;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .header-content {
      padding: 15px 0;
    }
    
    .patient-info {
      display: flex;
      align-items: center;
    }
    
    .patient-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      color: var(--primary-color);
      font-size: 24px;
    }
    
    .patient-details h3 {
      margin: 0;
      font-weight: 600;
    }
    
    .patient-details p {
      margin: 0;
      opacity: 0.9;
    }
    
    .nav-links {
      display: flex;
      justify-content: flex-end;
      align-items: center;
    }
    
    .nav-links a {
      color: white;
      text-decoration: none;
      margin-left: 25px;
      font-weight: 500;
      transition: all 0.3s;
      display: flex;
      align-items: center;
    }
    
    .nav-links a:hover {
      color: var(--accent-color);
    }
    
    .nav-links i {
      margin-right: 8px;
    }
    
    /* Main Content Styles */
    .main-content {
      min-height: calc(100vh - 140px);
      padding: 30px 0;
    }
    
    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      margin-bottom: 25px;
      transition: transform 0.3s;
    }
    
    .card:hover {
      transform: translateY(-5px);
    }
    
    .card-header {
      background-color: white;
      border-bottom: 1px solid var(--border-color);
      font-weight: 600;
      padding: 15px 20px;
      border-radius: 12px 12px 0 0 !important;
      color: var(--secondary-color);
    }
    
    .card-body {
      padding: 20px;
    }
    
    .btn-primary {
      background-color: var(--primary-color);
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 500;
    }
    
    .btn-primary:hover {
      background-color: #2980b9;
    }
    
    .table {
      margin-bottom: 0;
    }
    
    .table th {
      background-color: var(--light-bg);
      color: var(--secondary-color);
      font-weight: 600;
      border-top: none;
    }
    
    .status-badge {
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
    }
    
    .status-confirmed {
      background-color: #d4edda;
      color: #155724;
    }
    
    .status-pending {
      background-color: #fff3cd;
      color: #856404;
    }
    
    .status-cancelled {
      background-color: #f8d7da;
      color: #721c24;
    }
    
    .status-rescheduled {
      background-color: #d1ecf1;
      color: #0c5460;
    }
    
    /* Footer Styles */
    .dashboard-footer {
      background-color: var(--secondary-color);
      color: white;
      padding: 20px 0;
      margin-top: 30px;
    }
    
    .footer-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .footer-links a {
      color: white;
      text-decoration: none;
      margin-left: 20px;
      font-size: 0.9rem;
    }
    
    .footer-links a:hover {
      color: var(--accent-color);
    }
    
    .copyright {
      font-size: 0.85rem;
      opacity: 0.8;
    }
    
    /* Responsive Styles */
    @media (max-width: 768px) {
      .patient-info {
        justify-content: center;
        margin-bottom: 15px;
      }
      
      .nav-links {
        justify-content: center;
      }
      
      .nav-links a {
        margin: 0 10px;
      }
      
      .footer-content {
        flex-direction: column;
        text-align: center;
      }
      
      .footer-links {
        margin-top: 10px;
      }
      
      .footer-links a {
        margin: 0 10px;
      }
      
      .table-responsive {
        font-size: 0.85rem;
      }
    }
  </style>
</head>
<body>
  <!-- Header Section -->
  <header class="dashboard-header">
    <div class="container">
      <div class="header-content">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class="patient-info">
              <div class="patient-avatar">
                <i class="fas fa-user-md"></i>
              </div>
              <div class="patient-details">
                <h3>Dr. <?= $firstname ?></h3>
                <p>ID: <?= $id ?></p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="nav-links">
              <a href="#"><i class="fas fa-home"></i> Dashboard</a>
              <a href="#"><i class="fas fa-calendar-alt"></i> Appointments</a>
              <a href="#"><i class="fas fa-file-medical"></i> Medical Records</a>
              <a href="<?=base_url("admin/logout")?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
