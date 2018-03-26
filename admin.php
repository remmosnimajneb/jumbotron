<?php
/********************************
* Project: Jumbotron
* Code Version: 1.2
* Author: Benjamin Sommer
* GitHub: https://github.com/remmosnimajneb
* Theme Design by: HTML5 UP [HTML5UP.NET] - Theme `Identity`
* Licensing Information: CC BY-SA 4.0 (https://creativecommons.org/licenses/by-sa/4.0/)
***************************************************************************************/

//Include Functions
include 'functions.php';

//Start Session and check authentication
session_start();
if($_SESSION['JumbotronAuthenticated'] != true){
	header('Location: login.php');
	die();
};
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
					<section id="main" style="width:150vw;padding: 50px;overflow: auto;height: 100%;">
						<h1>Update Content</h1>
							<?php
								//Output any Messages from URL
								if(isset($_GET['msg'])){
									echo "<p style='color:red;'>" . $_GET['msg'] . "</p>";
								};

								$date = date("Y-m-d");
								error_reporting(0);

								/** Large Switch Statement to Handle Admin Code Possibilities
									* Show Items: (Action: [showAll, showIndividual, showAddNew]; ContentType: [slideshow, announcement];)
										* Defualt: Announcments or Slideshow
										* Show all (Both)
										* Show Individual (Both, File name for Slideshow, Input for Announcment)
										* Add New (Both, File Upload for Slideshow, Input for Announcment)
									* Update Items: (Action: [updateContent, updateAddNew, updateDelete]; ContentType: [slideshow, announcements];)
										* Update Content (Both)
										* Add New Item (Both), (If Slideshow, Include File Upload)
										* Delete Item (Both)
									* Client Reload (Action: clientReload;)
								*/	
									//Get our $_GET or $_POST 'action'
									$action = $_REQUEST['action'] ?: NULL;

								switch ($action) {
									case 'showAll':
										$sql = ("SELECT * FROM `content` WHERE `ContentType` = '" . $_GET['contentType'] . "' ORDER BY `EndDate` DESC, `ContentID` ASC");
										$stm = $con->prepare($sql);
										$stm->execute();
										$records = $stm->fetchAll();
										echo "<p style='text-transform:uppercase;'>Editing " . $_GET['contentType'] . "</p>";
										echo "<table><tr><td>Name</td><td>Start Date</td><td>End Date</td><td>Edit</td><td>Delete</td></tr>";
										foreach($records as $row){
											echo "<tr";
												if($date >= $row['StartDate'] && $date <= $row['EndDate']){
													echo " style=color:red;";
												};
											echo "><td>";
											echo $row['Content'];
											echo "</td><td>";
											echo $row['StartDate'];
											echo "</td><td>";
											echo $row['EndDate'];
											echo "</td><td>";
											echo "<a href='admin.php?action=showIndividual&contentType=" . $_GET['contentType'] . "&ContentID=" . $row["ContentID"] . "'>Edit</a>";
											echo "</td><td>";
											echo "<a href='admin.php?action=deleteItem&ContentID=".$row['ContentID'];
												if($_GET['contentType'] == 'slideshow'){
													echo "&contentType=".$_GET['contentType']."&fileName=".$row['Content'];
												};
											echo "'>Delete</a>";
											echo "</td></tr>";
										};
										echo "</table><br />";
										echo "<a href='admin.php?action=showAddNew&contentType=" . $_GET['contentType'] . "'><button style='text-transform:uppercase;'>Add New " . $_GET['contentType'] . "</button></a><br />";
									break;

									case 'showIndividual':
										echo "<p style='text-transform:uppercase;'>Editing " . $_GET['contentType'] . "</p>";
										echo "<form action='admin.php' method='POST'>";
											$sql = ("SELECT * FROM `content` WHERE `ContentID` = '".$_GET['ContentID']."' ");
											$stm = $con->prepare($sql);
											$stm->execute();
											$records = $stm->fetchAll();
										foreach($records as $row){
											echo "<input type='hidden' name='action' value='updateContent'>";
											echo "<input type='hidden' name='ContentID' value='".$row['ContentID']."'>";
											echo "<p>Announcement/Image Name (If Unsure, Don't Edit):</p>";
											echo "<input type='text' name='Content' value='".$row['Content']."'><br />";
											echo "<p>Publish Start Date (YYYY-MM-DD):</p>";
											echo "<input type='text' name='StartDate' value='".$row['StartDate']."'><br />";
											echo "<p>Publish End Date (YYYY-MM-DD):</p>";
											echo "<input type='text' name='EndDate' value='".$row['EndDate']."'><br />";
											echo "<input type='submit' value='Submit'><br />";
										};
										echo "</form><br />";
										echo "<a href='admin.php?action=deleteItem&ContentID=".$_GET['ContentID'];
											if($_GET['contentType'] == 'slideshow'){
												echo "&contentType=".$_GET['contentType']."&fileName=".$row['Content'];
											}
										echo "'><button>Delete Item</button></a><br />";
									break;

									case 'showAddNew':
										echo "<p style='text-transform:uppercase;'>Add New ".$_GET['contentType']."</p>";
											echo "<form action='admin.php' enctype='multipart/form-data' method='POST'>";
												echo "<input type='hidden' name='action' value='updateAddNew'>";
												echo "<input type='hidden' name='contentType' value='".$_GET['contentType']."'>";
													if($_GET['contentType'] == 'announcement'){
														echo "<p>Announcement:</p><br />";
														echo "<input type='text' name='content' value=''><br />";
													} else if($_GET['contentType'] == 'slideshow'){
														echo "<p>Upload Image:</p>";
														echo "<input type='file' name='file' value=''><br /><br />";
													};
												echo "<p>Publish Start Date (YYYY-MM-DD):</p>";
												echo "<input type='text' name='StartDate' value=''><br />";
												echo "<p>Publish End Date (YYYY-MM-DD):</p>";
												echo "<input type='text' name='EndDate' value=''><br />";
												echo "<input type='submit' value='Submit'><br />";
											echo "</form>";
									break;
									
									case 'updateContent':
										//Reciving Data: ContentID, Content (Value), StartDate, EndDate
										$sql = "UPDATE `content` SET `Content` = '".$_POST['Content']."', `StartDate` = '".$_POST['StartDate']."', `EndDate` = '".$_POST['EndDate']."' WHERE `content`.`ContentID` = ".$_POST['ContentID'];
										$stm = $con->prepare($sql);
										$stm->execute();
										if($stm == true){
											header('Location: admin.php?msg=Content Update Success!');
										} else {
											header('Location: admin.php?msg=Error! Content Update Failure!');
										};
									break;

									case 'updateAddNew':											
										if($_POST['contentType'] == "slideshow"){
											//Need to upload file!
											$target_file = $slidesDirectory . basename($_FILES["file"]["name"]);
											
											//Set content name
											$content = basename($_FILES["file"]["name"]);

											// Check if file already exists
											if (file_exists($target_file)) {
											    header('Location: admin.php?msg=Error! Image with Name already Exists! Rename and Try again!');
											    exit();
											}

											//If not let's upload!
											if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
										        $uploadSuccess = true;
										    } else {
										        header('Location: admin.php?msg=Image Upload Error! Please Try again!');
											    exit();
										    }


										} else {
											$content = $_POST['content'];
										};

										//Add to MySQL DB!
										$sql = "INSERT INTO `content` (ContentType, Content, StartDate, EndDate) VALUES ('".$_POST['contentType']."', '".$content."','".$_POST['StartDate']."','".$_POST['EndDate']."')";
										$stm = $con->prepare($sql);
										$stm->execute();
										if($stm){
											header('Location: admin.php?msg=Content Add Success!');
										} else {
											header('Location: admin.php?msg=Error! Content Add Failure!');
										};
									
									break;

									case 'deleteItem':
										//If Slideshow, Delete file from Server
										if($_GET['contentType'] == "slideshow"){
											unlink($slidesDirectory . $_GET['fileName']);
										};

										$sql = "DELETE FROM `content` WHERE `ContentID` = ".$_GET['ContentID'];
										$stm = $con->prepare($sql);
										$stm->execute();
										if($stm == true){
											header('Location: admin.php?msg=Content Delete Success!');
										} else {
											header('Location: admin.php?msg=Error! Content Delete Failure!');
										};
									break;

									case 'clientReload':
										$file_data = "true";
										file_put_contents('reload.txt', $file_data);
										header('Location: admin.php?msg=Page Reload Sent!');
									break;

									default:
										echo "<p>Select Content to Edit!</p>";
										echo "<a href='admin.php?action=showAll&contentType=announcement'>
												<button>Announcements</button>
											  </a> | 
											  <a href='admin.php?action=showAll&contentType=slideshow'>
											  	<button>Slideshow</button>
											  </a> | 
											  <a href='admin.php?action=clientReload'>
											  	<button>Reload Screen</button>
											  </a><br />";
										break;
								}
							?>
						<hr />
						<a href="admin.php"><button>Admin Panel Home</button></a> | <a href="index.php"><button>View Screen</button></a>
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
