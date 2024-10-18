# Explanation of the Pixel Car Service API

## Overview

This project is the backend for a Car Service Booking System, developed as part of a technical test for Pixel. The system is built using Laravel as a headless API, where the frontend is completely separated and consumes the API through JSON responses. There is no HTML/CSS in this project.

The system includes the following core functionalities:

1. Car Services: CRUD operations for car services (e.g., Oil Change, Tyres, Suspension).
2. Service Types: CRUD operations for grouping car services (e.g., Full Service, Interim Service).
3. Mechanics: CRUD operations for mechanics (e.g., name, specialty, availability).
4. Booking Dates: CRUD operations for booking dates, enabling mechanics to be available for specific services.

The API also provides unauthenticated read access for users to:

-   Select a type of car service.
-   View services filtered by the selected type.
-   Select available dates for those services.
-   View available mechanics for a specific date.

## How I Solved It

Authentication & Authorization

-   Authenticated Routes: The system uses Laravel Sanctum for authentication. Authenticated users, such as admins, can manage (create, update, delete) car services, service types, mechanics, and booking dates.
-   Unauthenticated Routes: These routes allow the public to view services, service types, available dates, and mechanics without logging in. This helps users find services and mechanics before proceeding to any bookings.

## Route Structure

The routes are divided as per the requirement:

-   Authenticated Routes: These are protected by auth:sanctum and are available only to authorized users (admins). All CRUD operations are handled under the /v1 prefix.
-   Public Routes: These are unauthenticated and allow general users to interact with the system. These routes are available under the /v1/public prefix and provide read-only access to services, service types, available dates, and mechanics.

-   Admin Role: From my understanding of the system, only admins manage mechanics. Mechanics do not log in; instead, they are added, updated, or deleted by an admin. However, this can be extended in the future to allow mechanics to manage their availability.

## Email Queueing

To optimize performance, I leveraged Laravel’s queue system for email notifications. When a new mechanic is added, an email notification is dispatched asynchronously to the mechanic. This ensures that the system remains responsive by offloading email processing to the background, preventing any delays in the main API flow.

## Image Upload and Processing

For mechanics, the system allows for image uploads (e.g., profile pictures). I implemented Spatie’s Image Optimizer to optimize these images in the background. This process also uses Laravel’s queue system to handle the image optimization asynchronously.

## Design Decisions

1. Separation of Authenticated and Unauthenticated Routes: Based on the requirements, I ensured a clear separation between authenticated CRUD routes and unauthenticated read routes. This prevents unauthorized users from accessing sensitive operations.
2. Transactional Integrity: Database operations, such as adding or updating mechanics, are wrapped in database transactions to ensure data consistency. This prevents partial updates in case of failures during operations.
3. Email Notifications and Image Processing: To ensure responsiveness, both notifications and image processing are handled asynchronously through job queues. This prevents the API from being blocked by time-consuming tasks such as sending emails or processing images.

Database Structure

The system’s database includes the following models:

-   CarService: Stores details about individual services such as name, price, and description.
-   ServiceType: Groups car services into categories (e.g., Full Service, Interim Service).
-   Mechanic: Stores details about mechanics, including their name, contact information, specialty, and availability.
-   BookingDate: Manages available dates for bookings and associates mechanics to those dates.

-   Mechanic availability is stored in a pivot table (mechanic_availabilities), which links mechanics to booking dates, along with their available start and end times.

## Testing

I ensured that the system is well-tested by writing comprehensive feature tests for both authenticated and unauthenticated routes. Key test cases include:

-   Testing CRUD operations for services, service types, mechanics, and booking dates.
-   Verifying that the public routes return the correct data for unauthenticated users.
-   Ensuring that image uploads and optimizations are handled correctly for mechanics.

Future Considerations

1. Mechanic Login: Currently, mechanics do not have the ability to log in and manage their availability. In the future, this could be enhanced to allow mechanics to log in and control their schedules. This would decentralize the admin’s control and give mechanics more autonomy.
2. Caching for Performance: Introducing caching (e.g., Redis) for frequently accessed resources like service types, services, and mechanics would improve response times and reduce database load, especially for unauthenticated routes.
3. Advanced Search and Filtering: Adding advanced search filters to allow users to search for mechanics by specialty, years of experience, or location would significantly enhance the user experience.
4. Role-Based Access Control (RBAC): While the current system uses an isAdmin middleware for route protection, a more fine-grained RBAC system could be introduced in the future, allowing different user roles with specific permissions to interact with the system.
5. Rate Limiting and Throttling: To protect the API from abuse and excessive traffic, introducing rate-limiting policies on unauthenticated routes would be beneficial as the system grows.
6. API Versioning: Although the current version is structured under v1, future iterations could introduce versioning strategies to ensure backward compatibility while rolling out new features or breaking changes.
7. Third-Party Integrations: Integrating third-party services, such as payment gateways for booking payments or calendar services for mechanic scheduling, could make the system more robust and versatile.
