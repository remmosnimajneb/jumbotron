<?php
/********************************
* Project: Jumbotron
* Code Version: 1.2
* Author: Benjamin Sommer
* GitHub: https://github.com/remmosnimajneb
* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
***************************************************************************************/
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Announcements Board</title>
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
					<section id="main">
						<div class="flex-container">
					  		<div style="flex-basis: 80vw">
					  			<?php
					  				//MySQL Connect Script
									include 'functions.php';

					  				//Get the content for the Ticket and the Slideshow
					  				$tickerString = '';
					  				$slideshowString = '';
					  				$date = date("Y-m-d");

					  				$sql = ("SELECT * FROM `content` WHERE `StartDate` <= '".$date."' and `EndDate` >= '".$date."' ORDER BY `ContentID` ASC");
									$stm = $con->prepare($sql);
									$stm->execute();
									$records = $stm->fetchAll();
									foreach($records as $row){
										if($row['ContentType'] == "announcement"){
											$tickerString .= " " . $row['Content'] . " |";
										} else if($row['ContentType'] == "slideshow"){
											$slideshowString .= "<div><img style='background-size: cover;' src='slides/" . $row['Content'] . "'></div>";
										};
									};
					  			?>
					  			<div id="slideshow">
						  		   <?php echo $slideshowString; ?>
								</div>
								<div class="marquee">
									<?php echo $tickerString; ?>
								</div>
					  		</div>
					
					  		<div style="flex-basis: 20vw">
					  			<div id="sidebar">
						  			<ul>
						  				<li>Welcome to Example Place!</li><br />
						  				<li>Executive Dept. - 3rd Floor</li><br />
						  				<li>Administrative Offices - 2nd Floor</li><br />
						  				<li>IT Dept. - Basement</li><br />
						  			</ul>
								</div>
								<div class="dateTime">
									<!--Get Time and Date (Customize!) from here: https://time.is/widgets-->
									<a href="https://time.is/NYC" id="time_is_link" rel="nofollow"></a>
									<span id="New_York_z161"></span>
									<script src="//widget.time.is/en.js"></script>
									<script>
									time_is_widget.init({New_York_z161:{template:"TIME<br>DATE", time_format:"12hours:minutesAMPM", date_format:"dayname, monthname, dnum, year"}});
									</script>
								</div>
							</div>
							</div>
						</div>	
					</section>
			</div>

		<!-- Theme Scripts -->
			<!--[if lte IE 8]><script src="assets/js/respond.min.js"></script><![endif]-->
			<script>
				if ('addEventListener' in window) {
					window.addEventListener('load', function() { document.body.className = document.body.className.replace(/\bis-loading\b/, ''); });
					document.body.className += (navigator.userAgent.match(/(MSIE|rv:11\.0)/) ? ' is-ie' : '');
				}
			</script>
		<!-- Animation Scripts -->
			<script src="assets/js/jquery.js"></script>
			<script src="assets/js/jquery.marquee.js"></script>
			<script type="text/javascript">
				/**
				* Script for Scrolling Text Marquee
				*/
				$('.marquee').marquee({
				    //speed in milliseconds of the marquee
				    duration: 20000,
				    //gap in pixels between the tickers
				    gap: 0,
				    //time in milliseconds before the marquee will start animating
				    delayBeforeStart: 0,
				    //'left' or 'right'
				    direction: 'left',
				    //true or false - should the marquee be duplicated to show an effect of continues flow
				    duplicated: true
				});

				/**
				* Slideshow Script for Image Slideshow
				*/
				$("#slideshow > div:gt(0)").hide();
					setInterval(function() {
					  $('#slideshow > div:first')
					    .fadeOut(1000)
					    .next()
					    .fadeIn(1000)	
					    .end()
					    .appendTo('#slideshow');
					}, 10000);
			
				/**
				*Long Polling script to get updates from Server
				*/
				var source = new EventSource('updater.php');
				
				//Event Types: 'reload'
				source.addEventListener('reload', function(e) {
					if(e.data == "true"){
						location.reload(); 
					};
				}, false);
			</script>
	</body>
</html>
