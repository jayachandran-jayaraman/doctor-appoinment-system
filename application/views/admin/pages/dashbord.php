<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
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
    
    .admin-info {
      display: flex;
      align-items: center;
    }
    
    .admin-avatar {
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
    
    .admin-details h3 {
      margin: 0;
      font-weight: 600;
    }
    
    .admin-details p {
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
    
    .btn-container {
      display: flex;
      gap: 15px;
      justify-content: center;
      margin-bottom: 2rem;
    }
    
    .dashboard-btn {
      background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
      border: none;
      color: white;
      padding: 12px 30px;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
      text-decoration: none;
      display: inline-block;
    }
    
    .dashboard-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
      color: white;
    }
    
    .dashboard-btn-outline {
      border: 2px solid var(--primary-color);
      color: var(--primary-color);
      background: transparent;
      padding: 10px 28px;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-block;
    }
    
    .dashboard-btn-outline:hover {
      background: var(--primary-color);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
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
    
    .table-container {
      background: white;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      overflow: hidden;
      margin-bottom: 2rem;
    }
    
    .section-title {
      color: var(--secondary-color);
      font-weight: 700;
      margin-bottom: 1.5rem;
      text-align: center;
      font-size: 1.5rem;
      padding-top: 20px;
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
      .admin-info {
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
      
      .btn-container {
        flex-direction: column;
        align-items: center;
      }
      
      .dashboard-btn, .dashboard-btn-outline {
        width: 200px;
        text-align: center;
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
            <div class="admin-info">
              <div class="admin-avatar">
                <i class="fas fa-user-shield"></i>
              </div>
              <div class="admin-details">
                <h3>Admin Dashboard</h3>
                <p>Manage your healthcare system efficiently</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="nav-links">
              <a href="#"><i class="fas fa-home"></i> Dashboard</a>
              <a href="#"><i class="fas fa-cog"></i> Settings</a>
              <a href="<?=base_url("admin/logout")?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="main-content">
    <div class="container">
      <!-- Three Dashboard Buttons -->
      <div class="btn-container">
        <a href="<?= base_url('Admincontriller/merged_doctor_view_signup') ?>" class="dashboard-btn">View Patients</a>
        <a href="<?= base_url('Admincontriller/showDoctors') ?>" class="dashboard-btn-outline">View Doctors</a>
        <a href="<?= base_url('Admincontriller/merged_doctor_view_doc_db') ?>" class="dashboard-btn-outline">View Status</a>
      </div>

      <!-- Patients Table -->
      <?php if (!empty($signups)) { ?>
        <div class="table-container">
          <div class="section-title">Patients Information</div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($signups as $signup): ?>
              <tr>
                <td><?= $signup->id ?></td>
                <td><?= htmlspecialchars($signup->firstname) ?></td>
                <td><?= htmlspecialchars($signup->email) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php } ?>

      <!-- Doctors Table -->
      <?php if (!empty($doctors)) { ?>
        <div class="table-container">
          <div class="section-title">Doctors Information</div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Role</th>
                <th>Specialist</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($doctors as $doc): ?>
              <tr>
                <td><?= $doc['id'] ?></td>
                <td><?= htmlspecialchars($doc['firstname']) ?></td>
                <td><?= htmlspecialchars($doc['phone']) ?></td>
                <td><?= htmlspecialchars($doc['email']) ?></td>
                <td><?= htmlspecialchars($doc['role']) ?></td>
                <td><?= htmlspecialchars($doc['specialist']) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php } ?>

      <!-- Status Table -->
      <?php if (!empty($patients)) { ?>
        <div class="table-container">
          <div class="section-title">Appointment Status</div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Doctor Name</th>
                <th>Patient ID</th>
                <th>Reason For Visit</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($patients as $doc): ?>
              <tr>
                <td><?= $doc->id ?></td>
                <td><?= htmlspecialchars($doc->doctor) ?></td>
                <td><?= htmlspecialchars($doc->User_id) ?></td>
                <td><?= htmlspecialchars($doc->reason) ?></td>
                <td>
                  <span class="status-badge 
                    <?= $doc->status == 'confirmed' ? 'status-confirmed' : 
                       ($doc->status == 'pending' ? 'status-pending' : 
                       ($doc->status == 'cancelled' ? 'status-cancelled' : 'status-pending')) ?>">
                    <?= htmlspecialchars($doc->status) ?>
                  </span>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php } ?>
    </div>
  </div>

  <!-- Footer Section -->
  <footer class="dashboard-footer">
    <div class="container">
      <div class="footer-content">
        <div class="copyright">
          &copy; 2024 Healthcare Management System. All rights reserved.
        </div>
        <div class="footer-links">
          <a href="#">Privacy Policy</a>
          <a href="#">Terms of Service</a>
          <a href="#">Contact Support</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>