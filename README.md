# Student Information Management System

A web-based student management system for Northern University Bangladesh built with PHP, MySQL, and Bootstrap.

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- [XAMPP](https://www.apachefriends.org/download.html) or similar package (optional, but recommended for local development)

## Installation Steps

1. **Set up your web server**
   - If using XAMPP:
     - Install XAMPP
     - Start Apache and MySQL services from XAMPP Control Panel
     - Clone/Copy this project to `C:/xampp/htdocs/student_information_management`

2. **Create the database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `nub_student_management`
   - Click on the newly created database
   - Click "Import" tab
   - Choose the `database/schema.sql` file from the project
   - Click "Go" to import the database structure and initial data

3. **Configure the database connection**
   - Open `config/database.php`
   - Update the database credentials if needed:
     ```php
     private $host = "localhost";
     private $db_name = "nub_student_management";
     private $username = "root";  // Change if needed
     private $password = "";      // Change if needed
     ```

4. **Set folder permissions**
   - Ensure the web server has read/write permissions for the project directory
   - For XAMPP on Windows, this is usually handled automatically
   - For Linux/Mac:
     ```bash
     chmod -R 755 /path/to/student_information_management
     ```

## Running the Project

1. If using XAMPP:
   - Make sure Apache and MySQL services are running in XAMPP Control Panel
   - Open your browser and navigate to:
     ```
     http://localhost/student_information_management
     ```

2. If using another web server:
   - Configure your web server to point to the project directory
   - Access the URL based on your web server configuration

## Default Login Credentials

```
Admin User:
Email: admin@nub.ac.bd
Password: admin123
```

## Project Structure

```
student_information_management/
├── actions/
│   └── delete-student.php
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── main.js
├── config/
│   └── database.php
├── database/
│   └── schema.sql
├── includes/
│   ├── auth.php
│   ├── navbar.php
│   └── Student.php
├── pages/
│   ├── 404.php
│   ├── add-student.php
│   ├── dashboard.php
│   ├── edit-student.php
│   └── students.php
├── index.php
├── login.php
└── logout.php
```

## Features

### Core Features
- User authentication with role-based access
- Student CRUD operations
- Search and filter students
- Export student data to CSV
- Department-wise statistics
- Form validation
- Secure against SQL injection and XSS

### Modern UI/UX Features (Updated 2025)
- Modern glass-morphism design throughout the application
- Floating labels with optimized spacing in forms
- Interactive cards with hover effects and smooth transitions
- Advanced form organization with sectioned layouts
- Smart pagination with 5 records per page
- Elegant profile page with avatar and role badge
- Modern delete confirmation modal with animations
- Enhanced table design with hover states
- Dynamic search and filter interface
- Responsive design for all screen sizes
- Consistent color scheme and typography
- Improved visual feedback for user actions
- Modern alert messages with icons

## Security Notes

1. Change the default admin password after first login
2. Update database credentials in production
3. Ensure proper file permissions in production
4. Configure your web server securely
5. Keep PHP and all dependencies updated

## Troubleshooting

1. **Database Connection Error**
   - Verify MySQL is running
   - Check database credentials in `config/database.php`
   - Ensure database `nub_student_management` exists

2. **Page Not Found Error**
   - Verify the project is in the correct directory
   - Check web server configuration
   - Ensure mod_rewrite is enabled if using Apache

3. **Permission Issues**
   - Check folder permissions
   - Verify web server user has access to project files

4. **Login Issues**
   - Clear browser cookies
   - Verify database contains admin user
   - Check PHP session configuration

For additional help or bug reports, please contact the system administrator.
