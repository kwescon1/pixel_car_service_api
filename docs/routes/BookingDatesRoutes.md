# Booking Dates API Documentation

This section of the API allows authenticated users to manage `Booking Dates`. All routes require authentication.

## Authentication

All routes in this section require an `Authorization` header with a valid bearer token:

Authorization: Bearer {token}

## Base URL

/api/v1/available-dates

---

## Get All Booking Dates

**Endpoint**: `GET /api/v1/available-dates`

This route retrieves a paginated list of all available dates.

### Success Response

```json
{
    "message": "Operation successful!",
    "data": {
        "dates": [
            {
                "id": "cefffa55-0843-47cf-a68c-8c474c7202e2",
                "available_date": "2024-12-16",
                "is_active": 1
            }
        ],
        "pagination": {
            "current_page": 1,
            "last_page": 1,
            "per_page": 10,
            "total": 1,
            "next_page_url": null,
            "prev_page_url": null
        },
        "meta": {
            "status": "success",
            "total_dates": 1,
            "created_at": "2024-10-17T20:32:08.000000Z",
            "updated_at": "2024-10-17T20:32:08.000000Z"
        },
        "links": {
            "self": "https://localhost:8894/api/v1/available-dates"
        }
    }
}
```

Error Responses

-   401 Unauthorized: When the user is not authenticated.

````json
{
    "error": "Unauthorized."
}
```json


- 403 Forbidden: When the user doesn’t have the necessary permissions.

```json
{
    "error": "Forbidden: You do not have access to this resource."
}
````

## Get a Single Booking Date

Endpoint: GET /api/v1/available-dates/{available_date_id}

This route retrieves details of a single available date by its ID.

```json
Success Response

{
    "message": "Operation successful!",
    "data": {
        "id": "cefffa55-0843-47cf-a68c-8c474c7202e2",
        "available_date": "2024-12-16",
        "is_active": 1
    }
}
```

Error Responses

-   404 Not Found: When the available date does not exist.

```json
{
    "error": "Available Date not found."
}
```

-   401 Unauthorized: When the user is not authenticated.

```json
{
    "error": "Unauthorized."
}
```

## Create a New Booking Date

Endpoint: POST /api/v1/available-dates

This route creates a new available date.

Payload Example

```json
{
    "available_date": "2024-12-20",
    "is_active": 1
}
```

Success Response

```json
{
    "message": "Available Date created successfully!",
    "data": {
        "id": "4c8a1e4a-2e9d-4e1a-b5d4-56ae19b8a5d6",
        "available_date": "2024-12-20",
        "is_active": 1
    }
}
```

Error Responses

-   422 Validation Error: When the provided data is invalid.

```json
{
    "message": "Validation failed!",
    "errors": {
        "available_date": ["The available_date field is required."]
    }
}
```

## Update an Booking Date

Endpoint: PUT /api/v1/available-dates/{available_date_id}

This route updates an existing available date by its ID.

Payload Example

```json
{
    "available_date": "2024-12-25",
    "is_active": 1
}
```

Success Response

```json
{
    "message": "Booking Date updated successfully!",
    "data": {
        "id": "cefffa55-0843-47cf-a68c-8c474c7202e2",
        "available_date": "2024-12-25",
        "is_active": 1
    }
}
```

Error Responses

-   404 Not Found: When the available date does not exist.

```json
{
    "error": "Booking Date not found."
}
```

-   422 Validation Error: When the provided data is invalid.

```json
{
    "message": "Validation failed!",
    "errors": {
        "available_date": ["The available_date must be a valid date."]
    }
}
```

## Delete an Booking Date

Endpoint: DELETE /api/v1/available-dates/{available_date_id}

This route deletes an existing available date by its ID.

Success Response

```json
{
    "message": "Resource deleted!",
    "data": true
}
```

Error Responses

-   404 Not Found: When the available date does not exist.

```json
{
    "error": "Booking Date not found."
}
```
