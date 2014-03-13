<?php
include_once 'header.php';

if($_SESSION['id'] == 'ok'){

?>
<?php
if ($_POST['startDate'] && $_POST['endDate']) {
	$startDate = ($_POST['startDate']);
	$endDate = ($_POST['endDate']);

$query = "SELECT *, DATE_FORMAT(purchase_date, '%m/%d/%y') AS purchase_date, DATE_FORMAT(warranty_expire, '%m/%d/%y') AS warranty_expire FROM inventory WHERE purchase_date BETWEEN '".$startDate."' AND '".$endDate."' ORDER BY inventory_id DESC LIMIT 500";
$result = mysql_query($query);
$count = mysql_num_rows($result);


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
			<h1>WarriorNet</h1>
			<a href="#" data-icon="home" data-iconpos="notext" data-direction="reverse" onclick="javascript:location.href='index.php'">Home</a>
		</div><!-- /header -->	
	<br />
		<div data-role="content" class="mybg">
		<b>Total Items: <?php if ($count > 499) {?> ><?php print $count; } else { print $count; }?><br /></b>
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
					<th data-hide="phone, tablet" data-sort-ignore="true">
						Edit
					</th>				
					</tr>
				</thead>	
				<tbody>
			<?php
				do
				{
					$id = $rs['inventory_id'];
					$sn = $rs['SN'];
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
						<a href="addsplash.php" data-theme="a" data-role="button" data-ajax="false" data-mini="true">New Entry</a>
					</td>
					<td>
						<a href="index.php" data-theme="a" data-role="button" data-ajax="false" data-mini="true">Search All Items</a>
					</td>
				</tr>
				<tr>
					<td>
						<a href="searchMS.php" data-theme="a" data-role="button" data-ajax="false" data-mini="true">View MS Items</a>	
					</td>
					<td>
						<a href="searchUE.php" data-theme="a" data-role="button" data-ajax="false" data-mini="true">View UE Items</a>	
					</td>
				</tr>
				<tr>
					<td>
						<a href="searchES.php" data-theme="a" data-role="button" data-ajax="false" data-mini="true">View ES Items</a>	
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
	</div><!-- /header -->	<div data-role="content">Sorry, there were no items purchased between those dates.</div></div>';
}			
} else {
?>
<div data-role="page" class="type-interior mybg">
	<div data-role="header" data-theme="a">
		<h1>Items Purchased Between</h1>
		<a href="#" data-icon="home" data-iconpos="notext" data-direction="reverse" onclick="javascript:location.href='index.php'">Home</a>
	</div><!-- /header -->	
<br />
<div data-role="content">
<form method="post" onSubmit="byDates.php">
	<label for="basic"><b>Select a Start Date: </b></label>
		<input type="date" id="datepicker" name="startDate"/>
	<label for="basic"><b>Select an End Date: </b></label>
		<input type="date" id="datepicker" name="endDate"/>	
	<input type="submit" value="Submit" data-inline="true"/>
	<a href="/tech/index.php"><input type="button" value="Cancel" data-inline="true" data-theme="e"/></a>		
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
