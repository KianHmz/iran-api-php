# Iran API
Offers the list of provinces and cities of Iran (in Farsi).

### Built with
![PHP](https://img.shields.io/badge/PHP-OOP-blue)
![MySQL](https://img.shields.io/badge/MySQL-dbms-orange)

### Features
- **Pure PHP** – No frameworks, minimal dependencies
- **RESTful Architecture** – Supports standard HTTP verbs (GET, POST, PUT, DELETE)
- **Modular Code Structure** – Separate logic into clear, reusable modules
- **PSR-4 Autoloading** – Clean, namespaced codebase
- **Request & Response Handling** – Consistent request parsing and response formatting (JSON)
- **Caching System** – Simple file-based caching for GET requests
- **Versioned API Support** – Easy management of multiple API versions
- **Documented** – Every single files included documentation

## Getting started

First, Import `sql/iran.sql` to your DBMS

## Base URL

```
https://your-api-domain.com/api/v1
```

---

## Cities

### Get All Cities

- **Endpoint:** `/cities`
- **Method:** `GET`
- **Query Parameters:**
  - `fields` (e.g. id,name)
  - `orderby` (e.g. name DESC)
  - `page` (e.g. 3)
  - `page_size` (e.g. 10)

**Success Response:**
```json
{
    "http_code": 200,
    "http_msg": "OK",
    "data": {...}
}
```

---

### Get Cities by Province

- **Endpoint:** `/cities`
- **Method:** `GET`
- **Query Parameters:**
  - `province_id` (e.g. 28)
  - `fields` (e.g. id,name)
  - `orderby` (e.g. name DESC)
  - `page` (e.g. 3)
  - `page_size` (e.g. 10)

**Success Response:**
```json
{
    "http_code": 200,
    "http_msg": "OK",
    "data": {...}
}
```

---

### Insert a New City

- **Endpoint:** `/cities`
- **Method:** `POST`
- **Body:**
```json
{
    "province_id": "e.g. 28",
    "name": "e.g. شهر جدید"
}
```

**Success Response:**
```json
{
    "http_code": 201,
    "http_msg": "created",
    "data": {...}
}
```

---

### Update a City

- **Endpoint:** `/cities`
- **Method:** `PUT`
- **Query Parameters:**
```json
{
    "city_id": "e.g. 450",
    "name": "e.g. نام جدید"
}
```

**Success Response:**
```json
{
    "http_code": 200,
    "http_msg": "OK",
    "data": {...}
}
```

---

### Remove a City

- **Endpoint:** `/cities`
- **Method:** `DELETE`
- **Query Parameters:**
  - `city_id` (e.g. 450)

**Success Response:**
```json
{
    "http_code": 200,
    "http_msg": "OK",
    "data": {...}
}
```

---

## Provinces

### Get All Provinces

- **Endpoint:** `/provinces`
- **Method:** `GET`
- **Query Parameters:**
  - `fields` (e.g. id,name)
  - `orderby` (e.g. name DESC)
  - `page` (e.g. 3)
  - `page_size` (e.g. 10)

**Success Response:**
```json
{
    "http_code": 200,
    "http_msg": "OK",
    "data": {...}
}
```

---

### Insert a New Province

- **Endpoint:** `/provinces`
- **Method:** `POST`
- **Body:**
```json
{
    "name": "e.g. استان جدید"
}
```

**Success Response:**
```json
{
    "http_code": 201,
    "http_msg": "created",
    "data": {...}
}
```

---

### Update a Province

- **Endpoint:** `/provinces`
- **Method:** `PUT`
- **Query Parameters:**
```json
{
    "provinces_id": "e.g. 510",
    "name": "e.g. نام جدید"
}
```

**Success Response:**
```json
{
    "http_code": 200,
    "http_msg": "OK",
    "data": {...}
}
```

---

### Remove a Province

- **Endpoint:** `/provinces`
- **Method:** `DELETE`
- **Query Parameters:**
  - `province_id` (e.g. 510)

**Success Response:**
```json
{
    "http_code": 200,
    "http_msg": "OK",
    "data": {...}
}
```

---

## Error Responses

- **404 Not Found**
  - This means the requested resource does not exist.
  - Example:
    ```json
    {
        "http_code": 404,
        "http_msg": "Not Found",
        "data": []
    }
    ```

- **406 Not Acceptable**
  - This indicates that the request format, parameters, or data are invalid or not acceptable for the server.
  - Example:
    ```json
    {
        "http_code": 406,
        "http_msg": "Not Acceptable",
        "data": []
    }
    ```
---
### Note
You can change the configuration based on your own in `app/core/config.php`
    
example:
```php
return [
    'db' => [
        'host' => 'localhost',
        'name' => 'iran',
        'username' => 'root',
        'password' => '',
    ],
    'cache' => [
        'enabled' => 1,
        'exp' => 3600, // seconds
        'dir' => __DIR__ . '/../../cache/',
    ],
];
```
