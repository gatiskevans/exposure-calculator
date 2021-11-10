# Exposure Value Calculator

---

This program is dedicated to calculate exposure value for your camera, using your chosen ISO, aperture and shutter speed settings. 

Value range this program operates are following:
* ISO: 100 - 102400
* Aperture: F/1.0 - F/64.0
* Shutter Speed: 1/8000s or higher

When you calculate EV the program will show you EV number 
and a small description for best real-life photography scenario the exposure is suited for. 

EV number is an integer and can be a positive or a negative number.
* Range: -7 to +20
* Program can calculate EV values out of this range, but those are photography extremes and are useless 
for pretty much any real-life subjects.

Every time you calculate EV your settings and results are stored in a CSV file.
You can view list of history in the /history page. Each record has a unique ID value and a link 
to view information about the record.
If there's no history the CSV file will be created. 

Program uses MVC software design pattern.

In order to run the program:
* [Download the project](https://github.com/ReinisD3/CollageMaker/archive/refs/heads/master.zip)
* PHP 7.4 or higher
* Composer installed
* Run `composer install` within the same folder where composer.json file is located
* Run `php -S localhost:8000` to start the server on your local machine
* Enjoy!