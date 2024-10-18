# Guest Routes API Documentation

This section of the API provides public access to certain resources without requiring authentication.

## Base URL

All guest routes are prefixed with `/api/v1/public`.

---

## Get All Service Types (Public Access)

**Endpoint**: `GET /api/v1/public/service-types`

This route retrieves a list of all service types available for public access.

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

## Get Car Services by Service Type (Public Access)

Endpoint: GET /api/v1/public/car-services?type={service_type}

This route retrieves a list of car services based on the selected service type. The type query parameter can be either the UUID or name of the service type.

Success Response

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

## Get Available Dates (Public Access)

Endpoint: GET /api/v1/public/available-dates

This route retrieves a list of available booking dates.

Success Response

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
        }
    }
}
```

## Get Available Mechanics for a Date (Public Access)

Endpoint: GET /api/v1/public/mechanics?date={booking_date}

This route retrieves a list of available mechanics for a given booking date. The date query parameter should be a valid date.

Success Response

```json
{
    "message": "Mechanics successfully retrieved",
    "data": {
        "mechanics": [
            {
                "id": "ebd101f3-fa2b-4517-90cc-23ccd09b84cc",
                "name": "Kwesi",
                "email": "kwescon1@gmail.com",
                "phone_number": "0243938336",
                "years_of_experience": "4",
                "specialty": null,
                "is_available": true
            }
        ]
    }
}
```
