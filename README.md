# About Project

This is a simple API for user can search kost for room that have been added by owner. Also, user can ask about room availability using credit system.

Regular user will have 20 credit and premium user will have 40 credit per month.

# Project Requirement

1. Regular user will be given 20 credit, premium user will be given 40 credit after register.
2. Owner will have no credit.
3. Owner can add more than 1 kost
4. Search kost by several criteria: name, location, price
5. Search kost sorted by: price
6. Ask about room availability will reduce user credit by 5 point
7. Owner API & ask room availability API need to have authentication
8. Implement scheduled command to recharge user credit on every start of the month

# Prerequisites

1. PHP 7.3.28
2. Laravel 8.83.7
3. Laravel Sanctum for Authentication
4. Composer
5. MySQL

# Scheduling Task

This project also implement scheduled command to recharge user credit on every start of the month named **monthly:recharge**.

To run scheduling task you can use **Crontab**:

1. Open crontab file

```
    crontab -e
```

2. Edit crontab file and add

```
    0 0 1 * * cd /your-project-path && php artisan monthly:recharge >> /dev/null 2>&1
```

# Setup Guide

1. Clone this Repo

```
    git clone https://github.com/yogahilmi/mykost-api.git
```

2. Copy file .env.example and rename it to .env

```
    cp .env.example .env
```

3. Edit .env, fill DB setting and save

4. Migrate DB

```
    php artisan migrate
```

5. Run the project

```
    php artisan serve
```

# API Documentation

## Auth /api/auth

**Register User**

> POST /api/auth/register

Body:

```
{
    "name": "Yoga Hilmi Tasanah",
    "email": "yogahilmi@mail.com",
    "password": "12345678",
    "role": 0
}
```

**Login User**

> POST /api/auth/login

Body:

```
{
    "email": "yogahilmi@mail.com",
    "password": "12345678"
}
```

**Logout User**

> POST /api/auth/logout

Authorization: Bearer Token

## Kost /api/kosts/

**Create New Kost**

> POST /api/kosts/create

Authorization: Bearer Token

Body:

```
{
    "name" : "Kost Murah",
    "location" : "Jakarta",
    "price" : 950000,
    "description" : "Kost dengan fasilitas lengkap di pusat kota"
}
```

**Update Kost Detail**

> PUT /api/kost/edit/{id}

Authorization: Bearer Token

Body:

```
{
    "name" : "Kost Murah",
    "location" : "Jakarta",
    "price" : 950000,
    "description" : "Kost dengan fasilitas lengkap di pusat kota"
}
```

**Delete Kost**

> DELETE /api/kost/edit/{id}

Authorization: Bearer Token

**Show Kost Data By Owner**

> GET /api/kost/data/list

Authorization: Bearer Token

**Show All Kost Data**

> GET /api/kost/

**Show Kost Data By ID**

> GET /api/kost/{id}

Authorization: Bearer Token

**Search Kost Data By Params**

> GET /api/kost/search

Authorization: Bearer Token

Body:

```
{
    "name" : "",
    "location" : "",
    "price" :
}
```

## Room Availability /api/availability

**Ask Availability**

> POST /api/availability/kost/{id}/ask

Authorization: Bearer Token

**Give Availability**

> POST /api/availability/{id}/give

Authorization: Bearer Token

Body:

```
{
    "is_available" : 1
}
```

**Show Availability By ID**

> GET /api/availability/kost/{id}

Authorization: Bearer Token

**Show All Availability**

> GET /api/availability

Authorization: Bearer Token
