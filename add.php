<?php
include_once 'header.php';

if ($_POST['hw_type']){ $hardware = $_POST['hw_type'];}

if($_SESSION['id'] == 'ok'){
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

// Email Validation Function
function validateEmail(sText) {
  var regex = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
  return regex.test(sText);
}

// Check the form
function checkForm () {
	TheForm = (document.add)
	// Check for Common Name
	if (TheForm.common_name.value==""){
		alert("Please enter the Common Name.\ne.g.: HS-Tech-99")
		TheForm.common_name.focus();
		return false;
	}
	
		// Check for Serial Number
	if (TheForm.sn.value==""){
		alert("Please enter the Serial Number.\ne.g.: a2431")
		TheForm.sn.focus();
		return false;
	}
	
	// Check to see that a building has been selected
	if (TheForm.building.selectedIndex==0){
		alert("Please select a building.\ne.g.: High School")
		TheForm.building.focus();
		return false;
	}
	
	// Check for a room
	if (TheForm.room.value==""){
		alert("Please enter a room.\ne.g.: Office")
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
<?php 
switch ($hardware) {
	case 'computer':
		?>
		<div data-role="header" data-theme="a">
				<h1>Add Computer</h1>
		</div><!-- /header -->	
		<div data-role="content" class="mybg">
		<label for="basic"><b>Fill out the form, then click submit:</b></label>
		<br />
		<br />
		<form action="update.php" method="post" name="add" onSubmit="return checkForm();">
			<input type="hidden" name="action" value="save">
			<input type="hidden" name="hw_type" value="computer">
			<label for="basic"><b>Hardware Type:</b></label>
				<label for="basic"><?php print "computer"?></label>
			<br />
			<br />
			<label for="basic"><b>Common Name:</b></label>
				<input type="text" name="common_name" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Serial Number:</b></label>
				<input type="text" name="sn" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Building:</b></label>
				<?php include_once 'common/buildings.inc.php';?>
			<label for="basic"><b>Room:</b></label>
				<input type="text" name="room" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Assigned PC:</b></label>
				<select name="assigned_pc">
					<option selected value="0">False</option>
					<option value="1">True</option>
				</select>
			<label for="basic"><b>Purchase Date:</b></label>
				<input type="date" name="purchase_date" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Warranty Expires:</b></label>
				<input type="date" name="warranty_expire" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Computer Model:</b></label>
				<?php
				//Create MySQL statement to populate hardware list
				$sql_statement_md = 'SELECT * FROM computer_model ORDER BY computer_model_id';

				//Execute built query...
				$results_md = mysql_query($sql_statement_md) or die ('Error in <b>' . $sql_statement_md . '</b>. ' . mysql_error());
				
				//create drop down list
				echo '<select name="computer_model_id">';
				echo "<option selected value='99'>-Select Computer Model-</option>";

				while($hw=mysql_fetch_array($results_md))
				{      

					echo '<option value="'.$hw['computer_model_id'].'" selected>'.$hw['model']. ' | ' .$hw['manuf'].'</option>';
					
				}
				echo "</select>";
			?>
			<label for="basic"><b>Notes:</b></label>
				<input type="text" name="notes" value="" data-mini="true" maxlength="255" />
		<?php
	break;
	case 'monitor':
		?>
		<div data-role="header" data-theme="a">
				<h1>Add Monitor</h1>
		</div><!-- /header -->	
		<div data-role="content">
		<label for="basic"><b>Fill out the form, then click submit:</b></label>
		<br />
		<br />
		<form action="update.php" method="post" name="add" onSubmit="return checkForm();">
			<input type="hidden" name="action" value="save">
			<input type="hidden" name="hw_type" value="monitor">
			<label for="basic"><b>Hardware Type:</b></label>
				<label for="basic"><?php print "monitor"?></label>
			<br />
			<br />
			<label for="basic"><b>Common Name:</b></label>
				<input type="text" name="common_name" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Serial Number:</b></label>
				<input type="text" name="sn" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Building:</b></label>
				<?php include_once 'common/buildings.inc.php';?>
			<label for="basic"><b>Room:</b></label>
				<input type="text" name="room" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Purchase Date:</b></label>
				<input type="date" name="purchase_date" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Warranty Expires:</b></label>
				<input type="date" name="warranty_expire" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Monitor Model:</b></label>
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

					echo '<option value="'.$hw['monitor_model_id'].'" selected>'.$hw['model']. ' | ' .$hw['manuf'].'</option>';
					
				}
				echo "</select>";

				?>		
			<label for="basic"><b>Notes:</b></label>
				<input type="text" name="notes" value="" data-mini="true" maxlength="255" />		
		<?php
	break;
	case 'projector':
		?>
		<div data-role="header" data-theme="a">
				<h1>Add Projector</h1>
		</div><!-- /header -->	
		<div data-role="content">
		<label for="basic"><b>Fill out the form, then click submit:</b></label>
		<br />
		<br />
		<form action="update.php" method="post" name="add" onSubmit="return checkForm();">
			<input type="hidden" name="action" value="save">
			<input type="hidden" name="hw_type" value="projector">
			<label for="basic"><b>Hardware Type:</b></label>
				<label for="basic"><?php print "projector"?></label>
			<br />
			<br />
			<label for="basic"><b>Common Name:</b></label>
				<input type="text" name="common_name" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Serial Number:</b></label>
				<input type="text" name="sn" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Building:</b></label>
				<?php include_once 'common/buildings.inc.php';?>
			<label for="basic"><b>Room:</b></label>
				<input type="text" name="room" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Purchase Date:</b></label>
				<input type="date" name="purchase_date" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Warranty Expires:</b></label>
				<input type="date" name="warranty_expire" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Projector Model:</b></label>
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

					echo '<option value="'.$hw['projector_model_id'].'" selected>'.$hw['model']. ' | ' .$hw['manuf'].'</option>';
					
				}
				echo "</select>";

				?>		
			<label for="basic"><b>Notes:</b></label>
				<input type="text" name="notes" value="" data-mini="true" maxlength="255" />		
		<?php
	break;
	case 'scanner':
		?>
		<div data-role="header" data-theme="a">
				<h1>Add Scanner</h1>
		</div><!-- /header -->	
		<div data-role="content">
		<label for="basic"><b>Fill out the form, then click submit:</b></label>
		<br />
		<br />
		<form action="update.php" method="post" name="add" onSubmit="return checkForm();">
			<input type="hidden" name="action" value="save">
			<input type="hidden" name="hw_type" value="scanner">
			<label for="basic"><b>Hardware Type:</b></label>
				<label for="basic"><?php print "scanner"?></label>
			<br />
			<br />
			<label for="basic"><b>Common Name:</b></label>
				<input type="text" name="common_name" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Serial Number:</b></label>
				<input type="text" name="sn" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Building:</b></label>
				<?php include_once 'common/buildings.inc.php';?>
			<label for="basic"><b>Room:</b></label>
				<input type="text" name="room" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Purchase Date:</b></label>
				<input type="date" name="purchase_date" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Warranty Expires:</b></label>
				<input type="date" name="warranty_expire" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Scanner Model:</b></label>
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

					echo '<option value="'.$hw['scanner_model_id'].'" selected>'.$hw['model']. ' | ' .$hw['manuf'].'</option>';
					
				}
				echo "</select>";

				?>		
			<label for="basic"><b>Notes:</b></label>
				<input type="text" name="notes" value="" data-mini="true" maxlength="255" />		
		<?php
	break;
	default:
		?>
		<div data-role="header" data-theme="a">
				<h1>Add Printer</h1>
		</div><!-- /header -->	
		<div data-role="content">
		<label for="basic"><b>Fill out the form, then click submit:</b></label>
		<br />
		<br />
		<form action="update.php" method="post" name="add" onSubmit="return checkForm();">
			<input type="hidden" name="action" value="save">
			<input type="hidden" name="hw_type" value="printer">
			<label for="basic"><b>Hardware Type:</b></label>
				<label for="basic"><?php print "printer"?></label>
			<br />
			<br />
			<label for="basic"><b>Common Name:</b></label>
				<input type="text" name="common_name" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Serial Number:</b></label>
				<input type="text" name="sn" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Building:</b></label>
				<?php include_once 'common/buildings.inc.php';?>
			<label for="basic"><b>Room:</b></label>
				<input type="text" name="room" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Purchase Date:</b></label>
				<input type="date" name="purchase_date" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Warranty Expires:</b></label>
				<input type="date" name="warranty_expire" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Printer Model:</b></label>
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

					echo '<option value="'.$hw['printer_model_id'].'" selected>'.$hw['model']. ' | ' .$hw['manuf'].'</option>';
					
				}
				echo "</select>";

				?>		
			<label for="basic"><b>Notes:</b></label>
				<input type="text" name="notes" value="" data-mini="true" maxlength="255" />		
		<?php
	break;
}
		?>
	<span data-mini="true">
		<input type="button" value="Back" class="button" title="Go back" onClick="history.go(-1)" data-inline="true">
		<input type="submit" name="Submit" value="Submit" class="button" title="Submit work order" data-inline="true" data-theme="d">	
	</span>
</form>
</div>
<?php
} else {
?>
	<label for="basic">You're Not Logged in!</label>
	<form action="/mobilelogin.php" method="get">
		<input type="hidden" name="adding" value="yes" />
			<a href="/mobilelogin.php" data-inline="true" data-role="button">Login</a>
	</form>
<?php
}
include_once 'footer.php';
include_once 'common/end.inc.php';
?>
