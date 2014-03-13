<?php
$inventory_id=0;
include_once 'header.php';
if ($_POST['id']){ $id = $_POST['id'];}
if ($_GET['id']){ $id = $_GET['id'];}
if ($_POST['inventory_id']){ $inventory_id = $_POST['inventory_id'];}
if ($_GET['inventory_id']){	$inventory_id = $_GET['inventory_id'];}
if ($_POST['sn']){ $sn = $_POST['sn'];}
if ($_GET['sn']){ $sn = $_GET['sn'];}

if($_SESSION['id'] == 'ok')
{
	if ($inventory_id == 0)
	{
		$sql = 'SELECT inventory_id FROM ' . $db_table . ' WHERE sn LIKE "' . $sn . '"';
		
		//Debug...
		if ($debuging)
		{
			print '<b>DEBUG:</b> ' . $sql . '<p>';
		}
		
		$sqlresults = mysql_query($sql) or die ('Error in <b>' . $sql . '</b>. ' . mysql_error());
		if ($rs = mysql_fetch_row($sqlresults))
		{
			$inventory_id = $rs[0];
		}
	}
?>
<script language="JavaScript" type="text/javascript">
<!--
// IsNumeric Function
function IsNumeric(sText)
{
   var ValidChars = "0123456789";
   var IsNumber=true;
   var Char;


   for (i = 0; i < sText.length && IsNumber == true; i++)
      {
      Char = sText.charAt(i);
      if (ValidChars.indexOf(Char) == -1)
         {
         IsNumber = false;
         }
      }
   return IsNumber;

}

//<!--

// Email Validation Function
function validateEmail(sText) {
  var regex = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
  return regex.test(sText);
}

// Check the form
function checkForm () {
	TheForm = (document.edit)
	
	// Check for Common Name
	if (TheForm.common_name.value==""){
		alert("Please enter the Common Name.\ne.g.: E4500")
		TheForm.common_name.focus();
		return false;
	}
	
		// Check for Serial Number
	if (TheForm.sn.value==""){
		alert("Please enter the Serial Number.\ne.g.: a2431")
		TheForm.sn.focus();
		return false;
	}

	// Check to see that a Building has been selected
	if (TheForm.building.selectedIndex==0){
		alert("Please select a building.\ne.g.: High School")
		TheForm.building.focus();
		return false;
	}
	
	// Check for a Room
	if (TheForm.room.value==""){
		alert("Please enter a room.\ne.g.: 201")
		TheForm.room.focus();
		return false;
	}	
	
	// Check for a computer model id
	if (TheForm.computer_model_id.value==""){
		alert("Please enter a computer model.\ne.g. Gateway 4500")
		TheForm.computer_model_id.focus();
		return false;
	}

	return true
}
// -->
</script>
<div data-role="dialog">
	<div data-role="header" data-theme="a">
				<h1>Edit Record #<?php print $inventory_id?></h1>
		</div><!-- /header -->	
		<div data-role="content" class="mybg">
	
<?php
//Check for what type of hardware is being edited
$top_sql_statement = 'SELECT inventory.inventory_id, hw_type FROM ' . $db_table . ' WHERE inventory.inventory_id = ' . $inventory_id . '';

//Execute built query...
$top_results = mysql_query($top_sql_statement) or die ('Error in <b>' . $top_sql_statement . '</b>. ' . mysql_error());

//Debug...
if ($debuging)
{
	print '<b>DEBUG:</b> ' . $sql_statement . '<p>';
}

if ($rst = mysql_fetch_array($top_results))
{
	do
	{
		$hw_type = stripslashes($rst['hw_type']);
	}
	
	while ($rst = mysql_fetch_array($top_results));
	
	switch ($hw_type) {
			case 'computer':
					$sql_statement = 'SELECT inventory.inventory_id, hw_type, common_name, building, room, assigned_pc, purchase_date, warranty_expire, 
					sn, notes, computer.computer_model_id, manuf, model, processor, processor_speed, memory, HD_size, original_OS FROM ' . $db_table . ', computer, 
					computer_model WHERE inventory.inventory_id = computer.inventory_id and computer.computer_model_id = computer_model.computer_model_id and inventory.inventory_id = ' . $inventory_id . '';

					//Execute built query...
					$results = mysql_query($sql_statement) or die ('Error in <b>' . $sql_statement . '</b>. ' . mysql_error());

					//Debug...
					if ($debuging)
					{
						print '<b>DEBUG:</b> ' . $sql_statement . '<p>';
					}

					if ($rs = mysql_fetch_array($results))
					{
						do
						{
							$inventory_id = $rs['inventory_id'];	
							$hw_type = stripslashes($rs['hw_type']);	
							$common_name = $rs['common_name'];
							$building = stripslashes($rs['building']);
							$room = stripslashes($rs['room']);
							$assigned_pc = stripslashes($rs['assigned_pc']);
							$purchase_date = stripslashes($rs['purchase_date']);
							$warranty_expire = stripslashes($rs['warranty_expire']);
							$sn = $rs['sn'];
							$notes = stripslashes($rs['notes']);
							$computer_model_id = $rs['computer_model_id'];
							$manuf = stripslashes($rs['manuf']);
							$model = stripslashes($rs['model']);
							$processor = stripslashes($rs['processor']);
							$processor_speed = stripslashes($rs['processor_speed']);
							$memory = stripslashes($rs['memory']);
							$HD_size = stripslashes($rs['HD_size']);
							$original_OS = stripslashes($rs['original_OS']);
							
						} while ($rs = mysql_fetch_array($results));
					} else {
						print 'Sorry, can\'t locate computer #' . $inventory_id . '.<p>';
						include_once 'footer.php';
						die;
					}
					?>
					<form action="/helpdesk/new.php" method="post">
						<input type="hidden" name="building" value="<?php print $building?>">
						<input type="hidden" name="room" value="<?php print $room?>">
						<input type="hidden" name="item" value="<?php print $hw_type?> | <?php print $sn?>">
						<input type="submit" name="submit" class="button" value="Submit Workorder for this Item">
					</form>
					<form action="update.php" method="post" name="edit" onSubmit="return checkForm();">
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="inventory_id" value="<?php print $inventory_id?>" />

						<b>
							<br />
							<label for="basic">Inventory ID:</label>
								<label for="basic"><?php print $inventory_id?></label>
							<br />
							<label for="basic">Hardware Type:</label>
								<label for="basic"><?php print $hw_type?></label>
							<br />
							<br />
							<label for="basic">Common Name:</label>
								<input type="text" name="common_name" value="<?php print $common_name?>" maxlength="255" data-inline="true" />
							<label for="basic">Serial Number:</label>	
								<input type="text" name="sn" value="<?php print $sn?>" maxlength="255" data-inline="true" />
							<label for="basic">Building:</label>	
								<?php include_once 'common/buildings.inc.php';?>		
							<label for="basic">Room:</label>	
								<input type="text" name="room" value="<?php print $room?>" maxlength="255" data-inline="true" />	
							<label for="basic">Assigned PC:</label>	
								<select name="assigned_pc">
									<option <?php if ($assigned_pc == '0') print ' selected ';?> value="0">False</option>
									<option <?php if ($assigned_pc == '1') print ' selected ';?> value="1">True</option>
								</select>				
							<label for="basic">Purchase Date:</label>	
								<input type="date" name="purchase_date" value="<?php print $purchase_date?>" maxlength="255" data-inline="true" />				
							<label for="basic">Warranty Expires:</label>	
								<input type="date" name="warranty_expire" value="<?php print $warranty_expire?>" maxlength="255" data-inline="true" />	
							<label for="basic">Notes:</label>	
								<input type="text" name="notes" value="<?php print $notes?>" maxlength="255" data-inline="true" />	
							<label for="basic">Workorder History:</label>
							<br />
						</b>
								<?php
									//Create MySQL statement to populate workorder history
									$sql_statement = 'SELECT * FROM helpdesk.it_data WHERE item like "%'.$sn.'%"';
									$result = mysql_query($sql_statement);
									
									if ($rs = mysql_fetch_array($result, MYSQL_ASSOC))
									{											
										echo '<table align="center"><tr><td><u>Workorder #:</u> </td><td><u>Date Created:</u> </td><td><u>Technician:</u> </td></tr>';
										do
										{
											$id = $rs['id'];
											$created = $rs['created'];											
											$technician = $rs['assignedto'];
											
											echo '<tr><td><a href="/helpdesk/edit.php?id='.$id.'">'.$id.'</a></td><td>'.$created.'</td><td>'.$technician.'</td></tr>';	
										} while ($rs = mysql_fetch_array($result));
										echo '</table><br />';
									} else {
										echo '<label for="basic">No Reported Issues</label><br /><br />';
									}
								?>
						<b>
							<label for="basic">Computer Model:</label>	
								<?php
									//Create MySQL statement to populate hardware list
									$sql_statement_md = 'SELECT * FROM computer_model ORDER BY computer_model_id';

									//Execute built query...
									$results_md = mysql_query($sql_statement_md) or die ('Error in <b>' . $sql_statement_md . '</b>. ' . mysql_error());
										
									//create drop down list
									echo '<select name="computer_model_id">';
									echo "<option value=''>-Select Computer Model-</option>";
										
									 while($hw=mysql_fetch_array($results_md))
									{      
										
										if ($computer_model_id == $hw['computer_model_id'])
										{	
											echo '<option selected value="' .$hw['computer_model_id']. '" >'.$hw['computer_model_id']. ' | ' .$hw['model']. ' | ' .$hw['manuf'].'</option>';
										}
										else
										{
											echo '<option value="' .$hw['computer_model_id']. '" >'.$hw['computer_model_id']. ' | ' .$hw['model']. ' | ' .$hw['manuf'].'</option>';
										}
											
									} 
									echo "</select>";
										
								?>	
								<label for="basic">Delete this item?</label>
								<select name="delete">
									<option value="no">No</option>
									<option value="yes">Yes</option>
								</select>	
							</b>			
							
							<span data-mini="true">
								<input type="button" value="Back" class="button" title="Go back" onclick="javascript:location.href='index.php'" data-inline="true" data-theme="c">
								<input type="submit" name="Update" value="Update" class="button" title="Update inventory item" data-inline="true" >	
							</span>
					</form>
					<?php
			break;
			case 'monitor':
					$sql_statement = 'SELECT inventory.inventory_id, hw_type, common_name, building, room, purchase_date, warranty_expire, 
					sn, notes, monitor.monitor_model_id, manuf, model FROM ' . $db_table . ', monitor, 
					monitor_model WHERE inventory.inventory_id = monitor.inventory_id and monitor.monitor_model_id = monitor_model.monitor_model_id and monitor.inventory_id = ' . $inventory_id . '';

					//Execute built query...
					$results = mysql_query($sql_statement) or die ('Error in <b>' . $sql_statement . '</b>. ' . mysql_error());

					//Debug...
					if ($debuging)
					{
						print '<b>DEBUG:</b> ' . $sql_statement . '<p>';
					}

					if ($rs = mysql_fetch_array($results))
					{
						do
						{
							$inventory_id = $rs['inventory_id'];	
							$hw_type = stripslashes($rs['hw_type']);	
							$common_name = $rs['common_name'];
							$building = stripslashes($rs['building']);
							$room = stripslashes($rs['room']);
							$purchase_date = stripslashes($rs['purchase_date']);
							$warranty_expire = stripslashes($rs['warranty_expire']);
							$sn = $rs['sn'];
							$notes = stripslashes($rs['notes']);
							$monitor_model_id = $rs['monitor_model_id'];
							$manuf = stripslashes($rs['manuf']);
							$model = stripslashes($rs['model']);
							
						} while ($rs = mysql_fetch_array($results));
							echo '</table>';
					} else {
						print 'Sorry, can\'t locate monitor #' . $inventory_id . '.<p>';
						include_once 'footer.php';
						die;
					}
					?>
					<form action="/helpdesk/new.php" method="post">
						<input type="hidden" name="building" value="<?php print $building?>">
						<input type="hidden" name="room" value="<?php print $room?>">
						<input type="hidden" name="item" value="<?php print $hw_type?> | <?php print $sn?>">
						<input type="submit" name="submit" class="button" value="Submit Workorder for this Item">
					</form>					
					<form action="update.php" method="post" name="edit" onSubmit="return checkForm();">
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="inventory_id" value="<?php print $inventory_id?>" />

						<b>
							<br />
							<label for="basic">Inventory ID:</label>
								<label for="basic"><?php print $inventory_id?></label>
							<br />
							<label for="basic">Hardware Type:</label>
								<label for="basic"><?php print $hw_type?></label>
							<br />
							<br />
							<label for="basic">Common Name:</label>
								<input type="text" name="common_name" value="<?php print $common_name?>" maxlength="255" data-inline="true" />
							<label for="basic">Serial Number:</label>	
								<input type="text" name="sn" value="<?php print $sn?>" maxlength="255" data-inline="true" />
							<label for="basic">Building:</label>	
								<?php include_once 'common/buildings.inc.php';?>		
							<label for="basic">Room:</label>	
								<input type="text" name="room" value="<?php print $room?>" maxlength="255" data-inline="true" />			
							<label for="basic">Purchase Date:</label>	
								<input type="date" name="purchase_date" value="<?php print $purchase_date?>" maxlength="255" data-inline="true" />				
							<label for="basic">Warranty Expires:</label>	
								<input type="date" name="warranty_expire" value="<?php print $warranty_expire?>" maxlength="255" data-inline="true" />	
							<label for="basic">Notes:</label>	
								<input type="text" name="notes" value="<?php print $notes?>" maxlength="255" data-inline="true" />	
							<label for="basic">Workorder History:</label>
							<br />
							</b>
								<?php
									//Create MySQL statement to populate workorder history
									$sql_statement = 'SELECT * FROM helpdesk.it_data WHERE item like "%'.$sn.'%"';
									$result = mysql_query($sql_statement);
									
									if ($rs = mysql_fetch_array($result, MYSQL_ASSOC))
									{											
										echo '<table align="center"><tr><td><u>Workorder #:</u> </td><td><u>Date Created:</u> </td><td><u>Technician:</u> </td></tr>';
										do
										{
											$id = $rs['id'];
											$created = $rs['created'];											
											$technician = $rs['assignedto'];
											
											echo '<tr><td><a href="/helpdesk/edit.php?id='.$id.'">'.$id.'</a></td><td>'.$created.'</td><td>'.$technician.'</td></tr>';	
										} while ($rs = mysql_fetch_array($result));
										echo '</table><br />';
									} else {
										echo '<label for="basic">No Reported Issues</label><br /><br />';
									}
								?>
						<b>								
							<label for="basic">Monitor Model:</label>	
									<?php
									//Create MySQL statement to populate hardware list
									$sql_statement_md = 'SELECT * FROM monitor_model ORDER BY monitor_model_id';

									//Execute built query...
									$results_md = mysql_query($sql_statement_md) or die ('Error in <b>' . $sql_statement_md . '</b>. ' . mysql_error());
									
									//create drop down list
									echo '<select name="monitor_model_id">';
									echo "<option value=''>-Select Monitor Model-</option>";
									
									 while($hw=mysql_fetch_array($results_md))
									{      
									
										if ($monitor_model_id == $hw['monitor_model_id'])
										{	
											echo '<option selected value="' .$hw['monitor_model_id']. '" >'.$hw['monitor_model_id']. ' | ' .$hw['model']. ' | ' .$hw['manuf'].'</option>';
										}
										else
										{
											echo '<option value="' .$hw['monitor_model_id']. '" >'.$hw['monitor_model_id']. ' | ' .$hw['model']. ' | ' .$hw['manuf'].'</option>';
										}
										
									} 
									echo "</select>";
									
									?>
								<label for="basic">Delete this item?</label>
								<select name="delete">
									<option value="no">No</option>
									<option value="yes">Yes</option>
								</select>	
							</b>			
							
							<span data-mini="true">
								<input type="button" value="Back" class="button" title="Go back" onclick="javascript:location.href='index.php'" data-inline="true" data-theme="c">
								<input type="submit" name="Update" value="Update" class="button" title="Update inventory item" data-inline="true" >	
							</span>
					</form>
					<?php
			break;
			case 'printer':
					$sql_statement = 'SELECT inventory.inventory_id, hw_type, common_name, building, room, purchase_date, warranty_expire, 
					sn, notes, printer.printer_model_id, manuf, model FROM ' . $db_table . ', printer, 
					printer_model WHERE inventory.inventory_id = printer.inventory_id and printer.printer_model_id = printer.printer_model_id and printer.inventory_id = ' . $inventory_id . '';

					//Execute built query...
					$results = mysql_query($sql_statement) or die ('Error in <b>' . $sql_statement . '</b>. ' . mysql_error());

					//Debug...
					if ($debuging)
					{
						print '<b>DEBUG:</b> ' . $sql_statement . '<p>';
					}

					if ($rs = mysql_fetch_array($results))
					{
						do
						{
							$inventory_id = $rs['inventory_id'];	
							$hw_type = stripslashes($rs['hw_type']);	
							$common_name = $rs['common_name'];
							$building = stripslashes($rs['building']);
							$room = stripslashes($rs['room']);
							$purchase_date = stripslashes($rs['purchase_date']);
							$warranty_expire = stripslashes($rs['warranty_expire']);
							$sn = $rs['sn'];
							$notes = stripslashes($rs['notes']);
							$printer_model_id = $rs['printer_model_id'];
							$manuf = stripslashes($rs['manuf']);
							$model = stripslashes($rs['model']);
							
						} while ($rs = mysql_fetch_array($results));
							echo '</table>';
					} else {
						print 'Sorry, can\'t locate printer #' . $inventory_id . '.<p>';
						include_once 'footer.php';
						die;
					}
					?>
					<form action="/helpdesk/new.php" method="post">
						<input type="hidden" name="building" value="<?php print $building?>">
						<input type="hidden" name="room" value="<?php print $room?>">
						<input type="hidden" name="item" value="<?php print $hw_type?> | <?php print $sn?>">
						<input type="submit" name="submit" class="button" value="Submit Workorder for this Item">
					</form>					
					<form action="update.php" method="post" name="edit" onSubmit="return checkForm();">
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="inventory_id" value="<?php print $inventory_id?>" />

						<b>
							<br />
							<label for="basic">Inventory ID:</label>
								<label for="basic"><?php print $inventory_id?></label>
							<br />
							<label for="basic">Hardware Type:</label>
								<label for="basic"><?php print $hw_type?></label>
							<br />
							<br />
							<label for="basic">Common Name:</label>
								<input type="text" name="common_name" value="<?php print $common_name?>" maxlength="255" data-inline="true" />
							<label for="basic">Serial Number:</label>	
								<input type="text" name="sn" value="<?php print $sn?>" maxlength="255" data-inline="true" />
							<label for="basic">Building:</label>	
								<?php include_once 'common/buildings.inc.php';?>		
							<label for="basic">Room:</label>	
								<input type="text" name="room" value="<?php print $room?>" maxlength="255" data-inline="true" />			
							<label for="basic">Purchase Date:</label>	
								<input type="date" name="purchase_date" value="<?php print $purchase_date?>" maxlength="255" data-inline="true" />				
							<label for="basic">Warranty Expires:</label>	
								<input type="date" name="warranty_expire" value="<?php print $warranty_expire?>" maxlength="255" data-inline="true" />	
							<label for="basic">Notes:</label>	
								<input type="text" name="notes" value="<?php print $notes?>" maxlength="255" data-inline="true" />	
							<label for="basic">Workorder History:</label>
							<br />
							</b>
								<?php
									//Create MySQL statement to populate workorder history
									$sql_statement = 'SELECT * FROM helpdesk.it_data WHERE item like "%'.$sn.'%"';
									$result = mysql_query($sql_statement);
									
									if ($rs = mysql_fetch_array($result, MYSQL_ASSOC))
									{											
										echo '<table align="center"><tr><td><u>Workorder #:</u> </td><td><u>Date Created:</u> </td><td><u>Technician:</u> </td></tr>';
										do
										{
											$id = $rs['id'];
											$created = $rs['created'];											
											$technician = $rs['assignedto'];
											
											echo '<tr><td><a href="/helpdesk/edit.php?id='.$id.'">'.$id.'</a></td><td>'.$created.'</td><td>'.$technician.'</td></tr>';	
										} while ($rs = mysql_fetch_array($result));
										echo '</table><br />';
									} else {
										echo '<label for="basic">No Reported Issues</label><br /><br />';
									}
								?>
						<b>								
							<label for="basic">Printer Model:</label>
									<?php
									//Create MySQL statement to populate hardware list
									$sql_statement_md = 'SELECT * FROM printer_model ORDER BY printer_model_id';

									//Execute built query...
									$results_md = mysql_query($sql_statement_md) or die ('Error in <b>' . $sql_statement_md . '</b>. ' . mysql_error());
									
									//create drop down list
									echo '<select name="printer_model_id">';
									echo "<option value=''>-Select Printer Model-</option>";
									
									 while($hw=mysql_fetch_array($results_md))
									{      
									
										if ($printer_model_id == $hw['printer_model_id'])
										{	
											echo '<option selected value="' .$hw['printer_model_id']. '" >'.$hw['printer_model_id']. ' | ' .$hw['model']. ' | ' .$hw['manuf'].'</option>';
										}
										else
										{
											echo '<option value="' .$hw['printer_model_id']. '" >'.$hw['printer_model_id']. ' | ' .$hw['model']. ' | ' .$hw['manuf'].'</option>';
										}
										
									} 
									echo "</select>";
									
									?>
								<label for="basic">Delete this item?</label>
								<select name="delete">
									<option value="no">No</option>
									<option value="yes">Yes</option>
								</select>	
							</b>			
							
							<span data-mini="true">
								<input type="button" value="Back" class="button" title="Go back" onclick="javascript:location.href='index.php'" data-inline="true" data-theme="c">
								<input type="submit" name="Update" value="Update" class="button" title="Update inventory item" data-inline="true" >	
							</span>
					</form>
					<?php							
			break;
			case 'scanner':
				$sql_statement = 'SELECT inventory.inventory_id, hw_type, common_name, building, room, purchase_date, warranty_expire, 
				sn, notes, scanner.scanner_model_id, manuf, model FROM ' . $db_table . ', scanner, 
				scanner_model WHERE inventory.inventory_id = scanner.inventory_id and scanner.scanner_model_id = scanner_model.scanner_model_id and inventory.inventory_id = ' . $inventory_id . '';

				//Execute built query...
				$results = mysql_query($sql_statement) or die ('Error in <b>' . $sql_statement . '</b>. ' . mysql_error());

				//Debug...
				if ($debuging)
				{
					print '<b>DEBUG:</b> ' . $sql_statement . '<p>';
				}

				if ($rs = mysql_fetch_array($results))
				{
					do
					{
						$inventory_id = $rs['inventory_id'];	
						$hw_type = stripslashes($rs['hw_type']);	
						$common_name = $rs['common_name'];
						$building = stripslashes($rs['building']);
						$room = stripslashes($rs['room']);
						$purchase_date = stripslashes($rs['purchase_date']);
						$warranty_expire = stripslashes($rs['warranty_expire']);
						$sn = $rs['sn'];
						$notes = stripslashes($rs['notes']);
						$scanner_model_id = $rs['scanner_model_id'];
						$manuf = stripslashes($rs['manuf']);
						$model = stripslashes($rs['model']);
						
					} while ($rs = mysql_fetch_array($results));
						echo '</table>';
				} else {
					print 'Sorry, can\'t locate work order #' . $inventory_id . '.<p>';
					include_once 'common/footer.inc.php';
					die;
				}
				?>
					<form action="/helpdesk/new.php" method="post">
						<input type="hidden" name="building" value="<?php print $building?>">
						<input type="hidden" name="room" value="<?php print $room?>">
						<input type="hidden" name="item" value="<?php print $hw_type?> | <?php print $sn?>">
						<input type="submit" name="submit" class="button" value="Submit Workorder for this Item">
					</form>				
					<form action="update.php" method="post" name="edit" onSubmit="return checkForm();">
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="inventory_id" value="<?php print $inventory_id?>" />

						<b>
							<br />
							<label for="basic">Inventory ID:</label>
								<label for="basic"><?php print $inventory_id?></label>
							<br />
							<label for="basic">Hardware Type:</label>
								<label for="basic"><?php print $hw_type?></label>
							<br />
							<br />
							<label for="basic">Common Name:</label>
								<input type="text" name="common_name" value="<?php print $common_name?>" maxlength="255" data-inline="true" />
							<label for="basic">Serial Number:</label>	
								<input type="text" name="sn" value="<?php print $sn?>" maxlength="255" data-inline="true" />
							<label for="basic">Building:</label>	
								<?php include_once 'common/buildings.inc.php';?>		
							<label for="basic">Room:</label>	
								<input type="text" name="room" value="<?php print $room?>" maxlength="255" data-inline="true" />			
							<label for="basic">Purchase Date:</label>	
								<input type="date" name="purchase_date" value="<?php print $purchase_date?>" maxlength="255" data-inline="true" />				
							<label for="basic">Warranty Expires:</label>	
								<input type="date" name="warranty_expire" value="<?php print $warranty_expire?>" maxlength="255" data-inline="true" />	
							<label for="basic">Notes:</label>	
								<input type="text" name="notes" value="<?php print $notes?>" maxlength="255" data-inline="true" />	
							<label for="basic">Workorder History:</label>
							<br />
							</b>
								<?php
									//Create MySQL statement to populate workorder history
									$sql_statement = 'SELECT * FROM helpdesk.it_data WHERE item like "%'.$sn.'%"';
									$result = mysql_query($sql_statement);
									
									if ($rs = mysql_fetch_array($result, MYSQL_ASSOC))
									{											
										echo '<table align="center"><tr><td><u>Workorder #:</u> </td><td><u>Date Created:</u> </td><td><u>Technician:</u> </td></tr>';
										do
										{
											$id = $rs['id'];
											$created = $rs['created'];											
											$technician = $rs['assignedto'];
											
											echo '<tr><td><a href="/helpdesk/edit.php?id='.$id.'">'.$id.'</a></td><td>'.$created.'</td><td>'.$technician.'</td></tr>';	
										} while ($rs = mysql_fetch_array($result));
										echo '</table><br />';
									} else {
										echo '<label for="basic">No Reported Issues</label><br /><br />';
									}
								?>
						<b>
							<label for="basic">Scanner Model:</label>
								<?php		
								//Create MySQL statement to populate hardware list
								$sql_statement_md = 'SELECT * FROM scanner_model ORDER BY scanner_model_id';

								//Execute built query...
								$results_md = mysql_query($sql_statement_md) or die ('Error in <b>' . $sql_statement_md . '</b>. ' . mysql_error());
								
								//create drop down list
								echo '<select name="scanner_model_id">';
								echo "<option value=''>-Select Scanner Model-</option>";
								
								 while($hw=mysql_fetch_array($results_md))
								{      
								
									if ($scanner_model_id == $hw['scanner_model_id'])
									{	
										echo '<option selected value="' .$hw['scanner_model_id']. '" >'.$hw['scanner_model_id']. ' | ' .$hw['model']. ' | ' .$hw['manuf'].'</option>';
									}
									else
									{
										echo '<option value="' .$hw['scanner_model_id']. '" >'.$hw['scanner_model_id']. ' | ' .$hw['model']. ' | ' .$hw['manuf'].'</option>';
									}
									
								} 
								echo "</select>";
								
								?>
								<label for="basic">Delete this item?</label>
								<select name="delete">
									<option value="no">No</option>
									<option value="yes">Yes</option>
								</select>	
							</b>			
							
							<span data-mini="true">
								<input type="button" value="Back" class="button" title="Go back" onclick="javascript:location.href='index.php'" data-inline="true" data-theme="c">
								<input type="submit" name="Update" value="Update" class="button" title="Update inventory item" data-inline="true" >	
							</span>
					</form>
					<?php	
			break;
			default:
					$sql_statement = 'SELECT inventory.inventory_id, hw_type, common_name, building, room, purchase_date, warranty_expire, 
					sn, notes, projector.projector_model_id, manuf, model FROM ' . $db_table . ', projector, 
					projector_model WHERE inventory.inventory_id = projector.inventory_id and projector.projector_model_id = projector_model.projector_model_id and inventory.inventory_id = ' . $inventory_id . '';

					//Execute built query...
					$results = mysql_query($sql_statement) or die ('Error in <b>' . $sql_statement . '</b>. ' . mysql_error());

					//Debug...
					if ($debuging)
					{
						print '<b>DEBUG:</b> ' . $sql_statement . '<p>';
					}

					if ($rs = mysql_fetch_array($results))
					{
						do
						{
							$inventory_id = $rs['inventory_id'];	
							$hw_type = stripslashes($rs['hw_type']);	
							$common_name = $rs['common_name'];
							$building = stripslashes($rs['building']);
							$room = stripslashes($rs['room']);
							$purchase_date = stripslashes($rs['purchase_date']);
							$warranty_expire = stripslashes($rs['warranty_expire']);
							$sn = $rs['sn'];
							$notes = stripslashes($rs['notes']);
							$projector_model_id = $rs['projector_model_id'];
							$manuf = stripslashes($rs['manuf']);
							$model = stripslashes($rs['model']);
							
						} while ($rs = mysql_fetch_array($results));
							echo '</table>';
					} else {
						print 'Sorry, can\'t locate work order #' . $inventory_id . '.<p>';
						include_once 'common/footer.inc.php';
						die;
					}
					?>
					<form action="/helpdesk/new.php" method="post">
						<input type="hidden" name="building" value="<?php print $building?>">
						<input type="hidden" name="room" value="<?php print $room?>">
						<input type="hidden" name="item" value="<?php print $hw_type?> | <?php print $sn?>">
						<input type="submit" name="submit" class="button" value="Submit Workorder for this Item">
					</form>					
					<form action="update.php" method="post" name="edit" onSubmit="return checkForm();">
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="inventory_id" value="<?php print $inventory_id?>" />

						<b>
							<br />
							<label for="basic">Inventory ID:</label>
								<label for="basic"><?php print $inventory_id?></label>
							<br />
							<label for="basic">Hardware Type:</label>
								<label for="basic"><?php print $hw_type?></label>
							<br />
							<br />
							<label for="basic">Common Name:</label>
								<input type="text" name="common_name" value="<?php print $common_name?>" maxlength="255" data-inline="true" />
							<label for="basic">Serial Number:</label>	
								<input type="text" name="sn" value="<?php print $sn?>" maxlength="255" data-inline="true" />
							<label for="basic">Building:</label>	
								<?php include_once 'common/buildings.inc.php';?>		
							<label for="basic">Room:</label>	
								<input type="text" name="room" value="<?php print $room?>" maxlength="255" data-inline="true" />			
							<label for="basic">Purchase Date:</label>	
								<input type="date" name="purchase_date" value="<?php print $purchase_date?>" maxlength="255" data-inline="true" />				
							<label for="basic">Warranty Expires:</label>	
								<input type="date" name="warranty_expire" value="<?php print $warranty_expire?>" maxlength="255" data-inline="true" />	
							<label for="basic">Notes:</label>	
								<input type="text" name="notes" value="<?php print $notes?>" maxlength="255" data-inline="true" />
							<label for="basic">Workorder History:</label>
							<br />
							</b>
								<?php
									//Create MySQL statement to populate workorder history
									$sql_statement = 'SELECT * FROM helpdesk.it_data WHERE item like "%'.$sn.'%"';
									$result = mysql_query($sql_statement);
									
									if ($rs = mysql_fetch_array($result, MYSQL_ASSOC))
									{											
										echo '<table align="center"><tr><td><u>Workorder #:</u> </td><td><u>Date Created:</u> </td><td><u>Technician:</u> </td></tr>';
										do
										{
											$id = $rs['id'];
											$created = $rs['created'];											
											$technician = $rs['assignedto'];
											
											echo '<tr><td><a href="/helpdesk/edit.php?id='.$id.'">'.$id.'</a></td><td>'.$created.'</td><td>'.$technician.'</td></tr>';	
										} while ($rs = mysql_fetch_array($result));
										echo '</table><br />';
									} else {
										echo '<label for="basic">No Reported Issues</label><br /><br />';
									}
								?>
						<b>
							<label for="basic">Projector Model:</label>			
								<?php
								//Create MySQL statement to populate hardware list
								$sql_statement_md = 'SELECT * FROM projector_model ORDER BY projector_model_id';

								//Execute built query...
								$results_md = mysql_query($sql_statement_md) or die ('Error in <b>' . $sql_statement_md . '</b>. ' . mysql_error());
								
								//create drop down list
								echo '<select name="projector_model_id">';
								echo "<option value=''>-Select Projector Model-</option>";
								
								 while($hw=mysql_fetch_array($results_md))
								{      
								
									if ($projector_model_id == $hw['projector_model_id'])
									{	
										echo '<option selected value="' .$hw['projector_model_id']. '" >'.$hw['projector_model_id']. ' | ' .$hw['model']. ' | ' .$hw['manuf'].'</option>';
									}
									else
									{
										echo '<option value="' .$hw['projector_model_id']. '" >'.$hw['projector_model_id']. ' | ' .$hw['model']. ' | ' .$hw['manuf'].'</option>';
									}
									
								} 
								echo "</select>";
								
								?>		
								<label for="basic">Delete this item?</label>
								<select name="delete">
									<option value="no">No</option>
									<option value="yes">Yes</option>
								</select>	
							</b>			
							
							<span data-mini="true">
								<input type="button" value="Back" class="button" title="Go back" onclick="javascript:location.href='index.php'" data-inline="true" data-theme="c">
								<input type="submit" name="Update" value="Update" class="button" title="Update inventory item" data-inline="true" >	
							</span>
					</form>
					<?php									
			break;	
		}

} else {
	print 'Sorry, can\'t locate inventory ID #' . $inventory_id . '.<p>';
	include_once 'footer.php';
	die;
}	
?>
</div>
<?php
} elseif ($inventory_id != 0) {
?>
<div data-role="dialog">
	<div data-role="header" data-theme="a">
				<h1>You're Not Logged in!</h1>
		</div><!-- /header -->	
		<div data-role="content">
	<p>Incorrect!</p>
		<script language="javascript"><!--
		location.replace("mobilelogin.php?inventory_id=<?php print $inventory_id;?>")
		//-->
		</script>
	</div>
	</div>
<?
} elseif ($sn) {
?>
<div data-role="dialog">
	<div data-role="header" data-theme="a">
				<h1>You're Not Logged in!</h1>
		</div><!-- /header -->	
		<div data-role="content">
	<p>Incorrect!</p>
		<script language="javascript"><!--
		location.replace("mobilelogin.php?sn=<?php print $sn;?>")
		//-->
		</script>
	</div>
	</div>
<?
}
include_once 'footer.php';
?>
