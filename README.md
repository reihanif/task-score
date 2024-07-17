# Taskscore

This is a Laravel project integrated with Vite for the frontend asset bundling. This setup provides a modern and fast development experience with Hot Module Replacement (HMR) for frontend assets.

This application is designed to simplify the process of assignment, management, and tracking of tasks for department members. By utilizing this application, supervisors can accurately evaluate the contributions of each team member. This will enhance efficiency in performance management, ensure fairer and more objective assessments, and provide a solid foundation for decision-making related to employee development and resource allocation. As a result, overall team productivity can be increased, and a more transparent and collaborative work environment can be created.

## Table of Contents
- Requirements
- Installation
- Usage Development
- Build

## Requirements

- PHP ^8.2.17
- Composer
- Node.js ^20.11.1
- NPM
- MySQL

## Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/reihanif/task-score.git
   ```

2. **Open the directory**
   ```bash
   cd task-score
   ```

3. **Install PHP dependencies**

   ```bash
   composer install
   ```

4. **Install Node.js dependencies**

   ```bash
   npm install
   ```

5. **Set up the environment variables**
   
   Copy the .env.example file to .env and adjust the settings as needed.
   ```bash
   cp .env.example .env
   ```

6. **Generate an application key**

   ```bash
   php artisan key:generate
   ```

7. **Run the database migrations with seeder**

   ```bash
   php artisan migrate --seed
   ```

## Usage Development

To start the development server 

```bash
npm run dev
```

In another terminal, run the Laravel server:
```bash
php artisan serve
```

## Build
To build the assets for production:
```bash
npm run build
```
