-- Database for Diabetes Management System
-- Optimized for XAMPP with simple setup

CREATE DATABASE IF NOT EXISTS diabetes_management;
USE diabetes_management;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    age INT,
    password VARCHAR(255) NOT NULL,
    location VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Consultations table
CREATE TABLE consultations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    doctor_name VARCHAR(100) NOT NULL,
    consultation_date DATETIME NOT NULL,
    notes TEXT,
    status ENUM('scheduled', 'completed', 'cancelled') DEFAULT 'scheduled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Hospital appointments table
CREATE TABLE hospital_appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    hospital_name VARCHAR(100) NOT NULL,
    appointment_date DATETIME NOT NULL,
    department VARCHAR(50),
    doctor_name VARCHAR(100),
    status ENUM('scheduled', 'completed', 'cancelled') DEFAULT 'scheduled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Test results table
CREATE TABLE test_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    test_type VARCHAR(50) NOT NULL,
    test_date DATE NOT NULL,
    glucose_level DECIMAL(5,2),
    hba1c_level DECIMAL(4,2),
    blood_pressure VARCHAR(20),
    weight DECIMAL(5,2),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Emergency contacts table
CREATE TABLE emergency_contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    contact_name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    relationship VARCHAR(50),
    is_primary BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert demo users with plain text passwords for easy testing
INSERT INTO users (username, full_name, phone, age, password, location) VALUES
('shaikha', 'شيخة', '0501234567', 28, '123456', 'الرياض'),
('ahmed123', 'Ahmed Al-Rashid', '0509876543', 35, 'password', 'Riyadh'),
('sara_ali', 'Sara Ali Johnson', '0507654321', 42, 'password', 'Jeddah'),
('john_doe', 'John Michael Doe', '0501112233', 38, 'password', 'Dammam'),
('mary_smith', 'Mary Elizabeth Smith', '0504445566', 45, 'password', 'Mecca');

-- Insert demo consultations
INSERT INTO consultations (user_id, doctor_name, consultation_date, notes, status) VALUES
(1, 'Dr. Emily Rodriguez', '2025-06-20 10:00:00', 'Regular diabetes checkup and medication review', 'scheduled'),
(1, 'Dr. Michael Chen', '2025-05-15 14:30:00', 'Discussed blood sugar management and diet plan', 'completed'),
(2, 'Dr. Sarah Wilson', '2025-06-25 09:15:00', 'Follow-up consultation for insulin adjustment', 'scheduled'),
(3, 'Dr. Ahmed Hassan', '2025-06-18 16:00:00', 'Initial diabetes consultation and assessment', 'scheduled');

-- Insert demo hospital appointments
INSERT INTO hospital_appointments (user_id, hospital_name, appointment_date, department, doctor_name, status) VALUES
(1, 'City General Hospital', '2025-06-22 08:30:00', 'Endocrinology', 'Dr. Lisa Park', 'scheduled'),
(1, 'Metro Medical Center', '2025-05-10 10:15:00', 'Cardiology', 'Dr. James Wilson', 'completed'),
(2, 'Royal Hospital', '2025-06-28 11:00:00', 'Ophthalmology', 'Dr. Maria Garcia', 'scheduled'),
(3, 'Central Medical Complex', '2025-06-30 14:45:00', 'Nephrology', 'Dr. Robert Brown', 'scheduled');

-- Insert demo test results
INSERT INTO test_results (user_id, test_type, test_date, glucose_level, hba1c_level, blood_pressure, weight) VALUES
(1, 'Fasting Blood Sugar', '2025-06-15', 140.0, 6.8, '130/85', 68.5),
(1, 'HbA1c', '2025-06-10', NULL, 7.2, NULL, NULL),
(1, 'Blood Pressure Check', '2025-06-12', NULL, NULL, '125/80', 68.2),
(2, 'Random Blood Sugar', '2025-06-14', 180.0, NULL, '140/90', 75.0),
(3, 'Fasting Blood Sugar', '2025-06-16', 95.0, 5.9, '120/75', 62.0);

-- Insert demo emergency contacts
INSERT INTO emergency_contacts (user_id, contact_name, phone_number, relationship, is_primary) VALUES
(1, 'محمد العلي', '0501111111', 'Spouse', TRUE),
(1, 'فاطمة أحمد', '0502222222', 'Sister', FALSE),
(2, 'Fatima Al-Rashid', '0503333333', 'Spouse', TRUE),
(2, 'Omar Al-Rashid', '0504444444', 'Son', FALSE),
(3, 'David Johnson', '0505555555', 'Spouse', TRUE);

