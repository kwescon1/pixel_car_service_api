# Service Type API Documentation

This section of the API allows authenticated users to manage `Service Types`. All routes require authentication.

## Authentication

All routes in this section require an `Authorization` header with a valid bearer token:

Authorization: Bearer {token}

## Base URL

/api/v1/service-types

---

## Get All Service Types

**Endpoint**: `GET /api/v1/service-types`

This route retrieves a list of all service types.

### Success Response

```json
{
    "message": "Service Types successfully retrieved",
    "data": {
        "types": [
            {
                "id": "35ea8cbf-8141-457a-8552-954c4d47517e",
                "name": "Pixeltestpasswords updated",
                "description": "admin@pixeltest.com"
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

## Get a Single Service Type

Endpoint: GET /api/v1/service-types/{service_type_id}

This route retrieves details of a single service type by its ID.

Success Response

```json
{
    "message": "Service Type successfully retrieved",
    "data": {
        "id": "35ea8cbf-8141-457a-8552-954c4d47517e",
        "name": "Pixeltestpasswords updated",
        "description": "admin@pixeltest.com"
    }
}
```

Error Responses

-   404 Not Found: When the service type does not exist.

```json
{
    "error": "Service Type not found."
}
```

-   401 Unauthorized: When the user is not authenticated.

```json
{
    "error": "Unauthorized."
}
```

## Update a Service Type

Endpoint: PUT /api/v1/service-types/{service_type_id}

This route updates an existing service type by its ID.

Payload Example

```json
{
    "name": "Battery354",
    "description": "admin@pixeltest.com"
}
```

Success Response

```json
{
    "message": "Operation successful!",
    "data": {
        "id": "35ea8cbf-8141-457a-8552-954c4d47517e",
        "name": "Battery354",
        "description": "admin@pixeltest.com"
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
        "description": ["The description field must be a valid email."]
    }
}
```

-   404 Not Found: When the service type does not exist.

```json
{
    "error": "Service Type not found."
}
```

## Delete a Service Type

Endpoint: DELETE /api/v1/service-types/{service_type_id}

This route deletes an existing service type by its ID.

Success Response

```json
{
    "message": "Resource deleted!",
    "data": true
}
```

Error Responses

-   404 Not Found: When the service type does not exist.

```json
{
    "error": "Service Type not found."
}
```

-   401 Unauthorized: When the user is not authenticated.

```json
{
    "error": "Unauthorized."
}
```

## Notes

-   All responses include a message to indicate the success of the operation.
-   All routes require a valid bearer token for authentication.
