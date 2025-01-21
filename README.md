# Order Management API

A Laravel-based API for managing orders and order items, including handling subscriptions via a third-party service.

## Prerequisites

- **Docker**: To run the containers.
- **Docker Compose**: To manage multi-container Docker applications.
- **Git**: To clone the repository.

---

## Setup Instructions

### 1. Clone the Repository

First, clone the repository to your local machine using `git`:

```bash
git clone https://github.com/yourusername/smindle-order-api.git
cd smindle-order-api
```

### 2. Docker Setup

To set up the application with Docker, make sure **Docker** and **Docker Compose** are installed. Then, run the following command to start both the Laravel application and MySQL containers:

```bash
docker-compose up -d
```

This will:
- Start the **Laravel application** in a container.
- Start the **MySQL** database in another container.

You can verify that both containers are running by using:

```bash
docker ps
```

### 3. Set Up Environment Variables

Ensure that the `.env` file in the project root contains the correct configuration for your application, especially for connecting to the MySQL database.

Your `.env` file should include:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=order_db
DB_USERNAME=root
DB_PASSWORD=secret
```

> If the `.env` file is missing, you can copy the `.env.example` file and rename it to `.env`.

### 4. Test the API

Once the application is running, you can send a `POST` request to the following endpoint:

```
http://localhost:8000/api/orders
```

**Request Body Example**:

```json
{
   "first_name": "John",
   "last_name": "Doe",
   "address": "123 Main St",
   "basket": [
       {
           "name": "Product A",
           "type": "unit",
           "price": 10.00
       },
       {
           "name": "Subscription B",
           "type": "subscription",
           "price": 20.00
       }
   ]
}
```

This will create a new order, including order items, and send asynchronous requests for subscription items to a third-party service.

### 6. Access the Application

You can access the Laravel application via the following URL:

```
http://localhost:8000
```

### 7. Stop the Containers

Once you're done testing, you can stop the running containers:

```bash
docker-compose down
```

This will stop and remove all containers but preserve your data.

---

## Additional Information

- **Database**: The MySQL database used is configured within the `docker-compose.yml` file with the name `order_db`, username `root`, and password `secret`.
- **Asynchronous HTTP Requests**: For subscription items, the app will send HTTP requests to a third-party API.
- **Docker**: The entire application, including the web server (Laravel) and database, runs in Docker containers, making it easy to deploy and test in different environments.
