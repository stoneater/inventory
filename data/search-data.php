<?php

    /* Database setup information */
    $dbhost = 'localhost';  // Database Host
    $dbuser = 'helpdesk';       // Database Username
    $dbpass = 'helpdesk';           // Database Password
    $dbname = 'inventory';     // Database Name

    /* Connect to the database and select database */
    $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
    mysql_select_db($dbname);

    /* The search input from user ** passed from jQuery .get() method */
	$param = $_GET['searchData'];

	$sResults = null;
	
	/* Don't overload phones or mobile devices, make minimum search requirement */	
	if (strlen($param) > 2){

		/* If connection to database, run sql statement. */
		if ($conn) {

			/* Fetch the users input from the database and put it into a
			 valuable $fetch for output to our table. */
			$fetch = mysql_query("SELECT * FROM inventory WHERE inventory_id LIKE '%$param%' OR SN LIKE '%$param%' OR building LIKE '%$param%' OR room LIKE '%$param%' OR common_name LIKE '%$param%' OR hw_type LIKE '%$param%' OR purchase_date LIKE '%$param%' OR warranty_expire LIKE '%$param%' LIMIT 150");

			/*
			   Retrieve results of the query to and build the table.
			   We are looping through the $fetch array and populating
			   the table rows based on the users input.
			 */
			while ( $row = mysql_fetch_object( $fetch ) ) {
				$sResults .= '<tr>';
				$sResults .= '<td>' . $row->SN . '</td>';
				$sResults .= '<td>' . $row->building . '</td>';
				$sResults .= '<td>' . $row->room . '</td>';
				$sResults .= '<td>' . $row->common_name . '</td>';
				$sResults .= '<td>' . $row->hw_type . '</td>';
				$sResults .= '<td>' . $row->inventory_id . '</td>';
				$sResults .= '<td>' . $row->purchase_date . '</td>';
				$sResults .= '<td>' . $row->warranty_expire . '</td>';
				$sResults .= '<td><a href="edit.php?inventory_id=' . $row->inventory_id . '">Edit</td></tr>';
			}

		}

		/* Free connection resources. */
		mysql_close($conn);

		/* Toss back the results to populate the table. */
		echo $sResults;
	}
?>