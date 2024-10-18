# Mechanics API Documentation

This section of the API allows authenticated users to manage `Mechanics`. All routes require authentication.

## Authentication

All routes in this section require an `Authorization` header with a valid bearer token:

Authorization: Bearer {token}

## Base URL

/api/v1/mechanics

---

## Get All Mechanics

**Endpoint**: `GET /api/v1/mechanics`

This route retrieves a list of all mechanics.

### Success Response

```json
{
    "message": "Mechanics successfully retrieved",
    "data": {
        "mechanics": [
            {
                "id": "ebd101f3-fa2b-4517-90cc-23ccd09b84cc",
                "name": "Kwesi",
                "email": "kwescon1@gmail.comfff",
                "phone_number": "0243938336",
                "years_of_experience": "4",
                "specialty": null,
                "avatar": null,
                "is_active": null
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

## Get a Single Mechanic

Endpoint: GET /api/v1/mechanics/{mechanic_id}

This route retrieves details of a single mechanic by its ID.

Success Response

```json
{
    "message": "Mechanic successfully retrieved",
    "data": {
        "id": "ebd101f3-fa2b-4517-90cc-23ccd09b84cc",
        "name": "Kwesi",
        "email": "kwescon1@gmail.comfff",
        "phone_number": "0243938336",
        "years_of_experience": "4",
        "specialty": null,
        "avatar": null,
        "is_active": null
    }
}
```

Error Responses

-   404 Not Found: When the mechanic does not exist.

```json
{
    "error": "Mechanic not found."
}
```

-   401 Unauthorized: When the user is not authenticated.

```json
{
    "error": "Unauthorized."
}
```

## Create a New Mechanic

Endpoint: POST /api/v1/mechanics

This route creates a new mechanic.

Payload Example

```json
{
    "name": "Kwesi",
    "email": "kwescon1@gmail.com",
    "phone_number": "0243938336",
    "years_of_experience": 4,
    "specialty": null,
    "avatar": null,
    "is_active": 1
}
```

Success Response (201 Created)

```json
{
    "message": "Resource created!",
    "data": {
        "id": "ebd101f3-fa2b-4517-90cc-23ccd09b84cc",
        "name": "Kwesi",
        "email": "kwescon1@gmail.com",
        "phone_number": "0243938336",
        "years_of_experience": "4",
        "specialty": null,
        "avatar": null,
        "is_active": 1
    }
}
```

Error Responses

-   422 Validation Error: When the provided data is invalid.

````json
{
    "message": "Validation failed!",
    "errors": {
        "email": [
            "The email has already been taken."
        ]
    }
}



## Update a Mechanic

Endpoint: PUT /api/v1/mechanics/{mechanic_id}

This route updates an existing mechanic by its ID.

Payload Example
```json
{
    "name": "Kwesi",
    "email": "kwesi.updated@gmail.com",
    "phone_number": "0243938336",
    "years_of_experience": 5,
    "specialty": "Brake Specialist",
    "avatar": null,
    "is_active": 1
}
````

Success Response

```json
{
    "message": "Mechanic updated successfully!",
    "data": {
        "id": "ebd101f3-fa2b-4517-90cc-23ccd09b84cc",
        "name": "Kwesi",
        "email": "kwesi.updated@gmail.com",
        "phone_number": "0243938336",
        "years_of_experience": "5",
        "specialty": "Brake Specialist",
        "avatar": null,
        "is_active": 1
    }
}
```

Error Responses

-   404 Not Found: When the mechanic does not exist.

```json
{
    "error": "Mechanic not found."
}
```

-   422 Validation Error: When the provided data is invalid.

```json
{
    "message": "Validation failed!",
    "errors": {
        "email": ["The email must be a valid email address."]
    }
}
```

## Delete a Mechanic

Endpoint: DELETE /api/v1/mechanics/{mechanic_id}

This route deletes an existing mechanic by its ID.

Success Response

```json
{
    "message": "Resource deleted!",
    "data": true
}
```

Error Responses

-   404 Not Found: When the mechanic does not exist.

```json
{
    "error": "Mechanic not found."
}
```
