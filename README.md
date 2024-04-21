## Installation

>The project uses Docker to run, can be downloaded from https://docs.docker.com/get-docker/
>

> [!IMPORTANT]
> The `.env` file was added to git only for ease of use.

After cloning the project and making sure Docker is running, from the root directory run:
```
docker compose -f config/docker-compose.yml up -d
```
This should start the containers, now when you visit http://localhost:8080/ it should show the index page.

## Running Tests
To create an interactive shell and run tests, from the root directory run
```
docker exec -it php sh
cd tests
php run.php
```

## Thought Process
A bit of info about how I built the app, hope this helps!

### Coming up with a basic plan
First I laid down the basic plan of how I want to build this:
1. Create the workdir and init git
2. Create a Docker environment with PHP and MariaDB
3. Write tests for a class called "TopsoilCalculator"
4. Create the class
    1. Basic getters / setters and properties (valid units, valid depth units, unit, depth unit, width, height, depth)
    2. Methods for calculating volume / bags needed / total price
5. Write tests and create a DB manager class and a Basket class
6. Set up the database tables and add logic to add topsoil objects
7. Build the frontend for it

I tried to keep myself to what you mentioned and do it in about 2 hours, sadly I didn't get as far as I wanted.

Normally I'd try to do the database setup sooner, but I wasn't sure if I'd be able to even use it, so I figured I'd
get the basics done before trying to mess around with a Dockerfile to install the db plugins in the php image.

## Improvements
Obviously a lot of improvements could be done, and some things were left out for the sake of brevity.
### Generic
- PHPDocs are emitted since it's a very tiny project and would make it less readable
- An autoloader could be added to dynamically load classes, would look prettier and less bothersome than having to remember to use `require_once` everywhere.
- Folder structure was a bit simplified for the sake of setup and brevity, normally would look something like this, only `public` being... well, public:
```
/root
  /config
  /public
    /js
    /css
    index.php
  /src
    /Classes
      /SomeNamespace1
      /SomeNamespace2
  /tests
```
### TopsoilCalculator
- The method `convertToCm` could have been less specific to convert units from x to y, but I was running out of time and
  didn't want to waste time figuring out math.
- Some logic and params could be extracted from the `TopsoilCalculator` class, e.g. `convertToCm` and `calculateVolume` - these
  are not tightly coupled logic to the topsoil class. Maybe even new classes like `Measurement` and `Shape` could be created and
  passed to the topsoil class to make it more dynamic.
- Values like `inches`, `metres`, etc. could be extracted to enum classes.
-  There are "magic variables" in `TopsoilCalculator` (e.g. `0.025`) when calculating how many bags are needed, these could
   also be extracted as static class vars, but honestly I wasn't sure what these are, and had no idea what to name them.
- Currently `Basket` and `DbManager` objects are not being passed in the constructor, this was done for simplicity.
### Tests
- Tests are very basic, currently it's just a single file, but a lot of logic could be extracted to a base class,
  and every class should have their own tests.
- Tests are not written for Basket and DbManager, I ran out of time so just quickly added the classes to give you a
  basic idea how I'd start writing them. Both are singleton since it's not very likely multiple instances of them are going to be used.
### Database
- Saving to the database, a table could look like this:
  `topsoil_calculations - (id, unit, depth_unit, width, length, depth)`. It would also be a
  good idea to save the price of a bag of topsoil and current VAT for historical data, as both are subject to change.
