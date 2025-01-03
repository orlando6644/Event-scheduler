# Event Manager Application

## Description

This application is a **Laravel and Vue.js 3-based Event Manager System** designed to streamline the creation, updating, and management of events. It provides users with real-time updates, notifications, and a dynamic user interface to ensure a seamless experience. 

Key features include:  
- **Event Management**: Create, update, and delete events with ease.  
- **Real-Time Notifications**: Notify users instantly about event updates or new events via WebSockets (powered by Pusher).  
- **Sorting and Pagination**: Efficiently sort and paginate event lists for better navigation and user experience.  
- **Custom Notifications**: Extendable notification system to send SMS, emails, or any other type of notifications.  

This application leverages the power of Laravel for backend operations and Vue.js 3 for frontend interactivity, ensuring a modern, responsive, and scalable solution for event management.

---

## Requirements

- PHP >= 8.0
- Laravel >= 10.0
- Composer
- Node.js & npm
- PostgreSQL
- Pusher Account (for real-time notifications)

---

## Installation

### Clone the Repository

```bash
git clone https://github.com/your-repo/Event-scheduler.git
cd event-scheduler
 ```
### Install Dependencies

```bash
composer install
npm install
 ```

### Environment Configuration
-Copy the .env.example file and rename it to .env.
```bash
cp .env.example .env
 ```

Set the following keys in your .env file:
```bash
APP_NAME="Event Manager"
APP_URL=http://localhost
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_app_key
PUSHER_APP_SECRET=your_pusher_app_secret
PUSHER_APP_CLUSTER=your_pusher_app_cluster
 ```
### Generate the application key:
```bash
php artisan key:generate
 ```

### Database Setup
-Run the following commands to migrate and seed the database:
```bash
php artisan migrate
php artisan db:seed --class=UserSeeder
 ```

### Initial Test User

To help you explore and test the application, a default user has been created with the following credentials:

- **Email**: `test1@test.com`  
- **Password**: `password`  

### Real-Time Features
- Pusher Integration: Ensure you have a valid Pusher account and credentials configured in .env.
- Event Broadcasting: Laravel events such as EventCreated and EventUpdated are used to broadcast updates.

### Contributing
Feel free to fork the repository and submit pull requests. For major changes, open an issue to discuss your idea first.
