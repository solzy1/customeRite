<?php
	$mysqli = new mysqli('localhost','root','','thisDatabase');

	//read and display orders from database
	function loadOrders(){
		global $mysqli;

		// DISTINCT itemID, orderID, customerID, Payments, dateOfOrder, totalPrice

		$query = $mysqli -> query("SELECT * FROM Orders WHERE dateOfOrder LIKE '%".$_POST['search']."%' ORDER BY customerID ASC");

		// $query1 = $mysqli -> query("SELECT customerID, username, lastName, initials FROM Customer WHERE customerID LIKE '%".$_POST["search"]."%'");

		// $rowCount1 = $query1 -> num_rows;
		$rowCount = $query -> num_rows;

		if($rowCount > 0){
			while($row = $query -> fetch_assoc()){
				$rowId = $row['orderID'];
				$colCustId = $row['customerID'];
				$colitemId = $row['itemID'];
				$colPayment =  $row['Payments'];
				$colOrderDate =  $row['dateOfOrder'];
				$coltotalPrice =  $row['totalPrice'];

				$username;
				$lastName;
				$initials;
				$subjectTitle;
				$descTitle;

				// retrieving columns from customer table
				$query1 = $mysqli -> query("SELECT username, lastName, initials FROM customer WHERE customerID = ".$colCustId);
				$rowCount1 = $query1 -> num_rows;
				if($rowCount1 > 0){
					while($row1 = $query1 -> fetch_assoc()){
						$username = $row1['username'];
						$lastName = $row1['lastName'];
						$initials = $row1['initials'];
					}
				}

				// retrieving columns from item table 
				$query2 = $mysqli -> query("SELECT subjectID, descriptionID FROM Item WHERE itemID = ".$colitemId);
				$rowCount2 = $query2 -> num_rows;
				if($rowCount2 > 0){
					while($row2 = $query2 -> fetch_assoc()){
						$subjectID = $row2['subjectID'];
						$descriptionID = $row2['descriptionID'];

						// retrieving title from subject table 
						$query3 = $mysqli -> query("SELECT title FROM Subject WHERE subjectID = ".$subjectID);
						$rowCount3 = $query3 -> num_rows;
						if($rowCount3 > 0){
							while($row3 = $query3 -> fetch_assoc()){
								$subjectTitle = $row3['title'];
							}
						}

						// retrieving title from description table 
						$query4 = $mysqli -> query("SELECT title FROM Description WHERE descriptionID = ".$descriptionID);
						$rowCount4 = $query4 -> num_rows;
						if($rowCount4 > 0){
							while($row4 = $query4 -> fetch_assoc()){
								$descTitle = $row4['title'];
							}
						}
					}
				}

				echo '<tr>';
					echo '<td>'.$colCustId.'</td>';
					echo '<td>'.$username.'</td>';
					echo '<td>'.$lastName.' '.$initials.'</td>';
					echo '<td> Subject: '.$subjectTitle.' | Description: '.$descTitle.'</td>';
					echo '<td>'.$colOrderDate.'</td>';
					echo '<td>'.$colPayment.'</td>';
					echo '<td>'.$coltotalPrice.'</td>';
					echo '<td>';
						echo '<a href=orderDetails.php?orderID="'.$rowId.'" class="btn btn-primary">Details</a>';
					echo '</td>';
				echo '</ tr>';
			}
		}
		else{
			echo "Data Not Found";
		}
	}

	loadOrders();
?>