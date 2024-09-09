# Library Management System

## Setup Instructions

### 1. Clone the Repository

### 2.Install Dependencies

# composer install

# npm install

### 3. Environment Setup

# Copy the .env.example file to .env

# Create a database named library

### 4. Configure Environment Variables

# Open the .env file and add your mail credentials to the mail configuration section

### 5. Run Migrations and Seed Database

# php artisan migrate

# php artisan db:seed

### 6. Start the Application

# Open three terminal windows and run the following commands in each window:

1. php artisan serve
2. php artisan queue:listen
3. npm run dev

### 7. API Documentation

# API documentation is provided in the Library.postman_collection.json file. You can import this file into Postman to view the available API requests and their responses. Note that only admin users have permission to access certain requests.

### Project Versions

# PHP: 8.2.12

# Laravel Framework: 10.48.20

# NPM: 10.8.2

# Node.js: 20.17.0
