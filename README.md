# Aegis - User Service API

This project is a Laravel application set up using Docker and Docker Compose. It includes a **User Service API** to handle user-related operations like user creation and fetching users.

## Requirements

Before getting started, make sure you have the following installed:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

---

## Getting Started

### 1. Clone the Repository

Clone the Laravel project repository:

```bash
git clone https://github.com/your-repository-name
cd your-project-folder
```

### 2. Build Docker Containers
Run the following command to build the Docker containers:
```bash
docker-compose build
```

### 3. Start the Development Environment
After building the containers, start them with the following command:
```bash
docker-compose up -d
```
This will start the Laravel app along with the necessary services like MySQL.

### 4. Run Migrations
Run database migrations to set up the schema:
```bash
docker-compose exec app php artisan migrate

```

### 5. Access the Application

```bash
http://localhost
```
## User Service API
These two APIs form the core of the User Service:
1. Create User API ensures you can add new users dynamically.
2. Get Users API allows you to retrieve and manage user data efficiently.
### 1. Create User API

The Create User API allows the application to add new users to the system. It accepts a JSON request body containing user details such as name, email, and password. Once the request is successfully processed, the user is saved in the database.

- Endpoint: /api/users
- Method: POST
- Request Body Example:
```bash
{
  "name": "John Doe",
  "email": "johndoe@example.com",
  "password": "password123"
}

```
### 2. Get Users API
The Get Users API provides a way to fetch a list of all registered users in the system. It returns the data in JSON format, including the user ID, name, and email.

- Endpoint: /api/users
- Method: GET
- Response Example:

```bash
[
  {
    "id": 1,
    "name": "John Doe",
    "email": "johndoe@example.com"
  },
  {
    "id": 2,
    "name": "Jane Doe",
    "email": "janedoe@example.com"
  }
]


```