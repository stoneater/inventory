<?php
include_once 'header.php';

//Load variables with data...
//Basic variables...
if ($_POST['hw_type']){ $hw_type = $_POST['hw_type'];}
if ($_POST['manufacturer']){ $manufacturer = $_POST['manufacturer'];}
if ($_POST['model']){ $model = $_POST['model'];}
if ($_POST['type']){ $type = $_POST['type'];}

if ($_POST['action']){ $action = $_POST['action'];}

//Computer only variables...
if ($_POST['processor']){ $processor = $_POST['processor'];}
if ($_POST['processor_speed']){ $processor_speed = $_POST['processor_speed'];}
if ($_POST['memory']){ $memory = $_POST['memory'];}
if ($_POST['hard_drive_size']){	$hard_drive_size = $_POST['hard_drive_size'];}
if ($_POST['original_os']){ $original_os = $_POST['original_os'];}

//Monitor only variables...
if ($_POST['size']){ $size = $_POST['size'];}


//Process new inventory request...
if ($action == 'save')
{
	switch ($hw_type) {
		case 'computer':
			//Build SQL statement to save a computer request...
			$sql_statement = "INSERT INTO computer_model (manuf, model, processor, processor_speed, memory, HD_size, original_OS) VALUES ('" . $manufacturer . "', '" . $model . "', '" . $processor . "', '" . $processor_speed . "', '" . $memory . "', '" . $hard_drive_size . "', '" . $original_os . "');";
		break;
		case 'scanner':
			//Build SQL statement to save a scanner request...
			$sql_statement = "INSERT INTO scanner_model (manuf, model) VALUES ('" . $manufacturer . "', '" . $model . "');";
		break;
		case 'monitor':
			//Build SQL statement to save a monitor request...
			$sql_statement = "INSERT INTO monitor_model (manuf, model, type, size) VALUES ('" . $manufacturer . "', '" . $model . "', '" . $type . "', '" . $size . "');";
		break;
		case 'projector':
			//Build SQL statement to save a projector request...
			$sql_statement = "INSERT INTO projector_model (manuf, model) VALUES ('" . $manufacturer . "', '" . $model . "');";	
		break;
		default:
			//Build SQL statement to save a printer request...
			$sql_statement = "INSERT INTO printer_model (manuf, model, type) VALUES ('" . $manufacturer . "', '" . $model . "', '" . $type . "');";	
		break;
	}
	//Debugging...
	if ($debugging)
	{
		print 'DEBUG: ' . $sql_statement . '<br />';
	}
	//Execute the built query string
	$execute = mysql_query($sql_statement) or $error_message = "There was an error in your query " . mysql_error();

 }
if (!$execute)
{
?>
<div data-role="dialog" class="type-interior">
	<div data-role="header" data-theme="a">
		<h1>Error Updating</h1>
		<a href="#" data-icon="home" data-iconpos="notext" data-direction="reverse" onclick="history.go(-1)">Back</a>
	</div><!-- /header -->	
<br />
<div data-role="content">
<?php print $error_message?>
</div>
</div>
<?php
} else {
?>
<div data-role="dialog" class="type-interior">
	<div data-role="header" data-theme="a">
		<h1>Item Updated!!</h1>
	</div><!-- /header -->	
<br />
<div data-role="content">
<meta http-equiv="REFRESH" content="3; url=index.php">
Your Inventory Item has been updated successfully. <?php print $nextid ?><br />
</div>
</div>
<?php
}

include_once 'common/dbclose.inc.php';
include_once 'footer.php';
include_once 'common/end.inc.php';
?> 
