<?php
include_once 'header.php';

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

//Function to select the status...
function statusSelect()
{
	var url = document.status.hw_type.options[document.status.hw_type.selectedIndex].value
	window.location.href = url 
}
//-->
</script>
<div data-role="page" class="type-interior mybg">
	<div data-role="header" data-theme="a">
		<h1>Add Inventory Item</h1>
		<a href="#" data-icon="home" data-iconpos="notext" data-direction="reverse" onclick="history.go(-1)">Home</a>
	</div><!-- /header -->	
<br />
<div data-role="content">
<label for="basic"><b>Select the hardware type.</b></label>
<br />
	<form name="status" method="post" action="add.php">
		<label for="basic">Hardware Type:</label>
			<select name="hw_type">
				<option selected value="<?php print "addsplash.php"?>">--- ----</option>
				<option value="computer">Computer</option>
				<option value="monitor">Monitor</option>
				<option value="printer">Printer</option>
				<option value="projector">Projector</option>
				<option value="scanner">Scanner</option>
			</select>
		<input type="submit" name="Submit" value="Submit" class="button" title="Submit work order" data-inline="true" data-theme="d">	
	</form>
<?php
} else {
?>
	<label for="basic">You're Not Logged in!</label>
	<form action="mobilelogin.php" method="get">
		<input type="hidden" name="adding" value="yes" />
			<a href="mobilelogin.php" data-inline="true" data-role="button">Login</a>
	</form>
<?php
}
?>
</div>
<?php
include_once 'footer.php';
include_once 'common/end.inc.php';
?>
