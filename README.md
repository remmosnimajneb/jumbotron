# Jumbotron - Digital Announcements Screen
## A cool way to digitize that old anouncments board in your school/work/buissness/ect!
Project: Jumbotron
Code Version: 1.2
Author: Benjamin Sommer
GitHub: https://github.com/remmosnimajneb
Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)

1. Overview
2. Requirements & Install Instructions
3. How do I use it?
4. Files Explanation
5. Updates to come

# 1. Overview:
So one thing I noticed at a lot of places recently is that they still use physical display boards in front of their offices/schools/ect.
Everything is digital now! Why isn't that also?
So here it is, my attempt at solving the problem!

This program (meant mostly for schools and organizations but can be used for anything) is a web based app that you open using a regular web browser such as Firefox or Chrome and gives you a (dynamic) slideshow and announcements ticker bar, and a (static) Sidebar for anything else and a Date and Time box on the bottom.

The slideshow and Announcements Ticker are able to be remotely updated using an admin backend, the rest of it isn't although I have plans to possibly do so...(plans is the key word.....)

One of the cool parts also is that since this is basically a website it can be used in various setups including
1. PC connected to Monitor with scripts on that local machine
2. Scripts on another machine elsewhere in building and a terminal shell (or Rasberry Pi) on the same LAN pulling it
3. Scripts on a public server (example.com/jumbotron) and a terminal shell (or Rasberry Pi) on the same LAN pulling it
Also another fun thing you can do since it's web based is you can have this on one machine and use it to display on multiple monitors hooking up to the same screen (will make issues with sending updates though (would have to change program around a bit :(, see updates to come).

Also this program, like all my others is totally, "do whatever the heck you want just I take zero responsibility for anything", you can play around with this and customize to how you want it. (Just make sure to DM me some cool pics after it's setup :)

# 2. Requirments:

1. A web server (Can be one of three things, A. On the physical machine (localhost) B. On a machine on the LAN (192.168.20.21) or C. On a public Server (example.com/jumbotron))
2. MySQL with PDO type PHP Extention (!Important!)
3. PHP
4. That's it

Aight, let's go! Let's install this thing already!!

Install: 

Here's how to install this:
1. Copy all files to your Web-Server Directory
2. Install the Database with the SQL Install File (File: Jumbotron_MYSQL_Install.sql)
3. Open the functions file (File: functions.php) in your favorite text editor (h/t to mine Sublime Text 3) and Insert the MySQL information, admin login and FULL slides directory path
	-Note if your running Unix make sure the slides directory is writable for uploading files
4. Login to the admin panel at {Your_Install_Location}/admin.php use the credentials you inserted from the functions.php
5. Use the backend to add new Slides and Announcements
6. On the display monitor itself, open the webpage in a web browser and enjoy!
	-Tip! Put the browser on full screen mode to cover the taskbar and other 

# 3. How do I Use this?
Okay so assuming you just installed it:
	
1. To customize the Sidebar next to the slides you'll need to:
	1. Open the index.php (File: index.php) in your favorite text editor and edit it there (in the div #sidebar). I have plans to make that 'updatable' in the backend but not yet
2. Change the time and date:
	1. Go to time.is/widget and you can customize your own widget how you want it
	2. Take that code from Step 1 and open the index.php (File: index.php) in your favorite text editor and paste it into the Date Time Section (.dateTime)
3. Admin Backend
	1. Log in on any browser on the LAN using http://HOST/login.php with the credentials specified in functions.php
	2. You can then edit or add new slides for the slideshow or announcements for the ticker
	3. Note the Date Start and Date Expires times which allow you to have an announcement expire by a certain date
		1. To do this you'll need to have a way of remotely reloading the page every day to get the latest updates
		2. Meaning: Have a cron job or task scheduler for windows run a task at let's say 1AM every morning
		3. The task is going to manually call the reload script built into the program, it should write to the reload.txt file and put on the first line 'true'. This will automatically make the page reload by itself.
		4. To make it easier you can create a php script to write to the txt file and just call that.
		5. I would like to make an auto install for this by haven't yet.
	4. Reload Screen allows you to automatically reload the screen from anywhere else on the LAN. (Meaning) if your screen is 5 floors down, you can hit Reload from your office and the screen will reload and get the latest information.
		1. This utilizes a long polling script builtin to the system


# 4. Files Explanation
Just goes through the files (even thought I left comments) to explain how it all works
1. Functions.php - Sets global variables for the MySQL connection, the Admin Credentials to login to the backend and the Slides Directory
2. Login.php - Login page and Authentication Page
3. Index.php - Screen itself
4. Admin.php - Admin panel to edit and add new slides and announcements
5. Updater.php - Long Polling Script for the Auto-Reload
6. reload.txt - Hold variable for if a screen reload is needed (true or false)

# 5. Updates to Possibly Come
Things I want to one day fix and add....(Someday.......under the Rainbow......):
1. Make sidebar able to be auto-updated
2. Make layout of the page able to be changed from backend
3. Auto-Install script for the Cron Job or Task Scheduler
4. System for Sending Updates without having to reload page
5. Allow for Updates on multiple monitors
	1. The way the system works now it only let's one monitor update the other won't get the update, logging clients by an ID will let multiple monitors update properly