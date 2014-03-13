<?php
include_once 'header.php';

$script = $_SERVER['PHP_SELF'];

?>
<div data-role="page" class="type-interior">
	<div data-role="header" data-theme="a">
		<h1>WarriorNet</h1>
		<a href="#" data-icon="home" data-iconpos="notext" data-direction="reverse" onclick="javascript:location.href='index.php'">Home</a>
	</div><!-- /header -->	
<br />
	<div data-role="content" class="mybg">
		<label>Enter a keyword to search for:</label>
		<input id="searchData" type="text" />
	<br />
		
		<table class="footable cStoreDataTable" id="cStoreDataTable" data-filter="#filter">
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
			<tbody id="results"></tbody>
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
						<a href="searchHS.php" data-theme="a" data-role="button" data-ajax="false" data-mini="true">View HS Items</a>
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
<?php include_once 'footer.php';?>


