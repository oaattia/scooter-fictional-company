## Introduction:
First of all, thanks for the code assigment.
I did the code assigment, but I didn't manage to finish everything as I had many thing to do beside my work (in my free time).  

But I created the main structure needed in the code assigment and also made sure I did that in clean coding style with tests.

Please check the code and give me feedback!

## How to install:
the project structure as two directories, one for `docker` and the other `app` for the coding assigment.
 
run local development env (docker)
```bash
cd docker && docker-compose up -d --build
```
this will build and start docker.

Then we need to install composer files:
```bash
docker-compose run --rm php sh -c "composer require install"
```

After that to make `OpenApi` doc to run under `api/doc`, we will need to move the assets to public dir.

```bash
docker-compose run --rm php sh -c "php bin/console assets:install"
```
After that database and migrations need to be runs

```bash
docker-compose run --rm php sh -c "php bin/console database:schema:create"
```
```bash
docker-compose run --rm php sh -c "php bin/console doctrine:migrations:migrate"
```

Now the project should be working under `/api/`

## Endpoints:
Endpoints documentation can be seen be visiting `api/doc` or `api/doc.json`, that is swagger open api doc.

###Endpoint like that: 

GET `/api/scooters?status={1,0}&limit={int}&offset={int}`

Response: 
```
{
    "success": true,
    "scooters": [
        {
            "uuid": "5e1c7360-e3ac-3f44-9247-1c79ee47dc50",
            "status": true,
            "last_locations": [
                {
                    "datetime": "2022-03-13T19:36:57+01:00",
                    "longitude": -78,
                    "latitude": 63
                }
            ]
        }
    ]
}
```

PUT `api/scooters/{uuid}` 
with body
```
{
    "status": true/false
    "currentDateTime": "d-m-Y H:i:s",
    "longitude": int,
    "latitude": int 
}
```

### Tests
Tests can be executed by:
```bash
docker-compose run --rm php sh -c "php bin/phpunit"
```