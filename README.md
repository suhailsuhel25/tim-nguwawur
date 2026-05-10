# tim-nguwawur

## Project Overview
Simagang is a comprehensive internship management system designed to streamline the process of internship (PKL) monitoring for students, lecturers, and administrators. The system provides a unified platform for managing internship periods, company details, daily activities, mentorship sessions, and final assessments.

## Features

### 1. User Authentication & Role Management
- **Three Distinct Roles**: Mahasiswa (Student), Dosen (Lecturer), and Admin.
- **Secure Login**: Email/NIP/ID-based authentication with password security.
- **Role-Based Redirection**: Automatically redirects users to their specific dashboard after login.

### 2. Mahasiswa (Student) Module
- **Internship Application**: Apply for internships with detailed personal and academic information.
- **Document Management**: Upload and manage required internship documents (CV, Cover Letter, etc.).
- **Daily Activity Tracking**: Log daily activities with time tracking and status updates.
- **Mentorship**: Schedule and track mentorship sessions with lecturers.
- **Progress Monitoring**: View internship progress and receive notifications.

### 3. Dosen (Lecturer) Module
- **Mentorship Management**: Oversee and manage mentorship sessions for assigned students.
- **Activity Monitoring**: Review student daily activities and progress reports.
- **Notification System**: Receive real-time notifications regarding student activities and requests.
- **Assessment**: Provide final grades and assessments for internships.

### 4. Admin Module
- **System Configuration**: Manage internship periods and system settings.
- **User Management**: Oversee all student and lecturer accounts.
- **Company Management**: Add and manage partner companies.
- **Monitoring**: Comprehensive dashboard to monitor all internship activities across the institution.

## Tech Stack
- **Backend**: PHP, Laravel
- **Frontend**: HTML, JavaScript, Tailwind CSS
- **Database**: MySQL

## Getting Started

### Prerequisites
- PHP >= 8.0
- MySQL
- Composer
- Node.js & NPM (for frontend assets)

### Installation
1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd tim-nguwawur
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node.js dependencies:
   ```bash
   npm install
   ```

4. Configure the environment:
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Update the database credentials in `.env`:
     ```ini
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=simagang
     DB_USERNAME=root
     DB_PASSWORD=
     ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Run database migrations:
   ```bash
   php artisan migrate
   ```

7. Serve the application:
   ```bash
   php artisan serve
   ```
   The application will be accessible at `http://localhost:8000`.

## Usage
- **Login**: Access the login page at `http://localhost:8000/login`.
- **Dashboards**:
  - Student: `http://localhost:8000/mahasiswa/dashboard`
  - Lecturer: `http://localhost:8000/dosen/dashboard`
  - Admin: `http://localhost:8000/admin/dashboard`

## License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
