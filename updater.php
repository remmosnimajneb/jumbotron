<?php
/********************************
* Project: Jumbotron
* Code Version: 1.2
* Author: Benjamin Sommer
* GitHub: https://github.com/remmosnimajneb
* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
***************************************************************************************/

/**
* Long Polling Script to Auto-Reload the page
* This was implemented so that you can remotely update the screen from any other PC on the network (or world if made public)
* This script reads reload.txt and sends back the first line (true or false) if true it will javascript reload and get latest updates, if false nothing
* This script reads the line, sends it and then writes false to mark it send the update (if there was)
* Also implemented so if one wanted to expand on this by sending other updates the 'setup' is there already
*/

//Start Headers
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

//Read File
$line = fgets(fopen("reload.txt", 'r'));

//Send True or False for 'Event Type: Reload'
echo "event: reload\n";
echo "data: {$line}\n\n";
flush();

//Then put false into the TXT file
$file_data = "false";
file_put_contents('reload.txt', $file_data);
?>