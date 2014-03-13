<?php
include_once 'header.php';

if($_SESSION['id'] == 'ok'){

?>
<script language="JavaScript" type="text/javascript">
<!--
	function sendForm() {
		document.tech.submit()
	}
</script>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

if ($_POST['computer_model_id']) {
	$computer_model_id = ($_POST['computer_model_id']);

	$query = 'SELECT inventory.inventory_id, hw_type, common_name, building, room, assigned_pc, purchase_date, warranty_expire, 
						sn, notes, computer.computer_model_id, manuf, model, processor, processor_speed, memory, HD_size, original_OS FROM inventory, computer, 
						computer_model WHERE inventory.inventory_id = computer.inventory_id and computer.computer_model_id = computer_model.computer_model_id and computer_model.computer_model_id = '.$computer_model_id.'';
	$result = mysql_query($query);
	$count = mysql_num_rows($result);

	$querys = 'SELECT inventory.inventory_id, hw_type, common_name, building, room, assigned_pc, purchase_date, warranty_expire, 
						sn, notes, computer.computer_model_id, manuf, model, processor, processor_speed, memory, HD_size, original_OS FROM inventory, computer, 
						computer_model WHERE inventory.inventory_id = computer.inventory_id and computer.computer_model_id = computer_model.computer_model_id and computer_model.computer_model_id = '.$computer_model_id.'';
	$results = mysql_query($querys);
}
if ($count > 0){ // If it ran OK, display the records.
?>
	<meta http-equiv="refresh" content="300" />
	<script>
		$(function() 
		{
			$('#yahoo a').tooltip({
			track: true,
			delay: 0,
			showURL: false,
			showBody: " - ",
			fade: 250
			});
		});
	</script>
	<style>
		#tooltip {
			position: absolute;
			z-index: 3000;
			border: 1px solid #111;
			background-color: #eee;
			padding: 5px;
			opacity: 0.85;
		}
		#tooltip h3, #tooltip div { margin: 0; }
	</style>
	<div data-role="page" class="type-interior">
		<div data-role="header" data-theme="a">
			<h1>WarriorDesk</h1>
			<a href="#" data-icon="home" data-iconpos="notext" data-direction="reverse" onclick="javascript:location.href='index.php'">Home</a>
		</div><!-- /header -->	
	<br />
		<div data-role="content" class="mybg">
		<b>Total <?php 	
		if ($hw = mysql_fetch_array($results, MYSQL_ASSOC))
		{	
			$model = $hw['model'];
			echo $model;
		} ?>'s: <?php if ($count > 499) {?> ><?php print $count; } else { print $count; }?> <a href="byModel.php" data-inline="true" data-theme="a" data-role="button" data-ajax="false" data-mini="true">Change Model</a>	<br /></b>
		<br />
		<?php
		if ($rs = mysql_fetch_array($result, MYSQL_ASSOC))
		{		
		?>
			<table class="footable" data-filter="#filter">
				<thead>
					<tr>
						<th data-class="expand">
							Serial
						</th>
						<th>
							Building
						</th>
						<th>
							Room
						</th>				
						<th data-hide="phone">
							Name
						</th>
						<th data-hide="phone">
							Type
						</th>
						<th data-hide="phone, tablet">
							ID #
						</th>				
						<th data-hide="phone, tablet">
							Purchase Date
						</th>
						<th data-hide="phone, tablet">
							Warranty Expire
						</th>
						<th data-hide="phone, tablet">
							Edit
						</th>	
					</tr>
				</thead>	
				<tbody>
			<?php
				do
				{
					$id = $rs['inventory_id'];
					$sn = $rs['sn'];
					$building = $rs['building'];
					$room = $rs['room'];
					$common_name = $rs['common_name'];
					$hw_type = $rs['hw_type'];
					$id = $rs['inventory_id'];
					$purchaseDate = $rs['purchase_date'];
					$purchaseDateNumeric = strtotime($purchaseDate);
					$warrantyExpire = $rs['warranty_expire'];
					$warrantyExpireNumeric = strtotime($warrantyExpire);					
	

					echo '<tr><td>'.$sn.'</td>';
					echo '<td>'.$building.'</td>';		
					echo '<td>'.$room.'</td>';					
					echo '<td>'.$common_name.'</td>';	
					echo '<td>'.$hw_type.'</td>';			
					echo '<td>'.$id.'</td>';
					echo '<td data-value="'.$purchaseDateNumeric.'">'.$purchaseDate.'</td>';
					echo '<td data-value="'.$warrantyExpireNumeric.'">'.$warrantyExpire.'</td>';					
					echo '<td><a href="edit.php?inventory_id='.$id.'">Edit Record</a></td></tr>';
			
				} while ($rs = mysql_fetch_array($result));
				
			?>
			</tbody>
		</table>
			<span data-mini="true">
				<br />
				<hr />
				<br />
			</span>
			<?php
			if($_SESSION['id'] == 'ok'){
			?>
			<table align="center">
				<tr>
					<td>
						<a href="new.php" data-theme="a" data-role="button" data-ajax="false" data-mini="true">Submit Work Order</a>
					</td>
					<td>
						<a href="completed.php" data-theme="a" data-role="button" data-ajax="false" data-mini="true">Recently Completed</a>
					</td>
				</tr>
				<tr>
					<td>
						<a href="search.php" data-theme="a" data-role="button" data-ajax="false" data-mini="true">Search Workorders</a>	
					</td>			
					<td>
						<a href="/tech/index.php" data-theme="a" data-role="button" data-ajax="false" data-mini="true">Back to Tech Home</a>	
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<a href="logout.php" data-theme="a" data-role="button" data-ajax="false" data-mini="true">Logout</a>
					</td>
				</tr>
			</table>
			<?php
			} else {
			?>
			<table align="center">
				<tr>
					<td>
						<a href="new.php" data-theme="a" data-role="button" data-ajax="false" data-mini="true">Submit Work Order</a>
					</td>
					<td>
						<a href="mobilelogin.php"  data-theme="a" data-role="button" data-ajax="false" data-mini="true">Log In</a>
					</td>
				</tr>
			</table>	
			<?php
			}
			?>
		</div>
	<?php 
	} else {
				print 'Sorry, no results found for your search of ' . $query . '.  Please try again.<br />';
			}
} else {
	print '<div data-role="dialog"><div data-role="header" data-theme="a">
		<h1>Error</h1>
		<a href="#" data-icon="home" data-iconpos="notext" data-direction="reverse" onclick="javascript:location.href="index.php"">Home</a>
	</div><!-- /header -->	<div data-role="content">Sorry, that technician has not been assigned any workorders yet.</div></div>';
}			
} else {
?>
<div data-role="page" class="type-interior mybg">
	<div data-role="header" data-theme="a">
		<h1>View By Model</h1>
		<a href="#" data-icon="home" data-iconpos="notext" data-direction="reverse" onclick="javascript:location.href='index.php'">Home</a>
	</div><!-- /header -->	
<br />
<div data-role="content">
<label for="basic"><b>Select model to view.</b></label>
<br />
	<form name="tech" method="post" onSubmit="byTechnician.php">
		<?php
			//Create MySQL statement to populate hardware list
			$sql_statement_md = 'SELECT * FROM computer_model ORDER BY computer_model_id DESC';
			//Execute built query...
			$results_md = mysql_query($sql_statement_md) or die ('Error in <b>' . $sql_statement_md . '</b>. ' . mysql_error());
										
			//create drop down list
			echo '<select name="computer_model_id" onChange="sendForm()">';
			echo "<option value=''>-Select Computer Model-</option>";
										
			 while($hw=mysql_fetch_array($results_md))
			{      
				echo '<option value="' .$hw['computer_model_id']. '" >'.$hw['model']. ' | ' .$hw['manuf'].'</option>';					
			} 
			echo "</select>";
		?>	
	</form>
<?php
}
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
