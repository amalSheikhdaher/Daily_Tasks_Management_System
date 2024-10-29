# Daily Tasks Management System

## Overview

A simple task management system built with Laravel, Blade, and Cron Jobs. This system allows users to add, edit, and delete tasks, view their daily tasks, and automatically receive a daily email reminder of pending tasks.

## Features

- **User Authentication** - Only authenticated users can access the task management features.
- **Task Management** - Users can add, edit, delete, and mark tasks as completed or pending.
- **Automated Daily Email Reminder** - A Cron Job sends a daily email to users with a list of their pending tasks.
- **Error Handling and Logging** - Error handling with logging for email failures.
- **Caching for Improved Performance** - Frequently accessed tasks are cached.


## Installation and Setup

### Prerequisites

- PHP 8.0 or higher
- Composer
- Laravel 10
- MySQL or any supported database


### Steps

1. **Clone the Repository:**
```
git clone https://github.com/amalSheikhdaher/Daily_Tasks_Management_System.git
```

2. **Install Dependencies:**
```
composer install
npm install && npm run dev
```

3. **Set up the environment:**

   Copy the `.env.example` file and configure the database settings and other environment variables.
```
cp .env.example .env
php artisan key:generate
```

    Update database credentials and email configuration in the .env file.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mail_username
MAIL_PASSWORD=your_mail_password
```

4. **Run Migrations Run migrations to create the necessary tables.**

```
 php artisan migrate
```

5. **Seed the database:**


```
php artisan db:seed
```

6. **Set up Database (For Queue):** 
    Ensure Database is installed and running on your system. Then configure Database in your `.env`:

```
QUEUE_CONNECTION=database
```

7. **Run Queues (For Performance Reports):** 
    Use the Laravel queue worker to handle background jobs:

```
php artisan queue:work
```

8. **Serve the application:**

```
php artisan serve
```

Your application will be accessible at `http://localhost:8000`.

## Usage

### Task Management

1. **User Authentication:**
    - Register or log in to the application.

2. **Manage Tasks:**
    - Access the task list, add new tasks, edit, delete, and change task statuses between "Pending" and "Completed".

### Steps to Run and Test the Automated Daily Email Command

1. **Setup Email Configuration:**

    Update your `.env` file with email configuration details. Your configuration should look like this:

    ```
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_USERNAME=your_gmail_address@gmail.com
    MAIL_PASSWORD=your_generated_app_password
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="your_gmail_address@gmail.com"
    MAIL_FROM_NAME="Daily Tasks"
    ```

    > **Note**: Make sure to enable "less secure app access" or generate an "App Password" in your Gmail settings if using 2-Step Verification.


2. **Schedule the Command**:

    For local testing, you can run the `SendPendingTasksEmail` command manually to check if the emails are being sent.

    1. **Run the Command Directly**:

        ```
        php artisan app:send-pending-tasks-email
        ```

        This command will trigger the `SendPendingTasksEmailJob` for each user with pending tasks.
    
    2. **Check the Email**: After running the command, check the inbox of the email specified in the `MAIL_USERNAME` to confirm that emails are sent successfully.

3. **Set Up Automated Scheduling in `Kernel.php`**

    - The command `app:send-pending-tasks-email` is scheduled in the `Kernel.php` file to run daily at 8:00 AM.
    - The schedule configuration in `Kernel.php`:

    ```
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:send-pending-tasks-email')->dailyAt('08:00');
    }
    ```

4. **Run the Scheduler Locally (Testing Purposes):**

    - To test the Cron Job locally, run:

    ```
    php artisan schedule:work
    ```

    - This will execute scheduled tasks in real-time as configured.

## Caching and Error Handling

- **Caching**: Implement caching for frequently accessed tasks to improve performance.
- **Error Handling**: Log errors if the email fails to send in the SendPendingTasksEmailJob job.

## License

This project is open-sourced under the [MIT License](LICENSE).
