<?php
/********************************
* Project: Jumbotron
* Code Version: 1.2
* Author: Benjamin Sommer
* GitHub: https://github.com/remmosnimajneb
* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
***************************************************************************************/

//MySQL Database Connection Script
$con = new PDO("mysql:host=DB_HOST;dbname=DB_NAME", "DB_USER", "DB_PSSWD");

//Admin Login Credentials
$adminUsername = "INSERT_ADMIN_USERNAME";
$adminPassword = "INSERT_ADMIN_PSSWD";

//Slideshow Slides Directory (If Unix maken sure Directory is Writable!)
	//Windows also but it's normally not THAT much of an issue :)
$slidesDirectory = "INSERT_FULL_SLIDES_DIR";
?>
