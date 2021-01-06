Laravel TODO API
==================

### Description
TODO List API built on Laravel 8

## Documentation URL

- [docs](https://documenter.getpostman.com/view/14094805/TVzNHeRW).


## TODOS


### Get all todos

```http
GET /api/v1/todos?perPage=20&page=1
```

| Parameter | Type | Description |
| :--- | :--- | :--- |
| `perPage` | `integer` | No of items to retrieve per page |
| `page` | `integer` | Pagination number |


### Show a todo

```http
GET /api/v1/todos/1
```

### Create a todo

```http
POST /api/v1/todos
```

```
    {
        "title": "Dress clothes",
        "group": 1,
        "description": "This is the description"
    }
```

### Update a todo

```http
PATCH /api/v1/todos
```

```
    {
        "title": "Dress clothes",
        "group": 1,
        "description": "This is the description"
    }
```

### Delete a todo

```http
DELETE /api/v1/todos/1
```


## TODO GROUPS
Group API for grouping similar todos


### Get all groups

```http
GET /api/v1/groups
```


### Show a group

```http
GET /api/v1/groups/1
```

### Create a group

```http
POST /api/v1/groups
```

```
    {
        "name": "todo group",
        "description": "This is the todo group"
    }
```

### Update a group

```http
PATCH /api/v1/groups
```

```
    {
        "name": "todo group",
        "description": "This is the todo group"
    }
```

### Delete a group

```http
DELETE /api/v1/groups/1




## Responses

All End points return the resource created or edited, incase of an error, the below response is returned

```
{
  "message" : string,
  "success" : bool,
  "data": string
}
```

The `message` attribute contains a message commonly used to indicate errors or, in the case of deleting a resource, success that the resource was properly deleted.

The `success` attribute describes if the request was successful or not.

The `data` attribute contains any other metadata associated with the response. This will be an escaped string containing JSON data.

## Status Codes

This returns the following status codes in its API:

| Status Code | Description |
| :--- | :--- |
| 200 | `OK` |
| 201 | `CREATED` |
| 400 | `BAD REQUEST` |
| 404 | `NOT FOUND` |
| 500 | `INTERNAL SERVER ERROR` |
