# Message Microservice

Deployable as independent (micro)service with its own database providing REST API for managing threads and messages

## Prerequisites
- php
- composer
- MySql

## Installation


- Rename `.env.example` to `.env`
- Update `.env` :
  - Set `APP_DEBUG` to `false` and specify `APP_KEY` (32 random characters)
  - Create empty database and set connection details
  - You can specify `APP_URL_PREFIX` to add a prefix to all endpoints
- Run:

```bash
# Install dependencies and optimize composer autoloader
$ composer install --optimize-autoloader --no-dev

# Create all tables
$ php artisan migrate
```

## Threads

### Get all user threads
```
GET /threads/{userId}
```
- Url
  - int **userId** (required)

<hr> 

### Add thread
```
POST /thread
```
- Body
  - string **title*** - title of the new thread 
  - array(int) **users** - Ids of users assigned to the thread
  - string **params** - JSON with parameters for this thread

<hr>

### Update thread
```
PUT /thread/{threadId}
```
- Url
  - int **threadId*** - Id of the thread to update
  - string **title** - New title
  - string **params** - New params

<hr>

### Delete thread
```
DELETE /thread/{threadId}
```
- Url
  - int **threadId*** - Id of the thread to delete

<hr>

### Add users
```
POST /thread/users/{threadId}
```
- Url
  - int **threadId*** - Id of the thread to delete
- Body
  - array(int) **users** - Ids of users to add

<hr>

### Remove users
```
DELETE /thread/users/{threadId}
```
- Url
  - int **threadId*** - Id of the thread to delete
- Body
  - array(int) **users** - Ids of users to remove

<hr>

## Messages

### Get messages
```
GET /messages/{threadId}
```
- Url
  - int **threadId*** - Id of the thread
- Query string
  - int **take** - number of messages to take (default: 10)
  - int **skip** - number of message to skip (default: 0)


### Add a message
```
POST /message/{threadId}
```
- Url
  - int **threadId*** - Id of the thread
- Body
  - string **content*** - Message content
  - int **userId***
  - string **params** - JSON with parameters for this messages

<hr>

## License
This project is licensed under the MIT License

