# Pixel Car Service Booking API

Welcome to the Pixel Car Service Booking API, the server-side component of the car service booking application. This backend is built with Laravel and provides RESTful APIs for managing car services, mechanics, and bookings. The backend is containerized using Docker, making it easy to set up and deploy alongside the separated frontend.

## Project Structure

```plaintext
carservice_api/
│
├── docker-files/
│   ├── nginx/
│   │   ├── certs/             # SSL certificates (to be generated locally)
│   │   └── ...
│   └── ...
├── docker-compose.yml         # Docker Compose file for orchestrating containers
├── app/                       # Laravel application files
├── docs/                      # Documentation for API routes and other functionalities
│   ├── authentication/        # Authentication-related route documentation
│   │   └── README.md          # Documentation for authentication-related routes
|   └── ...
├── .env.example               # Example environment configuration file
├── README.md                  # This README file
└── ...                        # Other related files
```

## Prerequisites

    •	Docker: Ensure Docker is installed on your machine. Install Docker
    •	Make: Install make to help manage commands for the API.

## Setting Up the API Backend

Step 1: SSL Certificate Setup

To secure communication between the frontend and backend, you need to generate SSL certificates. We use mkcert for this purpose.

    1.	Install mkcert (if not already installed):
    •	For macOS:

brew install mkcert
brew install nss # if you use Firefox

    •	For Linux and Windows, follow the instructions at mkcert’s repository.

    2.	Generate a Local Certificate:

mkcert -install
mkcert localhost 127.0.0.1 ::1

    3.	Place the Generated Files:
    •	Move the generated .pem and .key files to the ./car_service_api/docker-files/nginx/certs/ directory.
    4.	Ensure Correct File Naming:
    •	Ensure the file names match those specified in the Nginx configuration and Docker Compose file.

Example Nginx configuration:

server {
listen 443 ssl;
server_name localhost;
root /var/www/car_service_api/public;

    ssl_certificate /etc/nginx/certs/localhost.pem;
    ssl_certificate_key /etc/nginx/certs/localhost-key.pem;

}

Example Docker Compose file for SSL:

car_service_webserver:

volumes: - ./:/var/www/car_service_api - ./docker-files/nginx/certs/localhost.pem:/etc/nginx/certs/localhost.pem - ./docker-files/nginx/certs/localhost-key.pem:/etc/nginx/certs/localhost-key.pem

Step 2: Environment Variables

    1.	Copy the example .env file:

cp .env.example .env

    2.	Edit the .env file:
    •	Open the .env file and configure the database connection and other relevant settings:

DB_DATABASE=your_db_name
DB_USERNAME=your_username
DB_PASSWORD=your_password

Step 3: Set Up and Run the API

    1.	Build the Docker containers:

make setup

    2.	Start the containers:

make up

    3.	Install Laravel Dependencies:
    •	Enter the container and run Composer install:

make shell
composer install

    4.	Run Migrations:
    •	Inside the container, run migrations to set up the database:

php artisan migrate

    5.	Run Tests:

php artisan test

    6.	Stop the API:

make down

API Functionality

This API provides endpoints for managing car services, service types, mechanics, and bookings.

Below are the key features:

Authenticated Features (Admin-only CRUD)

    1.	Car Services
    •	Create, view, update, and delete car services (e.g., oil changes, tire rotations).
    2.	Service Types
    •	Group services into types like Full Service, Interim Service.
    3.	Mechanics
    •	Manage mechanics (e.g., name, availability).
    4.	Booking Dates
    •	Manage bookings made by users for services on specific dates.

Unauthenticated Features (Public)

    •	View Services: Users can view available services filtered by service type.
    •	Select Date for Service: Users can view available dates for services.
    •	View Mechanic Availability: Users can view mechanics available on selected dates.

API Routes

The API routes are organized as follows:

    •	Authenticated Routes (for Admins):
    •	CRUD routes for managing car services, service types, mechanics, and bookings.
    •	Unauthenticated Routes (for Public Users):
    •	Routes for viewing available services, mechanics, and making bookings.

Communication with the Frontend

The API communicates with the frontend through RESTful endpoints. Ensure that the frontend is configured to communicate with the backend at the appropriate URL (e.g., https://localhost:8894).

API Route Documentation

Detailed documentation of the API routes, including request formats and expected responses, can be found in the docs folder:

    •	Car Services: docs/services/README.md
    •	Service Types: docs/service-types/README.md
    •	Mechanics: docs/mechanics/README.md
    •	Bookings: docs/bookings/README.md

Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

License

This project is licensed under the MIT License. See the LICENSE file for details.

Contact

For inquiries, suggestions, or support, please contact us at support@pixelcarservice.com
