<?php
include 'header.php';

if ($_POST['id'])
{
	$id = $_POST['id'];
}
if ($_GET['id'])
{
	$id = $_GET['id'];
}
if ($_POST['inventory_id'])
{
	$inventory_id = $_POST['inventory_id'];
}
if ($_GET['inventory_id'])
{
	$inventory_id = $_GET['inventory_id'];
}
if ($_POST['adding'])
{
	$adding = $_POST['adding'];
}
if ($_GET['sn'])
{
	$sn = $_GET['sn'];
}
if ($_POST['sn'])
{
	$sn = $_POST['sn'];
}
?>
<div data-role="dialog" id="edit">

<?php
if ($_POST['password'] != $app_password)
{
?>
	<div data-role="header" data-theme="a" data-inline="true">
		<h6>Incorrect Password!</h6>
	</div><!-- /header -->	
	<div data-role="content">
<?php 
	if ($id)
	{
	?>
	<p>Incorrect!</p>
		<script language="javascript"><!--
		location.replace("mobilelogin.php?inventory_id=<?php print $inventory_id;?>")
		//-->
		</script>
	<?php
	} elseif ($sn) {
	?>
	<p>Incorrect!</p>
		<script language="javascript"><!--
		location.replace("mobilelogin.php?sn=<?php print $sn;?>")
		//-->
		</script>
	<?php
	} else {
	?>
	<p>Incorrect!</p>
		<script language="javascript"><!--
		location.replace("mobilelogin.php")
		//-->
		</script>
	<?php
	}
	?>
	</div>
	<?
} else {
	//session_start();
	$login = 'ok';
	//session_register('login');
	$_SESSION['id'] = $login;
	session_cache_expire(20);
?>
	<div data-role="header" data-theme="a" data-inline="true">
		<h6>Success!</h6>
	</div><!-- /header -->	
	<div data-role="content">
	<?php 
	if ($inventory_id)
	{
	?>
	<p>You'll Be Automatically Redirected</p>
		<script language="javascript"><!--
		location.replace("edit.php?inventory_id=<?php print $inventory_id;?>")
		//-->
		</script>
	<?php
	} elseif ($sn) {
	?>
	<p>You'll Be Automatically Redirected</p>
		<script language="javascript"><!--
		location.replace("edit.php?sn=<?php print $sn;?>")
		//-->
		</script>
	<?php
	} else {
	?>
		<p>You'll Be Automatically Redirected</p>
			<script language="javascript"><!--
			location.replace("index.php")
			//-->
			</script>
	<?php
	}
}
?>
</div>
</div>
<?php
include 'footer.php';
?>
