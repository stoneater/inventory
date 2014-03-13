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
				<h1>Add Computer Model</h1>
		</div><!-- /header -->	
		<div data-role="content" class="mybg">
		<label for="basic"><b>Fill out the form, then click submit:</b></label>
		<br />
		<br />
		<form action="updateModel.php" method="post" name="add" onSubmit="return checkForm();">
			<input type="hidden" name="action" value="save">
			<input type="hidden" name="hw_type" value="computer">
			<label for="basic"><b>Hardware Type:</b></label>
				<label for="basic"><?php print "computer"?></label>
			<br />
			<br />
			<label for="basic"><b>Manufacturer:</b></label>
			<i>(i.e., Dell)</i>
				<input type="text" name="manufacturer" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Model:</b></label>
			<i>(i.e., 755, 390)</i>
				<input type="text" name="model" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Processor:</b></label>
				<input type="text" name="processor" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Processor Speed:</b></label>
				<input type="text" name="processor_speed" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Memory (GB):</b></label>
				<input type="text" name="memory" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Hard Drive Size (GB):</b></label>
				<input type="text" name="hard_drive_size" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Original OS:</b></label>
				<select name="original_os">
					<option selected value="">Select</option>
					<option value="XP">XP</option>
					<option value="Vista">Vista</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="Android">Android</option>
					<option value="iOS">iOS</option>
				</select>
		<?php
	break;
	case 'monitor':
		?>
		<div data-role="header" data-theme="a">
				<h1>Add Monitor Model</h1>
		</div><!-- /header -->	
		<div data-role="content">
		<label for="basic"><b>Fill out the form, then click submit:</b></label>
		<br />
		<br />
		<form action="updateModel.php" method="post" name="add" onSubmit="return checkForm();">
			<input type="hidden" name="action" value="save">
			<input type="hidden" name="hw_type" value="monitor">
			<label for="basic"><b>Hardware Type:</b></label>
				<label for="basic"><?php print "monitor"?></label>
			<br />
			<br />
			<label for="basic"><b>Manufacturer:</b></label>
			<i>(i.e., Dell)</i>
				<input type="text" name="manufacturer" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Model:</b></label>
			<i>(i.e., 1918)</i>
				<input type="text" name="model" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Type:</b></label>
				<select name="type">
					<option selected value="">Select</option>
					<option value="Flat Panel">Flat Panel</option>
					<option value="Wide Flat Panel">Wide Flat Panel</option>
					<option value="LCD Touchscreen">LCD Touchscreen</option>
				</select>
			<label for="basic"><b>Size (in):</b></label>
				<input type="text" name="size" value="" data-mini="true" maxlength="255" />
		<?php
	break;
	case 'projector':
		?>
		<div data-role="header" data-theme="a">
				<h1>Add Projector Model</h1>
		</div><!-- /header -->	
		<div data-role="content">
		<label for="basic"><b>Fill out the form, then click submit:</b></label>
		<br />
		<br />
		<form action="updateModel.php" method="post" name="add" onSubmit="return checkForm();">
			<input type="hidden" name="action" value="save">
			<input type="hidden" name="hw_type" value="projector">
			<label for="basic"><b>Hardware Type:</b></label>
				<label for="basic"><?php print "projector"?></label>
			<br />
			<br />
			<label for="basic"><b>Manufacturer:</b></label>
			<i>(i.e., Epson)</i>
				<input type="text" name="manufacturer" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Model:</b></label>
			<i>(i.e., 83+)</i>
				<input type="text" name="model" value="" data-mini="true" maxlength="255" />
		<?php
	break;
	case 'scanner':
		?>
		<div data-role="header" data-theme="a">
				<h1>Add Scanner Model</h1>
		</div><!-- /header -->	
		<div data-role="content">
		<label for="basic"><b>Fill out the form, then click submit:</b></label>
		<br />
		<br />
		<form action="updateModel.php" method="post" name="add" onSubmit="return checkForm();">
			<input type="hidden" name="action" value="save">
			<input type="hidden" name="hw_type" value="scanner">
			<label for="basic"><b>Hardware Type:</b></label>
				<label for="basic"><?php print "scanner"?></label>
			<br />
			<br />
			<label for="basic"><b>Manufacturer:</b></label>
			<i>(i.e., AVerMedia)</i>
				<input type="text" name="manufacturer" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Model:</b></label>
			<i>(i.e., SDP-680)</i>
				<input type="text" name="model" value="" data-mini="true" maxlength="255" />
		<?php
	break;
	default:
		?>
		<div data-role="header" data-theme="a">
				<h1>Add Printer Model</h1>
		</div><!-- /header -->	
		<div data-role="content">
		<label for="basic"><b>Fill out the form, then click submit:</b></label>
		<br />
		<br />
		<form action="updateModel.php" method="post" name="add" onSubmit="return checkForm();">
			<input type="hidden" name="action" value="save">
			<input type="hidden" name="hw_type" value="printer">
			<label for="basic"><b>Hardware Type:</b></label>
				<label for="basic"><?php print "printer"?></label>
			<br />
			<br />
			<label for="basic"><b>Manufacturer:</b></label>
			<i>(i.e., HP)</i>
				<input type="text" name="manufacturer" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Model:</b></label>
			<i>(i.e., 4250)</i>
				<input type="text" name="model" value="" data-mini="true" maxlength="255" />
			<label for="basic"><b>Type:</b></label>
			<i>(i.e., Laser, Color Laser)</i>
				<input type="text" name="model" value="Laser" data-mini="true" maxlength="255" />				
		<?php
	break;
}
		?>
	<span data-mini="true">
		<input type="button" value="Back" class="button" title="Go back" onClick="history.go(-1)" data-inline="true">
		<input type="submit" name="Submit" value="Submit" class="button" title="Submit model" data-inline="true" data-theme="d">	
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
