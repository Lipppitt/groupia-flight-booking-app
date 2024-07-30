# Groupia Flight Booking App

## Overview

The Groupia Flight Booking App is a comprehensive flight booking system that includes both backend and frontend components. This guide will help you set up and run both parts of the application.

## Prerequisites

- **PHP**: Required for the backend.
- **Composer**: For PHP package management.
- **Node.js** and **npm**: For the frontend.

## Setup Instructions

### 1. Clone the Repository

Start by cloning the repository to your local machine:

```bash
git clone 'https://github.com/Lipppitt/groupia-flight-booking-app'
```

### 2. Set Up the Backend

#### Navigate to the Backend Directory

```bash
cd backend
```

#### Install PHP Dependencies

```bash
composer install
```

#### Run Database Migrations

```bash
php artisan migrate
```

#### Update the `.env` File

Add the following lines to your `.env` file:

```env
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:5173
SANCTUM_STATEFUL_DOMAINS=localhost:8000,localhost:5173,localhost,localhost:8000,127.0.0.1:5173,127.0.0.1:8000
```

#### Generate Application Key

```bash
php artisan key:generate
```

#### Import Flight Data

Pull flight data from the API:

```bash
php artisan app:import-flight-data
```

### 3. Set Up the Frontend

#### Go Back to the Root Directory

```bash
cd ..
```

#### Navigate to the Frontend Directory

```bash
cd frontend
```

#### Install Node.js Dependencies

```bash
npm install
```

#### Update the `.env` File

Add the following lines to your `.env` file:

```env
VITE_BASE_URL=http://localhost:8000
VITE_API_URL=http://localhost:8000/api/v1/
```

#### Run the Development Server

Start the development server:

```bash
npm run dev
```

## Additional Notes

- Make sure that your backend server (e.g., PHP server) is running on `http://localhost:8000`.
- Ensure that your frontend server (e.g., Vite server) is running on `http://localhost:5173`.

## Troubleshooting

- **Backend Issues**: If you encounter problems with migrations or key generation, verify your database connection settings in the `.env` file.
- **Frontend Issues**: For problems with the frontend, confirm that the development server is running and that your `.env` configuration matches the backend settings.

## Contributing

Contributions are welcome! If you have suggestions, bug reports, or improvements, please open an issue or submit a pull request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
