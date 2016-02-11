# VenueWebsite

## Installation

-  Install XAMPP for windows
-  Start apache from XAMPP Control Panel
-  Drop folder 'venue' into c:/xampp/htdocs
-  Edit config.php 
-  Using your web browser navigate to localhost/venue/ 
-  Enjoy!

## Using the Websute and How the Site Works

-  Once you have sucessfully installed the site and are running apache you can access it in your browser by going to http://localhost/venue/
-  When you go to http://localhost/venue/ the php file index.php is called, it processes the request and returns html to the browser
-  SearchMethods.php contains functions for searching the database for venues
-  style.css contains cascading style sheets that improve the looks of the webpage
-  venue.js contains javascript necessary for google maps integration

## Generating a database

I have provided you with a working database, so you wont need to do this, but here's how to do it anyway:

-  Get a venue JSON output from the FourSquareVenue Crawler and put in in the 'data' folder of this project
-  run the script with command 'python VenueJsonToDB.py Venues.json' where 'Venues.json' is the file produced by the crawler
-  A database will called 'Venue.db' will now be placed in the 'data' folder
-  To use this database with your application place it in the 'venue' root folder, i.e. the same folder as index.php (you may need to stop apache while doing this)
 
## Windows 10 Installation of XAMPP
You might need to do this to get XAMPP working if you are using Windows 10:
http://stackoverflow.com/questions/27333203/xampp-couldnt-start-apache-windows-10

