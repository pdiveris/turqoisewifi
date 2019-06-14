## Purple WiFi
### Code challenge, Advent of Code
#### Problem chosen day 23

--- Day 23: Experimental Emergency Teleportation ---

Click [here](https://adventofcode.com/2018/day/23) for full details and background.

Using your torch to search the darkness of the rocky cavern, you finally locate the man's friend: a small reindeer.

You hit the "experimental emergency teleportation" button on the device [...]
The device lists the X,Y,Z position (pos) for each nanobot as well as its signal radius (r) on its tiny screen (your puzzle input) [...]

Each nanobot can transmit signals to any integer coordinate which is a distance away from it less than or equal to its signal radius (as measured by Manhattan distance). 

Coordinates a distance away of less than or equal to a nanobot's signal radius are said to be in range of that nanobot.

[...] determine which nanobot is the strongest (that is, which has the largest signal radius) and then, for that nanobot, the total number of nanobots that are in range of it, including itself.

For example, given the following nanobots:
```
pos=<0,0,0>, r=4
pos=<1,0,0>, r=1
pos=<4,0,0>, r=3
pos=<0,2,0>, r=1
pos=<0,5,0>, r=3
pos=<0,0,3>, r=1
pos=<1,1,1>, r=1
pos=<1,1,2>, r=1
pos=<1,3,1>, r=1
```

The strongest nanobot is the first one (position 0,0,0) because its signal radius, 4 is the largest. Using that nanobot's location and signal radius, the following nanobots are in or out of range:

 * The nanobot at 0,0,0 is distance 0 away, and so it is in range.
 * The nanobot at 1,0,0 is distance 1 away, and so it is in range.
 * The nanobot at 4,0,0 is distance 4 away, and so it is in range.
 * The nanobot at 0,2,0 is distance 2 away, and so it is in range.
 * The nanobot at 0,5,0 is distance 5 away, and so it is not in range.
 * The nanobot at 0,0,3 is distance 3 away, and so it is in range.
 * The nanobot at 1,1,1 is distance 3 away, and so it is in range.
 * The nanobot at 1,1,2 is distance 4 away, and so it is in range.
 * The nanobot at 1,3,1 is distance 5 away, and so it is not in range.

### Given the problem
My solution then tries to 
 * Load the data from a file I created from [here](https://adventofcode.com/2018/day/23/input).
 The data differs for each user. My data can be found in `database/nanobots.data` and it consist of 1,000 entries.
 * I then proceed to find the top NanoBot, that is, the NanoBot with the greatest range. I do so by ordering by range in descending
 order and fetching and returning the first one. Error checks have been put in place where appropriate and as much as it was possible within
 reasonable time limits.
 * Finally, I loop through all the nanoBots and check whether they are within the range of my NanoBott (the top Bot in this case.)
 
### To run the code you will need Docker installed and running on your workstation
* Clone the repository in a folder on your workstation/laptop
* Run `docker-compose up -d`

NB: The web server app is set to run on port 80. Please stop any webserver running on your 
laptop or contact me to change it to something else. Alternatively you can edit the nginx/conf.d/app.conf 
and change the port to your liking e.g.:

```
server {
    listen 8888;
    ...
```

 ### The code runs in two modes
 * As a web application:
   go to [http://127.0.0.1/](http://127.0.0.1/) in your browser
   
 * From the command line
   * `docker-compose exec app php artisan purple:advent23`

### Unit tests
 * In addition to running the code as shown above, there are a few unit tests that you can run as follows:
 ```docker-compose exec app \ vendor/phpunit/phpunit/phpunit```
 * The tests cover a few cases (can generate id, can load valid file, throws exception on invalid file or data etc.) 
 Please have a look in `tests/Unit/NanoBotRepositoryTest.php` for details.
 
 
