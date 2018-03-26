<?php
/********************************
* Project: Jumbotron
* Code Version: 1.2
* Author: Benjamin Sommer
* GitHub: https://github.com/remmosnimajneb
* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
***************************************************************************************/

//Include Functions Scrips
include 'functions.php';

//Assume User is logging in for first time and set the Authentication Session False
session_start();
$_SESSION['JumbotronAuthenticated'] = false;

//If it's a post request, he tried logging in
$error = '';
if(isset($_POST['username']) && isset($_POST['password'])){
		//If credentials match (credentials set in functions.php), set Session, Go to admin.php
	if($_POST['username'] == $adminUsername && $_POST['password'] == $adminPassword){
		$_SESSION['JumbotronAuthenticated'] = true;
		header('Location: admin.php');
	} else {
			//Else throw an error!
		$error = "Error! Authentication Failed. Please try again!";
	}
};
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Please Login!</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-loading">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<section id="main" style="width:50vw; padding: 50px">
						<h1>Please Login!</h1>
						<p><?php echo $error; ?></p>
						<hr />
							<form action="login.php" method="post">
								Username: <input type="text" name="username">
								Password: <input type="password" name="password"><br />
								<input type="submit" value="Login">
							</form>
					</section>
			</div>

		<!-- Scripts -->
			<!--[if lte IE 8]><script src="assets/js/respond.min.js"></script><![endif]-->
			<script src="assets/js/jquery.js"></script>
			<script src="assets/js/jquery.marquee.js"></script>
			<script>
				if ('addEventListener' in window) {
					window.addEventListener('load', function() { document.body.className = document.body.className.replace(/\bis-loading\b/, ''); });
					document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
				}
			</script>
	</body>
</html>