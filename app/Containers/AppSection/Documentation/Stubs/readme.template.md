[![Actions Status](https://github.com/engineersmind/swd-backend/workflows/Swd%20CI/CD/badge.svg?branch=dev)](https://github.com/engineersmind/swd-backend/actions)

## API Documentation Links

* [Swagger documentation](api.domain.test/docs/swagger)
* [Postman collection](api.domain.test/docs/postman-collection)
> **_📝:_** <em style="color:red">Access to these links is closed by nginx Basic Auth via credentials.</em>  
> <em style="color:green">Login: ```admin``` Password: ```4Wpd7c9ZMxdT```</em>
* [Admin panel](api.domain.test/admin)

This project was bootstrapped with [Apiato](https://github.com/apiato/apiato).


## **Usage Overview**

Here are some information that should help you understand the basic usage of our REST API.
Including info about Project setup, community conventions, authenticating users, making requests, responses, potential errors, rate limiting, pagination, query parameters and more.

## **Contents**

- [Installation](#Installation)
- [Project setup](#Project-setup)
- [Project naming conventions](#Project-naming-conventions)
- [GIT Workflow](#GIT-Workflow)
- [CI/CD Workflow](#cicd-workflow)
- [Community naming conventions](#Community-naming-conventions)
- [REST API Conventions](#REST-API-Conventions)
- [Using REST methods](#Using-REST-methods)
- [Headers](#Headers)
- [Rate limiting](#Rate-limiting)
- [Tokens](#Tokens)
- [Pagination](#Pagination)
- [Limit](#Limit)
- [Responses](#Responses)
- [Query Parameters](#Query-Parameters)
- [Response Success](#Response-Success)
- [Response Errors](#Response-Errors)
- [Requests](#Requests)

## **Installation**

####Prepopulated User
> <em style="color:green">Login: ```admin@admin.com``` Password: ```Q97ZgyvUvwBsuumf9NLdYmgx```</em><br>
> <em style="color:green">Login: ```user@user.com```&nbsp;&nbsp;&nbsp;&nbsp; Password: ```SWWdxzgP6EeVL3JSYvQfYfTP```</em>

#### Makefile
For convenience, all commonly used commands have been added to the `Makefile`  
Just use the help `make help` to see all the commands

To use them, go to the console (root of project) and write down:

```bash
make command #run command in docker
```
Where `command` is the command from the `Makefile`  
For change env, you should use an additional flag `-i`:
```bash
make -i #change docker env
```

#### Docker Setup

1. Install Docker https://docs.docker.com/get-docker/
2. Install Docker-Compose https://docs.docker.com/compose/install/
3. Execute command:
```bash
make init
```

* It copies the .env file from .env.example (with all dev env)
* Run docker with all containers (nginx, php-fpm, mysql, redis)
* Run composer install inside app container, migrate db, install passport and seed dev data
* Last run chmod on storage for access to all data (like laravel.log) from the containers

That's it!

## **Requirements and Constraints**

* [GIT](https://git-scm.com/downloads)
* [PHP](php.net) 8.0
* PHP Extensions:
    * OpenSSL PHP Extension
    * PDO PHP Extension
    * Mbstring PHP Extension
    * Tokenizer PHP Extension
    * BCMath PHP Extension *(required when the Hash ID feature is enabled)*
    * Intl Extension *(required when you use the Localization Container)*
* [Composer](https://getcomposer.org/download/) *(v.2 is recommended)*
* [Node](https://nodejs.org/en/) *(required for the Swagger Docs generator feature)*
* Web Server *([Nginx](https://www.nginx.com/))*
* Cache Engine *([Redis](http://redis.io))*
* Database Engine *([MySQL](https://www.mysql.com/))*
* Queues Engine *([Redis](http://redis.io))*

## **Project setup**

- make -i (copy .env)
- in .env change the lines http://localhost to match your host
- Database Setup
    * log into MySQL ```mysql -u db_user -p```
    * create a database ```CREATE DATABASE swd_db;```
    * create a database ```CREATE DATABASE swd_test_db;``` for test
    * php artisan key:generate
    * php artisan migrate
    * php artisan db:seed
- File Storage Setup
    * sudo chmod -R 755 storage bootstrap/cache
    * php artisan storage:link
- Documentation Setup
    * npm install - `Install Swagger UI using NPM`
    * php artisan apiato:readme - `generate readme from template`
    * php artisan apiato:swagger - `generate swagger docs`
- Execute CS Fixer
    * composer run php-cs-fixer - `run the fix by .php_cs.dist config`
    * composer run php-cs-fixer-check - `run the test by .php_cs.dist config`
- Execute Psalm
    * composer run psalm - `run the test by psalm.xml config`
- Testing Setup
    * composer run phpunit - `run the test by phpunit.xml config`

Container generation example (for model Instance):  
```bash
php artisan apiato:generate:container --container=Instance
php artisan apiato:generate:test:functional --container=Instance --file=CreateInstanceTest
php artisan apiato:generate:test:unit --container=Instance --file=CreateInstanceUnitTest
php artisan apiato:generate:seeder --container=Instance
php artisan apiato:generate:factory --container=Instance
```

This is how you can start generating phpDocs for the models:  
```bash
php artisan ide-helper:models -W -r '\App\Containers\User\Models\User'
```

Running tests in a separate file
```bash
php artisan apiato:seed-test
```

## **Project naming conventions**

#### Seeders
When generating Seeders, you can set the Seeder_Name_(digit)  
to regulate the sequence of launching this seeder.

#### Routers
The order in routes within the container  
depends on the alphabetical order in the names of the routes


## **Project features** (need expand, and change container)
- $includeUserProperty
- IncludeUserTransformerTrait


## **GIT Workflow**

| Branch | Descriptions                                  | Links                   |
|:-------|:----------------------------------------------|:------------------------|
| dev    | developer version (running before the master) | api.domain.test/        |


### **Git commit or branch naming conventions**

| Commit/Branch | Descriptions                                                     |
|:--------------|:-----------------------------------------------------------------|
|build	        |  Building the project or change external dependencies            |
|ci	            |  Setting up CI and working with scripts                          |
|docs	        |  Documentation update                                            |
|feat/feature   |  Adding new functionality                                        |
|fix	        |  Bug fixing                                                      |
|perf	        |  Changes to improve performance                                  |
|refactor       |  Code changes without fixing bugs or adding new features         |
|revert	        |  Rollback to previous commits                                    |
|style	        |  Code style edits (tabs, indents, periods, commas, etc.)         |
|test	        |  Adding tests                                                    |                                               |

[🔝 UP](#Contents)

The branch for development is always forked from the **dev** branch.  
Also, any changes must be carried out through the **PR**.  
For merging changes, you need to use the squash merge strategy.  

E.g. create a new commit:  
1) `test: add Investment HTTP test;`  
2) `perf: Process updates;`  
    `- delete global user criteria;`

E.g. create a new branch:  
1) `git checkout -B feature/[jira-task-number]-[jira-task-definition]`
2) `git checkout -B fix/hot-fix-some_entity`


## **CI/CD Workflow**

GitHub **CI/CD** is configured by files in a directory `.github/workflows` placed at the repository’s root.  
There are:
- test.yml - `is needed to run tests when creating a PR`
- deploy.yml - `is needed to run deployment to AWS ECS when pushed to branches dev or master`

**Deploying run like this steps:**  
- Checkout: Checkout repository from Github
- Configure AWS credentials: Configure AWS credential environment variables
- Login to Amazon ECR: Log into Amazon ECR with the local Docker client
- Build and push image: nginx: Build the Docker image for nginx and pushes it to Amazon ECR
- Build and push image: php-fpm: Build the Docker image for php-fpm and pushes it to Amazon ECR
- Render task definition: nginx: Renders the final repository URL including the name of repository into the aws/ecs/task-definition.json file
- Render task definition: php-fpm: Renders the final repository URL including the name of repository into the aws/ecs/task-definition.json file
- Deploy Amazon ECS task definition: A task definition is required to run Docker containers in Amazon ECS
- Logout of Amazon ECR: Log out from Amazon ECR and erase credentials connected with it

[🔝 UP](#Contents)

## **Community naming conventions**

 What                                | Rule                                    | Accepted
------------------------------------ | --------------------------------------- | ---------------------------------------
Controller                           | sing.                                   | ArticleController
Routes                               | pl.                                     | articles/1
Route names                          | snake_case                              | users.show_active
Model                                | sing.                                   | User
HasOne and belongsTo Relationships   | sing.                                   | articleComment
All other relationships              | pl.                                     | articleComments
Table                                | pl.                                     | article_comments
Pivot table                          | model names in alphabetical order sing. | article_user
Column in the table                  | snake_case without model name           | meta_title
Model property                       | snake_case                              | $model->created_at
Foreign key                          | model name sing. and _id                | article_id
Primary Key                          | -                                       | id
Migration                            | create(or update)_*_table               | 2020_01_01_000000_create_processes_table
Method                               | camelCase                               | getAll
Method in Resource Controller        | [table](https://laravel.com/docs/master/controllers#resource-controllers) | store
Test Method                          | camelCase                               | testGuestCannotSeeArticle
Variables                            | camelCase                               | $articlesWithAuthor
Collection                           | descriptive, pl.                        | $activeUsers = User::active()->get()
Object                               | descriptive, sing.                      | $activeUser = User::active()->first()
Indexes in config and language files | snake_case                              | articles_enabled
Submission                           | kebab-case                              | show-filtered.blade.php
Configuration file                   | snake_case                              | google_calendar.php
Contract (interface)                 | adjective or noun                       | AuthenticationInterface
Trait                                | adjective                               | Notifiable

[🔝 UP](#Contents)

## **REST API Conventions**

- The names of the fields in the response should be set in `snake_case` (`created_at`,`process_name`)
- For date use this format: `ISO 8601` (YYYY-MM-DDTHH:MM:SSZ)
- Give data (content, entity fields, entity arrays) by placing them in `data`

## **Using REST methods**

 Action   | Endpoint       | Rule
--------- | -------------- | ------------------------------------------------------------------------
  GET     | /v1/users      | Get the list of users;
  GET     | /v1/users/123  | Get the specified user;
  POST    | /v1/users      | Create a new user;
  PATCH   | /v1/users/123  | Update user data;
  PUT     | /v1/users/123  | Update all or more than one data of the specified user (not often used);
  DELETE  | /v1/users/123  | Delete a user.


## **Headers**

Certain API calls require you to send data in a particular format as part of the API call. 
By default, all API calls expect input in `JSON` format, however you need to inform the server that you are sending a JSON-formatted payload.
And to do that you must include the `Accept => application/json` HTTP header with every call.


| Header        | Value Sample                        | When to send it                                                              |
|---------------|-------------------------------------|------------------------------------------------------------------------------|
| Accept        | `application/json`                  | MUST be sent with every endpoint.                                            |
| Content-Type  | `application/json`                  | MUST be sent when passing Data.                                              |
| Authorization | `Bearer {Access-Token-Here}`        | MUST be sent whenever the endpoint requires (Authenticated User).            |

[🔝 UP](#Contents)

## **Rate limiting**

All REST API requests are throttled to prevent abuse and ensure stability. 
The exact number of calls that your application can make per day varies based on the type of request you are making.

The rate limit window is `{{rate-limit-expires}}` minutes per endpoint, with most individual calls allowing for `{{rate-limit-attempts}}` requests in each window.

*In other words, each user is allowed to make `{{rate-limit-attempts}}` calls per endpoint every `{{rate-limit-expires}}` minutes. (For each unique access token).*

For how many hits you can preform on an endpoint, you can always check the header:

```
X-RateLimit-Limit → 30
X-RateLimit-Remaining → 29
```

## **Tokens**

The Access Token lives for `{{access-token-expires-in}}`. (equivalent to `{{access-token-expires-in-minutes}}` minutes).
While the Refresh Token lives for `{{refresh-token-expires-in}}`. (equivalent to `{{refresh-token-expires-in-minutes}}` minutes).

*You will need to re-authenticate the user when the token expires.*

[🔝 UP](#Contents)

## **Pagination**

By default, all fetch requests return the first `{{pagination-limit}}` items in the list. 

Check the [**Paginating query**](#paginating-query) for how to control the pagination.

## **Limit:** 

The `?limit=` parameter can be applied to define, how many record should be returned by the endpoint (see also  [**Paginating query**](#paginating-query)).

**Usage:**

```
api.domain.test/endpoint?limit=100
```

The above example returns 100 resources. 

The `limit` and `page` query parameters can be combined in order to get the next 100 resources:

```
api.domain.test/endpoint?limit=100&page=2
```

You can skip the pagination limit to get all the data, by adding `?limit=0`, this will only work if 'skip pagination' is enabled on the server.

[🔝 UP](#Contents)

## **Responses**

Unless otherwise specified, all of API endpoints will return the information that you request in the JSON data format.

### Standard Response Formats

#### Notes
- The backend always returns all fields, if the `field` is empty then it is `null`

#### List of entities:

```json
{
    "data": [
        {
            "object": "ActiveProcess",
            "id": "jx7d6veb8eg3anrb",
            "name": "test process 1",
            "description": "test process description 1",
            "updated_at": "2020-11-20T21:34:03.000000Z",
            "user": {
                "data": {
                    "object": "User",
                    "id": "jx7d6veb8eg3anrb",
                    "username": "Super Admin",
                    "created_at": "2020-11-20T15:05:13.000000Z"
                }
            }
        },
        {
            "object": "ActiveProcess",
            "id": "jx7d6veb8eg3anrb",
            "name": "test process 2",
            "description": "test process description 2",
            "updated_at": "2020-11-20T21:34:03.000000Z",
            "user": {
                "data": {
                    "object": "User",
                    "id": "jx7d6veb8eg3anrb",
                    "username": "Super Admin",
                    "created_at": "2020-11-20T15:05:13.000000Z"

                }
            }
        }
    ],
    "meta": {
        "include": [],
        "custom": []
    }
}
```

[🔝 UP](#Contents)

#### One entity:

```json
{
    "data": {
        "object": "User",
        "id": "jx7d6veb8eg3anrb",
        "username": "Super Admin",
        "created_at": "2020-11-20T15:05:13.000000Z"
    },
     "meta": {
         "include": [],
         "custom": []
     }
}
```

#### Entity with nested (`include processes & factors`) and meta with pagination:
```json
{
    "data": {
        "object": "User",
        "id": "eqwja3vw94kzmxr1",
        "name": "Admin",
        "email": "admin@admin.com",
        "confirmed": false,
        "avatar": null,
        "created_at": "2020-11-20T15:05:13.000000Z",
        "updated_at": "2020-11-20T15:05:13.000000Z",
        "readable_created_at": "48 minutes ago",
        "readable_updated_at": "48 minutes ago",
        "processes": {
            "data": [
                {
                    "object": "Process",
                    "id": "jx7d6veb8eg3anrb",
                    "name": "Process Kamron Spencer",
                    "description": "Process Dolor qui quod a nulla.",
                    "factors": {
                        "data": [
                            {
                                "object": "Factor",
                                "id": "jx7d6veb8eg3anrb",
                                "name": "Factor test 1",
                                "description": "Factor description test 1",
                                "position": 1,
                                "group": "Financial",
                                "type": "Qualitative",
                                "score": {
                                    "Excellent": 22
                                },
                                "updated_at": "2020-11-26T00:00:00.000000Z",
                                "checklists": {
                                    "data": [
                                        {
                                            "object": "Checklist",
                                            "id": "jx7d6veb8eg3anrb",
                                            "name": "Checklist test 1",
                                            "description": "Checklist description test 1",
                                            "updated_at": "2020-11-26T00:00:00.000000Z"
                                        }
                                    ]
                                }
                            }
                        ]
                    }
                }
            ]
        }
    },
    "meta": {
        "include": [
            "user",
            "roles"
        ],
        "custom": {
            "token_type": "personal",
            "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUxI..."
        },
        "pagination": {
            "total": 100,
            "count": 30,
            "per_page": 30,
            "current_page": 1,
            "total_pages": 50,
            "links": {
                "previous": null,
                "next": "api.domain.test/api/v1/post?page=2"
            }
        }
    }
}
```

[🔝 UP](#Contents)

### Give one notification in `message`
For example, to display in the modal: "The data has been successfully updated!":
```json
{
    "message": "The data has been successfully updated!"
}
```

### Give validation errors in the `errors` array:
__The answer has code 422 Unprocessable Entity - validity error__
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "group": [
            "The Name field is required.",
            "he selected group is invalid."
        ]
    }
}
```

### Application errors (400, 401, 402, 403, 404) are in the error array:
```json
{
    "message": "An Exceptions occurred when trying to authenticate the User."
}
```

### **Response Success**

| Action             | Status Code     | Message                                    |
|--------------------|-----------------|--------------------------------------------|
| GET                | 200             | HTTP_OK                                    |
| CREATE             | 201             | HTTP_CREATED                               |
| UPDATE             | 200 / 204       | HTTP_CREATED / HTTP_NO_CONTENT             |
| DELETE             | 200 / 204 / 202 | HTTP_OK / HTTP_NO_CONTENT / HTTP_ACCEPTED* |
|                    |                 | *`i.e. "Resource was marked for deletion"` |

### **Response Errors**

| Error Code | Message                                                                               | Reason                                              |
|------------|---------------------------------------------------------------------------------------|-----------------------------------------------------|
| 401        | Wrong number of segments.                                                             | Wrong Token.                                        |
| 401        | Failed to authenticate because of bad credentials or an invalid authorization header. | Missing parts of the Token.                         |
| 405        | Method Not Allowed.                                                                   | Wrong Endpoint URL.                                 |
| 422        | Invalid Input.                                                                        | Validation Error.                                   |
| 500        | This action is unauthorized.                                                          | Using wrong HTTP Verb. OR using unauthorized token. |



#### Header Response:

```shell
Server →nginx/1.18.0 (Ubuntu)
Content-Type →application/json
Transfer-Encoding →chunked
Connection →keep-alive
Date →Fri, 27 Nov 2020 14:03:48 GMT
ETag → "9c83bf4cf0d09c34782572727281b85879dd4ff6"
X-RateLimit-Limit →30
X-RateLimit-Remaining →28
Access-Control-Allow-Origin →*
```

[🔝 UP](#Contents)

## **Query Parameters**

Query parameters are optional, you can apply them to some endpoints whenever you need them.

### Ordering

The `?orderBy=` parameter can be applied to any **`GET`** HTTP request responsible for ordering the listing of the records by a field.

**Usage:**

```
api.domain.test/endpoint?orderBy=created_at
```

### Sorting

The `?sortedBy=` parameter is usually used with the `orderBy` parameter.

By default the `orderBy` sorts the data in **ASC** order, if you want the data sorted in **DESC** order, you can add `&sortedBy=desc`.

**Usage:**

```
api.domain.test/endpoint?orderBy=name&sortedBy=desc
```

[🔝 UP](#Contents)

#### Sorting multiple columns difference sortedBy:

```
api.domain.test/endpoint?orderBy=name;created_at&sortedBy=desc;asc
```

#### Sorting through related tables:

```
api.domain.test/endpoint?orderBy=posts|title&sortedBy=desc
```

> Query will have something like this

```shell
INNER JOIN posts ON users.post_id = posts.id
...
ORDER BY title
```

```
api.domain.test/endpoint?orderBy=posts:custom_id|posts.title&sortedBy=desc
```

> Query will have something like this

```shell
...
INNER JOIN posts ON users.custom_id = posts.id
...
ORDER BY posts.title
```

Order By Accepts:

- `asc` for Ascending.
- `desc` for Descending.

[🔝 UP](#Contents)

### Searching

The `?search=` parameter can be applied to any **`GET`** HTTP request.

**Usage:**

#### Search any field:

```
api.domain.test/endpoint?search=first name
```

> Space should be replaced with `%20` (search=first%20name).

#### Search any field for multiple keywords (by the semicolon ```;```):

```
api.domain.test/endpoint?search=first name;last name
```

#### Search in specific field (by the colons ```:```):
```
api.domain.test/endpoint?search=is_active:true
```

#### Search in specific fields for multiple keywords: 
```
api.domain.test/endpoint?search=is_active:true;name:test
```

#### Search query condition for multiple keywords: 

 ```
 ?search=is_active:true;name:test&searchJoin=and
 ```

> Specifies the search method (AND / OR), by default the application searches each parameter with OR

[🔝 UP](#Contents)

#### Define query condition:

```
api.domain.test/endpoint?search=field:keyword&searchFields=name:like
```

Available Conditions (by default): 

- `like`: string like the field. (SQL query `%keyword%`).
- `=`: string exact match.


#### Define query condition for multiple fields:

```
api.domain.test/endpoint?search=field1:first_keyword;field2:second_keyword&searchFields=field1:like;field2:=;
```

### Filtering fields

The `?filter=` parameter can be applied to any HTTP request.

And is used to control the response size, by defining what data you want back in the response.

**Usage:**

Return only ID and Name from that Model.

```
api.domain.test/endpoint?filter=id;name
```

Example Response, including only id and status:

```json
{
    "data": [
        {
            "id": "bmo7y84xpgeza06k",
            "name": "Random Process Name"
        },
        {
            "id": "r6lbekg8rv5ozyad",
            "name": "Lorem Ipsum Name"
        },
        {
            "id": "r6lbekg8rv5ozyad",
            "name": "random name"
        }
    ]
}
```

[🔝 UP](#Contents)

### Paginating query

The `?page=` parameter can be applied to any **`GET`** HTTP request responsible for listing records (mainly for Paginated data).

**Usage:**

```
api.domain.test/endpoint?page=200
```

*The pagination object is always returned in the **meta** when pagination is available on the endpoint.*

```shell
{
    "data" : [...],
    "meta": {
        "include": [
            "user"
        ],
        "custom": [],
        "pagination": {
            "total": 100,
            "count": 30,
            "per_page": 30,
            "current_page": 1,
            "total_pages": 50,
            "links": {
                "previous": null,
                "next": "api.domain.test/api/v1/post?page=2"
            }
        }
    }
}
```

[🔝 UP](#Contents)

### Relationships

The `?include=` parameter can be used with any endpoint, only if it supports it. 

How to use it: let's say there's a `Process` Model and `Factor` Model. 

And there's an endpoint `/processes` that returns all the Processes items. 

The include allows getting the Process with their Factors `/processes?include=factors`. 

However, for this parameter to work, the endpoint `/processes` should clearly define that it
accepts `factors` as relationship and add in the **$availableIncludes** array.

**Usage:**

 ```
 api.domain.test/endpoint?include=relationship1;relationship2
 ```

#### Nested relationship:

 ```
 api.domain.test/endpoint?include=factors.checklists.questions
 ```

Every response contains an `include` in its `meta`  as follow:

```
   "meta":{
      "include":[
         "relationship-1",
         "relationship-2",
      ],
```

[🔝 UP](#Contents)

### Caching

Some endpoints can store their response data in memory (caching) after querying them for the first time, to speed up the response time.

The `?skipCache=` parameter can be used to force skip loading the response data from the server cache and instead get a fresh data from the database upon the request.

**Usage:**

```
api.domain.test/endpoint?skipCache=true
```

## **Requests**

Calling unprotected endpoint example:

```shell
curl -X POST \
-H "Accept: application/json" \
-H "Content-Type: application/x-www-form-urlencoded;" \
-F "email=admin@admin.com" \
-F "password=admin" \
-F "=" "api.domain.test/api/v1/register"
```

```shell
curl -X POST \
  -H 'accept: application/json' \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/json' \
  -F "email=admin@admin.com" \
  -F "password=admin" \
  -F "client_id=2" \
  -F "client_secret=IToFIpUkPHdV0swZxUViqSz2udqvRCCbuGaDGs7N" \
  -F "grant_type=password"
  -F "=" api.domain.test/api/v1/oauth/token
```

Calling protected endpoint (passing Bearer Token) example:

```shell
curl -X GET \
-H "Accept: application/json" \
-H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..." \
-H "api.domain.test/api/v1/users"
```

[🔝 UP](#Contents)
