# Car Service API Documentation

This section of the API allows authenticated users to manage `Car Services`. All routes require authentication.

## Authentication

All routes in this section require an `Authorization` header with a valid bearer token:

Authorization: Bearer {token}

## Base URL

/api/v1/car-services

---

## Get All Car Services

**Endpoint**: `GET /api/v1/car-services`

This route retrieves a list of all car services.

### Success Response

```json
{
    "message": "Car Services successfully retrieved",
    "data": {
        "car_services": [
            {
                "id": "365066f3-e7f8-447c-8039-1972ee11fd63",
                "name": "Brake Pad Replacement",
                "description": "Replace brake pads",
                "service_type": {
                    "id": "1951d4ac-6595-4514-9e86-c9825a97bf11",
                    "name": "Brake Service",
                    "description": "Brake system inspection"
                },
                "price": 8000
            }
        ]
    }
}
```

Error Responses

-   401 Unauthorized: When the user is not authenticated.

```json
{
    "error": "Unauthorized."
}
```

-   403 Forbidden: When the user doesn’t have the necessary permissions.

```json
{
    "error": "Forbidden: You do not have access to this resource."
}
```

## Get a Single Car Service

Endpoint: GET /api/v1/car-services/{car_service_id}

This route retrieves details of a single car service by its ID.

Success Response

```json
{
    "message": "Car Service successfully retrieved",
    "data": {
        "id": "365066f3-e7f8-447c-8039-1972ee11fd63",
        "name": "Brake Pad Replacement",
        "description": "Replace brake pads",
        "service_type": {
            "id": "1951d4ac-6595-4514-9e86-c9825a97bf11",
            "name": "Brake Service",
            "description": "Brake system inspection"
        },
        "price": 8000
    }
}
```

Error Responses

-   404 Not Found: When the car service does not exist.

```json
{
    "error": "Car Service not found."
}
```

-   401 Unauthorized: When the user is not authenticated.

```json
{
    "error": "Unauthorized."
}
```

## Create a New Car Service

Endpoint: POST /api/v1/car-services

This route creates a new car service.

Payload Example

```json
{
    "name": "Tire Rotation",
    "description": "Professional tire rotation service",
    "price": 7500,
    "service_type_id": "1951d4ac-6595-4514-9e86-c9825a97bf11"
}
```

Created Response (201)

```json
{
    "message": "Car Service created successfully!",
    "data": {
        "id": "1a2b3c4d-5678-90ab-cdef-1234567890ab",
        "name": "Tire Rotation",
        "description": "Professional tire rotation service",
        "service_type": {
            "id": "1951d4ac-6595-4514-9e86-c9825a97bf11",
            "name": "Tire Service",
            "description": "Tire-related services"
        },
        "price": 7500
    }
}
```

Error Responses

-   422 Validation Error: When the provided data is invalid.

```json
{
    "message": "Validation failed!",
    "errors": {
        "name": ["The name field is required."],
        "price": ["The price field must be a valid number."]
    }
}
```

## Update a Car Service

Endpoint: PUT /api/v1/car-services/{car_service_id}

This route updates an existing car service by its ID.

Payload Example

```json
{
    "name": "Battery Replacement",
    "description": "Efficient battery replacement service",
    "price": 12000
}
```

Success Response

```json
{
    "message": "Car Service updated successfully!",
    "data": {
        "id": "4e8a3c7a-96d6-4a47-bb48-8b8af434cfe2",
        "name": "Battery Replacement",
        "description": "Efficient battery replacement service",
        "service_type": {
            "id": "1951d4ac-6595-4514-9e86-c9825a97bf11",
            "name": "Electrical Service",
            "description": "Electrical system services"
        },
        "price": 12000
    }
}
```

Error Responses

-   404 Not Found: When the car service does not exist.

```json
{
    "error": "Car Service not found."
}
```

-   422 Validation Error: When the data is invalid.

```json
{
    "message": "Validation failed!",
    "errors": {
        "price": ["The price field must be a valid number."]
    }
}
```

## Delete a Car Service

Endpoint: DELETE /api/v1/car-services/{car_service_id}

This route deletes an existing car service by its ID.

Success Response

```json
{
    "message": "Resource deleted!",
    "data": true
}
```

Error Responses

-   404 Not Found: When the car service does not exist.

```json
{
    "error": "Car Service not found."
}
```
