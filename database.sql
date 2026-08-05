-- Doctor-Patient Appointment System Database Schema
-- Run: mysql -u your_user -p doctorpatient < database.sql

CREATE DATABASE IF NOT EXISTS doctorpatient;
USE doctorpatient;

CREATE TABLE IF NOT EXISTS signup (
  id INT AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  phone VARCHAR(50) DEFAULT NULL,
  password VARCHAR(255) NOT NULL,
  role INT DEFAULT 3,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS doctor (
  id INT AUTO_INCREMENT PRIMARY KEY,
  firstname VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  phone VARCHAR(50) DEFAULT NULL,
  role INT NOT NULL COMMENT '1=Admin, 2=Doctor',
  specialist VARCHAR(255) DEFAULT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS doc_db (
  id INT AUTO_INCREMENT PRIMARY KEY,
  doctor INT NOT NULL,
  user_id INT NOT NULL,
  date DATE NOT NULL,
  time TIME NOT NULL,
  reason TEXT,
  status VARCHAR(10) DEFAULT '0' COMMENT '0=Pending, 1=Confirmed, 2=Cancelled, 3=Rescheduled',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (doctor) REFERENCES doctor(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES signup(id) ON DELETE CASCADE
);

-- Sample admin account (password: admin123)
INSERT INTO doctor (firstname, email, phone, role, specialist, password)
VALUES ('System Admin', 'admin@medcare.com', '9876543210', 1, 'Administration', 'admin123')
ON DUPLICATE KEY UPDATE firstname = firstname;

-- Sample doctor account (password: doctor123)
INSERT INTO doctor (firstname, email, phone, role, specialist, password)
VALUES ('Sarah Johnson', 'doctor@medcare.com', '9876543211', 2, 'Cardiologist', 'doctor123')
ON DUPLICATE KEY UPDATE firstname = firstname;

-- Sample patient account (password: patient123)
INSERT INTO signup (firstname, email, phone, password, role)
VALUES ('John Smith', 'patient@medcare.com', '9876543212', 'patient123', 3)
ON DUPLICATE KEY UPDATE firstname = firstname;
