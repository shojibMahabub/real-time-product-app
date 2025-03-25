# Real-Time Product Display with Laravel and Pusher

This is a Laravel-based application that uses **Pusher** for real-time updates. When products are updated or fetched, all connected clients automatically receive updates without needing to refresh the page.

## Table of Contents
1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Running the Application](#running-the-application)
5. [Pusher Integration](#pusher-integration)
6. [Testing Real-Time Updates](#testing-real-time-updates)

---

## Requirements
- **PHP 8.0+**
- **Composer**
- **Laravel 8.x+**
- **MySQL** (or compatible database)
- **Pusher Account** (for real-time broadcasting)

---

## Installation

Follow these steps to set up and run the application:

### 1. Clone the repository
Clone the repository to your local machine:
```bash
git clone https://github.com/shojibMahabub/real-time-product-app.git
cd real-time-product-app
```
### 2. Install dependencies
Run Composer to install all PHP dependencies:

```composer install```

### 3. Set up the environment
Copy the .env.example file to .env
```cp .env.example .env```

### 4. Configure environment variables
Edit the .env file to set up your database and Pusher credentials:

Database Configuration:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```
Pusher Configuration: Obtain your Pusher credentials from Pusher Dashboard and set them here:
```
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_app_key
PUSHER_APP_SECRET=your_pusher_app_secret
PUSHER_APP_CLUSTER=your_pusher_app_cluster
```
### 5. Generate application key
Run the following command to generate the application key:
```php artisan key:generate```
### 6. Run migrations
Run the database migrations to set up the schema:
```php artisan migrate```

### Configuration
#### Broadcasting

This application uses Laravel's broadcasting feature to send real-time updates to the client. Ensure your .env file is properly configured for Pusher as described above.

#### Queue Worker
The application uses queues to handle background tasks like broadcasting events. To process queued jobs (e.g., product update broadcasts), run the queue worker:
```php artisan queue:work```

>
> You can also automate the queue worker with Supervisor or Systemd for
> production environments.
>

#### Running the Application
After setting everything up, you can start the application by running the built-in Laravel development server:

```php artisan serve```


# Pusher Integration
Pusher is used to broadcast events when products are updated. Here's how it's integrated:

Broadcasting Events: When a product is updated, a ProductUpdated event is fired. This event is broadcasted on the product-channel to notify all connected clients that a product has been updated.

The broadcastOn method in the ProductEvent to ensures that the event is sent to the correct channel.

Listening for Events: Clients subscribe to the product-channel using Pusher. When the product-updated event is triggered, all subscribed clients will receive the update and reload the product list automatically.

The frontend code listens for this event using Pusher's JavaScript library and updates the UI accordingly.

# Testing Real-Time Updates
Start the application by running php artisan serve.
Open multiple tabs in your browser or different browsers.
Update a product by triggering the update from any tab.
Check the other tabs — the product list should update automatically without needing to refresh.