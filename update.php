<?php
include_once 'header.php';

//Load variables with data...
//Basic variables...
if ($_POST['inventory_id']){ $inventory_id = (int)$_POST['inventory_id'];}
if ($_POST['hw_type']){ $hw_type = $_POST['hw_type'];}
if ($_POST['common_name']){ $common_name = $_POST['common_name'];}
if ($_POST['sn']){ $sn = $_POST['sn'];}
if ($_POST['building']){ $building = $_POST['building'];}
if ($_POST['room']){ $room = strip_tags($_POST['room']);}
if ($_POST['purchase_date']){ $purchase_date = $_POST['purchase_date'];}
if ($_POST['warranty_expire']){	$warranty_expire = $_POST['warranty_expire'];}
if ($_POST['notes']){ $notes = $_POST['notes'];}
if ($_POST['action']){ $action = $_POST['action'];}
if ($_POST['delete']){ $delete = $_POST['delete'];}

//Computer only variables...
if ($_POST['assigned_pc']){	$assigned_pc = $_POST['assigned_pc'];}
if ($_POST['computer_model_id']){ $computer_model_id = $_POST['computer_model_id'];}

//Monitor only variables...
if ($_POST['monitor_model_id']){ $monitor_model_id = $_POST['monitor_model_id'];}

//Projector only variables...
if ($_POST['projector_model_id']){ $projector_model_id = $_POST['projector_model_id'];}

//Printer only variables...
if ($_POST['printer_model_id']){ $printer_model_id = $_POST['printer_model_id'];}

//Scanner only variables...
if ($_POST['scanner_model_id']){ $scanner_model_id = $_POST['scanner_model_id'];}


//Validate data...
//Verify the from field isn't blank...
$error = '';
//Verify the Name field isn't blank...
if ($common_name == '')
{
	$error = $error . '<li>Please enter the Common Name.<br>e.g.: E4500<br />';
}
//Verify the Serial Number field isn't blank...
if ($sn == '')
{
	$error = $error . '<li>Please enter the Serial Number.<br>e.g.: a2546<br />';
}
//Verify the building field isn't blank...
if ($building == '')
{
	$error = $error . '<li>Please select a building.<br>e.g.: High School<br />';
}
//Verify the room field isn't blank...
if ($room == '')
{
	$error = $error . '<li>Please enter a room.<br>e.g.: Office<br />';
}

//Verify that the sn is not a duplicate only on new items
if ($action == 'save')
{
	$sql_statement_sn = "SELECT inventory_id, sn FROM " . $db_table . " WHERE sn = '" . $sn . "'";

//Execute built query...
	$results_sn = mysql_query($sql_statement_sn) or die ('Error in ' . $sql_statement_sn . '. ' . mysql_error());	
	
//Check the results, if there is a record add it to the errors.
	if ($rs = mysql_fetch_array($results_sn)) 
	{
	$id = stripslashes($rs['inventory_id']);
	$error = $error . '<li>The serial number ' . $sn . ' already exists for hardware type ' . $hw_type . ' at inventory id: ' . $id . ' !!<br />';
	}	
}


//Display the error message if there is one...
if ($error)
{
?>
<br />
	<div data-role="header" data-theme="c" data-inline="true">
		<h6>Error Updating</h6>
	</div><!-- /header -->	
<br />
	An error has occurred while processing your command.<br />Please correct the problems below then resubmit your request.<br />

		<input type="button" value="Back" class="button" title="Go back" onClick="history.go(-1)">
<br />
<?php
	include_once 'footer.php';
	die;
}

//Process new inventory request...
if ($action == 'save')
{
	//Build SQL statement to save an inventory request...
	$sql_statement = "INSERT INTO " . $db_table . " (hw_type, common_name, sn, building, room, purchase_date, warranty_expire) VALUES ('" . $hw_type . "', '" . $common_name . "', '" . $sn . "', '" . $building . "', '" . $room . "', '" . $purchase_date . "', '" . $warranty_expire . "');";

	//Debugging...
	if ($debugging)
	{
		print 'DEBUG: ' . $sql_statement . '<br />';
	}
	//Execute the built query string
	$execute = mysql_query($sql_statement) or $error_message = "There was an error in your query " . mysql_error();
	
	//Get next id....
	$nextid = mysql_insert_id();
	
	switch ($hw_type) {
		case 'computer':
			//Build SQL statement to save a computer request...
			$sql_statement = "INSERT INTO computer (computer_model_id, assigned_pc, notes, inventory_id) VALUES ('" . $computer_model_id . "', '" . $assigned_pc . "', '" . $notes . "', '" . $nextid . "');";
		break;
		case 'scanner':
			//Build SQL statement to save a scanner request...
			$sql_statement = "INSERT INTO scanner (scanner_model_id, notes, inventory_id) VALUES ('" . $scanner_model_id . "', '" . $notes . "', '" . $nextid . "');";
		break;
		case 'monitor':
			//Build SQL statement to save a monitor request...
			$sql_statement = "INSERT INTO monitor (monitor_model_id, notes, inventory_id) VALUES ('" . $monitor_model_id . "', '" . $notes . "', '" . $nextid . "');";
		break;
		case 'projector':
			//Build SQL statement to save a projector request...
			$sql_statement = "INSERT INTO projector (projector_model_id, notes, inventory_id) VALUES ('" . $projector_model_id . "', '" . $notes . "', '" . $nextid . "');";	
		break;
		default:
			//Build SQL statement to save a printer request...
			$sql_statement = "INSERT INTO printer (printer_model_id, notes, inventory_id) VALUES ('" . $printer_model_id . "', '" . $notes . "', '" . $nextid . "');";	
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

//Process updated work order request...
if (($action == 'update') AND ($delete != 'yes'))
{
	//Build SQL statement to update inventory table...
	$sql_statement = "UPDATE " . $db_table . " SET common_name = '" . $common_name . "', sn = '" . $sn . "', building='" . 
	$building . "', room = '" . $room . "', purchase_date = '" . $purchase_date . "', warranty_expire = '" . $warranty_expire . "'";
	$sql_statement .= " WHERE inventory_id = " . $inventory_id . ";";

	//Debug...
	if ($debugging)
	{
		print 'DEBUG: ' . $sql_statement . '<br />';
	}
	
	//Execute the built query string
	$execute = mysql_query($sql_statement) or $error_message = "There was an error in your query " . mysql_error();
	
	
	switch ($hw_type) {
		case 'computer':
			//Build SQL statement to update computer table...
			$sql_statement = "UPDATE computer SET notes = '" . $notes . "', assigned_pc = '" . $assigned_pc . "', computer_model_id = '" . $computer_model_id . "'";
			$sql_statement .= " WHERE inventory_id = " . $inventory_id . ";";
		break;
		case 'scanner':
			//Build SQL statement to update scanner table...
			$sql_statement = "UPDATE scanner SET notes = '" . $notes . "', scanner_model_id = '" . $scanner_model_id . "'";
			$sql_statement .= " WHERE inventory_id = " . $inventory_id . ";";
		break;
		case 'monitor':
			//Build SQL statement to update monitor table...
			$sql_statement = "UPDATE monitor SET notes = '" . $notes . "', monitor_model_id = '" . $monitor_model_id . "'";
			$sql_statement .= " WHERE inventory_id = " . $inventory_id . ";";
		break;
		case 'projector':
			//Build SQL statement to update projector table...
			$sql_statement = "UPDATE projector SET notes = '" . $notes . "', projector_model_id = '" . $projector_model_id . "'";
			$sql_statement .= " WHERE inventory_id = " . $inventory_id . ";";
		break;
		default:
			//Build SQL statement to update printer table...
			$sql_statement = "UPDATE printer SET notes = '" . $notes . "', printer_model_id = '" . $printer_model_id . "'";
			$sql_statement .= " WHERE inventory_id = " . $inventory_id . ";";
		break;
	}
	
	//Debug...
	if ($debugging)
	{
		print 'DEBUG: ' . $sql_statement . '<br />';
	}
	
	//Execute the built query string
	$execute = mysql_query($sql_statement) or $error_message = "There was an error in your query " . mysql_error();

  }

//Process deleted work order request...
if (($action == 'update') AND ($delete == 'yes'))
{
	//Build SQL statement to delete a request...
	$sql_statement = 'DELETE FROM ' . $db_table . ' WHERE inventory_id = ' . $inventory_id;

	//Debug...
	if ($debugging)
	{
		print 'DEBUG: ' . $sql_statement . '<br />';
	}
	//Execute the built query string
	$execute = mysql_query($sql_statement) or $error_message = "There was an error in your query " . mysql_error();
	
	switch ($hw_type) {
		case 'computer':
			//Build SQL statement to delete a request...
			$sql_statement = 'DELETE FROM computer WHERE inventory_id = ' . $inventory_id;
		break;
		case 'scanner':
			//Build SQL statement to delete a request...
			$sql_statement = 'DELETE FROM scanner WHERE inventory_id = ' . $inventory_id;
		break;
		case 'monitor':
			//Build SQL statement to delete a request...
			$sql_statement = 'DELETE FROM monitor WHERE inventory_id = ' . $inventory_id;
		break;
		case 'projector':
			//Build SQL statement to delete a request...
			$sql_statement = 'DELETE FROM projector WHERE inventory_id = ' . $inventory_id;
		break;
		default:
			//Build SQL statement to delete a request...
			$sql_statement = 'DELETE FROM printer WHERE inventory_id = ' . $inventory_id;
		break;
	}	

	//Debug...
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
