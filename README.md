growMapAPI
==========

Modified PHP version of the `growstuff.org` JSON API. This is a PHP backend based on [CodeIgniter](http://www.codeigniter.com/)
that resembles some of the JSON API of the `growstuff.org` site. It gets data from the `growstuff.org` API,
stores it and provides it via its own JSON API. Its own API provides an exact subset of the `growstuff.org`
API - meaning that the JSON responses contain the same data in the same format, but not all of it.

The main purpose of this API is to be used together with the `growMapJS` frontend!

Installation
------------

Copy all the files to your server and make sure you set the correct access rights.
Then create a MySQL database and use the `db.sql` file to create the necessary tables.
Then open `application/config/database.php` and `application/config/config.php` set the correct values (see 
CodeIgniter documentation and your server settings).
Now open `yourserver/growmap/index.php/main/update` in a web browser and wait until you see `update done`.
This should get all the data needed from `growstuff.org` - if it fails check if the `growstuff.org` API is
working and if the db settings are correct. For the future you should set `yourserver/growmap/index.php/main/update`
as a cron job.

Usage
-----

The API should be up and working now. You have the following modes of using it:

`index.php/main/crops.json` - produces a list of all available crops without individual plantings
`index.php/main/crops/22.json` - produces all details of the crop with id `22` (choose id as needed)
`index.php/main/crops/-1.json` - procues a list of all crops with all the details provided in the above call!
The latter is an extended version of the API that is not available with the `growstuff.org` API.

All data is provided by the `growstuff.org` site under the [CC-BY-SA](http://creativecommons.org/licenses/by-sa/3.0/)
license.

