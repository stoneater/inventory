<?php
include_once 'header.php';

$script = $_SERVER['PHP_SELF'];

$query = sprintf("SELECT * FROM inventory WHERE building LIKE 'Upper' ORDER BY inventory_id DESC");
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
			<h1>WarriorDesk</h1>
			<a href="#" data-icon="home" data-iconpos="notext" data-direction="reverse" onclick="javascript:location.href='index.php'">Home</a>
		</div><!-- /header -->	
	<br />
		<div data-role="content" class="mybg">
		<b>Total Records: <?php print $count?><br /></b>
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
					$SN = $rs['SN'];
					$building = $rs['building'];
					$room = $rs['room'];
					$common_name = $rs['common_name'];
					$hw_type = $rs['hw_type'];
					$purchase_date = $rs['purchase_date'];
					$warranty_expire = $rs['warranty_expire'];

					echo '<tr><td>'.$SN.'</td>';
					echo '<td>'.$building.'</td>';
					echo '<td>'.$room.'</td>';
					echo '<td>'.$common_name.'</td>';
					echo '<td>'.$hw_type.'</td>';	
					echo '<td>'.$id.'</td>';						
					echo '<td>'.$purchase_date.'</td>';
					echo '<td>'.$warranty_expire.'</td>';
					echo '<td><a href="edit.php?inventory_id='.$id.'">Edit Record</a></td></tr>';
			
				} while ($rs = mysql_fetch_array($result));
				
			?>
			</tbody>
		</table>	
		<br />
		<br />
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
						<a href="searchHS.php" data-theme="a" data-role="button" data-ajax="false" data-mini="true">View HS Items</a>	
					</td>
					<td>
						<a href="searchMS.php" data-theme="a" data-role="button" data-ajax="false" data-mini="true">View MS Items</a>	
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
			} else {
			?>
			<table align="center">
				<tr>
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
}
include_once 'footer.php';?>