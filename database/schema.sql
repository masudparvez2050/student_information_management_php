-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'faculty') NOT NULL DEFAULT 'faculty',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create students table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    department VARCHAR(50) NOT NULL,
    enrollment_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123)
INSERT INTO users (email, password, role) VALUES
('admin@nub.ac.bd', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert some sample departments in students table
INSERT INTO students (student_id, name, email, phone, department, enrollment_date) VALUES
('42220300255', 'MD. Suruj Ali', 'md.surujali@gmail.com', '01700000055', 'Computer Science', '2025-01-15'),
('42220300260', 'Saidur Rahman', 'saidur.rahman@gmail.com', '01700000060', 'Computer Science', '2025-01-15'),
('42220300254', 'Afifa Ayat Falguni', 'afifa.ayat@gmail.com', '01700000054', 'Computer Science', '2025-01-15'),
('42220300258', 'Lamia Akter', 'lamia.akter@gmail.com', '01700000058', 'Computer Science', '2025-01-15'),
('42220300253', 'MD. Abdul Aoual', 'md.abdulaoual@gmail.com', '01700000053', 'Computer Science', '2025-01-15'),
('42220300264', 'Md Helal Khan', 'md.helalkhan@gmail.com', '01700000064', 'Computer Science', '2025-01-15'),
('42220300262', 'Jannatun Naim', 'jannatun.naim@gmail.com', '01700000062', 'Computer Science', '2025-01-15'),
('42220300257', 'Md. Samiul Hosen', 'md.samiulhosen@gmail.com', '01700000057', 'Computer Science', '2025-01-15'),
('42220300226', 'Md. Taslim Uddin', 'md.taslim@gmail.com', '01700000026', 'Computer Science', '2025-01-15'),
('42220300227', 'Md. Asif', 'md.asif@gmail.com', '01700000027', 'Computer Science', '2025-01-15'),
('42220300291', 'Md. Mashiur Rahman', 'md.mashiur@gmail.com', '01700000091', 'Business Administration', '2025-01-15'),
('42220300273', 'MD.Abu Salman', 'md.abusalman@gmail.com', '01700000073', 'Business Administration', '2025-01-15'),
('42220300244', 'Toukir Ahammed', 'toukir.ahammed@gmail.com', '01700000044', 'Business Administration', '2025-01-15'),
('42220300292', 'Md Mahmudul Hossain', 'md.mahmudul@gmail.com', '01700000092', 'Business Administration', '2025-01-15'),
('42220300282', 'Hasanuzzaman Akash', 'hasanuzzaman.akash@gmail.com', '01700000082', 'Business Administration', '2025-01-15'),
('42220300272', 'Gias Uddin', 'gias.uddin@gmail.com', '01700000072', 'Business Administration', '2025-01-15'),
('42220300287', 'Shakil khan', 'shakil.khan@gmail.com', '01700000087', 'Business Administration', '2025-01-15'),
('42220300344', 'Tayeba Shikder', 'tayeba.shikder@gmail.com', '01700000344', 'Business Administration', '2025-01-15'),
('42220300278', 'Nazmin Akhter', 'nazmin.akhter@gmail.com', '01700000078', 'Business Administration', '2025-01-15'),
('42220300208', 'Bristi Halder', 'bristi.halder@gmail.com', '01700000008', 'Business Administration', '2025-01-15'),
('42220300245', 'Md. Jannati Nayem', 'md.jannati@gmail.com', '01700000045', 'Electrical Engineering', '2025-01-15'),
('42220300246', 'Md. Tofajjal Hossen', 'md.tofajjal@gmail.com', '01700000046', 'Electrical Engineering', '2025-01-15'),
('42220300247', 'Md. Al-Amin', 'md.alamin@gmail.com', '01700000047', 'Electrical Engineering', '2025-01-15'),
('42220200171', 'Shahadat Hossain Shadheen', 'shahadat.shadheen@gmail.com', '01700000171', 'Electrical Engineering', '2025-01-15'),
('42220300241', 'Shopon Mia', 'shopon.mia@gmail.com', '01700000041', 'Electrical Engineering', '2025-01-15'),
('42220300261', 'Tahomin Rahoman', 'tahomin.rahoman@gmail.com', '01700000061', 'Electrical Engineering', '2025-01-15'),
('42220300263', 'Siam Munshei', 'siam.munshei@gmail.com', '01700000063', 'Electrical Engineering', '2025-01-15'),
('42220300250', 'Subrato Shil', 'subrato.shil@gmail.com', '01700000050', 'Electrical Engineering', '2025-01-15'),
('42220300242', 'Md. Jahid', 'md.jahid@gmail.com', '01700000042', 'Electrical Engineering', '2025-01-15'),
('42220300271', 'Israil Hossen', 'israil.hossen@gmail.com', '01700000071', 'Electrical Engineering', '2025-01-15'),
('42220300238', 'Pavel Mia', 'pavel.mia@gmail.com', '01700000038', 'Civil Engineering', '2025-01-15'),
('42220300234', 'Nazmul Islam', 'nazmul.islam@gmail.com', '01700000034', 'Civil Engineering', '2025-01-15'),
('42220300231', 'Shanto', 'shanto@gmail.com', '01700000031', 'Civil Engineering', '2025-01-15'),
('42220200235', 'Al-amin Islam', 'alamin.islam@gmail.com', '01700000235', 'Civil Engineering', '2025-01-15'),
('42220300236', 'Arup Das', 'arup.das@gmail.com', '01700000036', 'Civil Engineering', '2025-01-15'),
('42220300225', 'Md. Mirazul Alam', 'md.mirazul@gmail.com', '01700000025', 'Civil Engineering', '2025-01-15'),
('42220300298', 'Ar Rafi', 'ar.rafi@gmail.com', '01700000098', 'Civil Engineering', '2025-01-15'),
('42220300301', 'Md Abdullah Buhayia', 'md.abdullahbuhayia@gmail.com', '01700000301', 'Civil Engineering', '2025-01-15'),
('42220300297', 'Md. Abdullah', 'md.abdullah@gmail.com', '01700000097', 'Civil Engineering', '2025-01-15'),
('42220300323', 'Md. Kamrul Hasan', 'md.kamrulhasan@gmail.com', '01700000323', 'Civil Engineering', '2025-01-15'),
('42220300270', 'Md.Mehedi Hasan', 'md.mehedihasan@gmail.com', '01700000070', 'Civil Engineering', '2025-01-15'),
('42220300281', 'Imaz Anik', 'imaz.anik@gmail.com', '01700000081', 'Law', '2025-01-15'),
('42220300240', 'Pibir Chakma', 'pibir.chakma@gmail.com', '01700000040', 'Law', '2025-01-15'),
('42220300252', 'Md.Shofiuzzaman', 'md.shofiuzzaman@gmail.com', '01700000052', 'Law', '2025-01-15'),
('42220300230', 'Md. Sayedur Rahman', 'md.sayedur@gmail.com', '01700000030', 'Law', '2025-01-15'),
('42220300299', 'Monirul Islam', 'monirul.islam@gmail.com', '01700000299', 'Law', '2025-01-15'),
('42220300239', 'Md. Sajjad Hosasain', 'md.sajjadhosasain@gmail.com', '01700000039', 'Law', '2025-01-15');
