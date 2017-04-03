
<?php 
/*************************************************
SINDHUJA NANDIKONDA
Description:
	This file resolves all the queries and reports proposed in the assignment.
Author:
	J.Pastorino  Jan.2017
 *************************************************/ 
?>

<html>
<head>
	<meta http-equiv="Content-Type" charset="UTF-8">
	<link href="./styles.css"	 	rel="stylesheet" type="text/css"> 
</head>

<body>
	<?php include ('./header.php'); ?>

	<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
		<tr> 
			<td> 
				<table height="50px" width="99%" border="0" cellpadding="3" cellspacing="5"> 
				<tr> 
					<td style='width:100%; text-align:left;'> <h1>CSCI5559 - Database Systems - Assignment #1B - Application framework</h1></td> 
				</tr> 
				</table>
			<br>
			</td>
		</tr>
	</table>

<?php

include("./dbConnection.php");

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function reportErrorAndDie($error, $description){  /* In case of an error, this function displays the error and abort the execution.*/
	echo '
		<table width="550px" style="margin: auto;" class="disponibilidad">
			<tr><th class="month" style="text-align:center;border:0px; " colspan="2">
					Error Occured.
				</th>
			</tr>					
			<tr>
				<th>ErrCode</th> <td>'.$error.'</td>
			</tr>
			<tr>
				<th>Description</th> <td>'.$description.'</td>
			</tr>
		</table>
		<br>';
	include ("./copyright.php");
	echo '
	</body>
	</html>';
	die;
}


if (isset($_GET["queryId"])	)	{ $QUERY_ID = intval($_GET["queryId"]); 	 }		else {	$QUERY_ID =-1;	}	

/******* TIP:  Implement each query in a separate case. You can reuse by copying and pasting the sample query/report and editing the query and code.  */
switch ($QUERY_ID) {
	/***************************************************************************************************************************************************/
	case 1:  /*Query 1: display database Tables.*/
		$tr_id=0; $tr_class='class="bckMngrtrOdd"';  //Used to display rows background color.

		//DISPLAY QUERY Title and Description.
		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>Query 1: Database Table List.</th></tr>
				<tr class='bckMngr'><td class='bckMngr'>List all the tables in the current database.</td></tr>
			  </table><br>";

		try { /*Protect execution errors capturing exceptions.*/
			//Query to run
			$queryText = "SELECT position,COUNT(*) FROM `KitchenStaff` GROUP BY position;" ;
			
			//Prepare the query. 
			$resultSet = $mysql->prepare($queryText);  
			
			/*Execute the query. Params are passed in order as they appear in the query text "?" */
			$resultSet->execute(array($db_database));
		
			/*** DISPLAY RESULT DATA  -- We will not consider any problem of table shifting because of data size.  *****/
			echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>";	//Try this: May change the whole table size.
			
			echo '<thead>' ;														//HTML Header - Columns headers
			echo 	'<tr class="bckMngr">';
			echo 	'<th class="bckMngr" style="width:80px;">Database</th>';		
			echo 	'<th class="bckMngr" style="width:160px;">Table Name</th>';		 
			echo 	'<th class="bckMngr" style="width:80px;">Engine</th>';
			echo 	'<th class="bckMngr" style="width:80px;">No. Of Rows</th>';
			echo '</thead>';


			echo "<tbody>";
			while($row  = $resultSet->fetch(PDO::FETCH_ASSOC)){
				if ($tr_id == 0){$tr_class='class="bckMngrtrEven"'; $tr_id=1;} 		else {$tr_class='class="bckMngrtrOdd"' ; $tr_id=0;}
				echo '<tr '.$tr_class.'>';
					echo '<td class="bckMngr" style="text-align:left;width:80px;">'.  $row['db_name'].'</td>';
					echo '<td class="bckMngr" style="text-align:left;width:160px;">'. $row['table_name'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:80px;">'.$row['engine'].'</td>';
					echo '<td class="bckMngr" style="text-align:right;width:80px;">'. $row['table_rows'].'</td>';
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";

		}
		catch (PDOException $e){
			reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
		}	
	break;

	case 2:  /*Query 2: Sample query.*/
		$tr_id=0; $tr_class='class="bckMngrtrOdd"';  //Used to display rows background color.

		//DISPLAY QUERY Title and Description.
		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>Query 2: Sample.</th></tr>
				<tr class='bckMngr'><td class='bckMngr'>This is a Sample query on the database (solution tables must be created under database schema dba).</td></tr>
			  </table><br>";

		try { /*Protect execution errors capturing exceptions.*/
			//Query to run
			$queryText = "SELECT Cashier.empId as id,name,address,password FROM dba.Employee, dba.Cashier WHERE Employee.empId=Cashier.empId;" ;
			
			//Prepare the query. 
			$resultSet = $mysql->prepare($queryText);  
			
			/*Execute the query. Params are passed in order as they appear in the query text "?" */
			$resultSet->execute(array());
		
			/*** DISPLAY RESULT DATA  -- We will not consider any problem of table shifting because of data size.  *****/
			echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>";	//Try this: May change the whole table size.
			
			echo '<thead>' ;														//HTML Header - Columns headers
			echo 	'<tr class="bckMngr">';
			echo 	'<th class="bckMngr" style="width:150px;">Cashier (#empId)</th>';		 
			echo 	'<th class="bckMngr" style="width:260px;">Address</th>';			 
			echo 	'<th class="bckMngr" style="width:150px;">Password</th>';

			echo '</thead>';


			echo "<tbody>";
			while($row  = $resultSet->fetch(PDO::FETCH_ASSOC)){
				if ($tr_id == 0){$tr_class='class="bckMngrtrEven"'; $tr_id=1;} 		else {$tr_class='class="bckMngrtrOdd"' ; $tr_id=0;}
				echo '<tr '.$tr_class.'>';
					echo '<td class="bckMngr" style="text-align:left;width:150px;">'.  $row['name']." (".$row['id'].")".'</td>';   //notice how to access empId field.
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['address'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['password'].'</td>';
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";

		}
		catch (PDOException $e){
			reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
		}	
	break;
    case 3:  /*Query 2: Sample query.*/
		$tr_id=0; $tr_class='class="bckMngrtrOdd"';  //Used to display rows background color.

		//DISPLAY QUERY Title and Description.
		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>Query A1</th></tr>
				
			  </table><br>";

		try { /*Protect execution errors capturing exceptions.*/
			//Query to run
			$queryText = "SELECT DinnerTable.address, DinnerTable.state, DinnerTable.tableNumber,Employee.name,Employee.SSN FROM Employee,DinnerTable WHERE DinnerTable.waiter=Employee.empId;" ;
			
			//Prepare the query. 
			$resultSet = $mysql->prepare($queryText);  
			
			/*Execute the query. Params are passed in order as they appear in the query text "?" */
			$resultSet->execute(array());
		
			/*** DISPLAY RESULT DATA  -- We will not consider any problem of table shifting because of data size.  *****/
			echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>";	//Try this: May change the whole table size.
			
			echo '<thead>' ;														//HTML Header - Columns headers
			echo 	'<tr class="bckMngr">';
			echo 	'<th class="bckMngr" style="width:150px;">Address</th>';		 
			echo 	'<th class="bckMngr" style="width:260px;">state</th>';			 
			echo 	'<th class="bckMngr" style="width:150px;">Number</th>';
			echo 	'<th class="bckMngr" style="width:150px;">name</th>';
            echo 	'<th class="bckMngr" style="width:150px;">ssn</th>';
			echo '</thead>';


			echo "<tbody>";
			while($row  = $resultSet->fetch(PDO::FETCH_ASSOC)){
				if ($tr_id == 0){$tr_class='class="bckMngrtrEven"'; $tr_id=1;} 		else {$tr_class='class="bckMngrtrOdd"' ; $tr_id=0;}
				echo '<tr '.$tr_class.'>';
					   //notice how to access empId field.
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['address'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['state'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['tableNumber'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['name'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['SSN'].'</td>';
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";

		}
		catch (PDOException $e){
			reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
		}	
	break;
	case 4:  /*Query 2: Sample query.*/
		$tr_id=0; $tr_class='class="bckMngrtrOdd"';  //Used to display rows background color.
		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>Query A2</th></tr>
				
			  </table><br>";

		try { /*Protect execution errors capturing exceptions.*/
			//Query to run
			$queryText = "SELECT position,COUNT(*) FROM `KitchenStaff` GROUP BY position;" ;
			
			//Prepare the query. 
			$resultSet = $mysql->prepare($queryText);  
			
			/*Execute the query. Params are passed in order as they appear in the query text "?" */
			$resultSet->execute(array());
		
			/*** DISPLAY RESULT DATA  -- We will not consider any problem of table shifting because of data size.  *****/
			echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>";	//Try this: May change the whole table size.
			
			echo '<thead>' ;														//HTML Header - Columns headers
			echo 	'<tr class="bckMngr">';
			echo 	'<th class="bckMngr" style="width:150px;">position</th>';		 
			echo 	'<th class="bckMngr" style="width:260px;">Count</th>';			 
			
			echo '</thead>';


			echo "<tbody>";
			while($row  = $resultSet->fetch(PDO::FETCH_ASSOC)){
				if ($tr_id == 0){$tr_class='class="bckMngrtrEven"'; $tr_id=1;} 		else {$tr_class='class="bckMngrtrOdd"' ; $tr_id=0;}
				echo '<tr '.$tr_class.'>';
					   //notice how to access empId field.
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['position'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['COUNT(*)'].'</td>';
					
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";

		}
		catch (PDOException $e){
			reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
		}	
	break;
		case 5:  
		$tr_id=0; $tr_class='class="bckMngrtrOdd"';  //Used to display rows background color.
		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>Query A3</th></tr>
				
			  </table><br>";

		try { /*Protect execution errors capturing exceptions.*/
			//Query to run
			
				 

			
			$queryText = "SELECT name,'WAITER' AS `Role`,address,SSN,zipCode FROM Employee,Waiter WHERE Waiter.empId=Employee.empId && zipCode in (80013,80014,80017) UNION SELECT name,'CASHIER' AS `Role`,address,SSN,zipCode FROM Employee,Cashier WHERE Cashier.empId=Employee.empId && zipCode in (80013,80014,80017) UNION SELECT name,position AS `Role`,address,SSN,zipCode FROM Employee,KitchenStaff WHERE KitchenStaff.empId=Employee.empId && zipCode in (80013,80014,80017)" ;
			
			//Prepare the query. 
			$resultSet = $mysql->prepare($queryText);  
			
			/*Execute the query. Params are passed in order as they appear in the query text "?" */
			$resultSet->execute(array());
		
			/*** DISPLAY RESULT DATA  -- We will not consider any problem of table shifting because of data size.  *****/
			echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>";	//Try this: May change the whole table size.
			
			echo '<thead>' ;														//HTML Header - Columns headers
			echo 	'<tr class="bckMngr">';
			echo 	'<th class="bckMngr" style="width:150px;">name1</th>';		 
			echo 	'<th class="bckMngr" style="width:260px;">role</th>';
			echo 	'<th class="bckMngr" style="width:260px;">SSN</th>';
			echo 	'<th class="bckMngr" style="width:260px;">zipCode</th>';
			echo 	'<th class="bckMngr" style="width:260px;">address</th>';			 
			
			echo '</thead>';


			echo "<tbody>";
			while($row  = $resultSet->fetch(PDO::FETCH_ASSOC)){
				if ($tr_id == 0){$tr_class='class="bckMngrtrEven"'; $tr_id=1;} 		else {$tr_class='class="bckMngrtrOdd"' ; $tr_id=0;}
				echo '<tr '.$tr_class.'>';
					   //notice how to access empId field.
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['name'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['Role'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['address'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['SSN'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['zipCode'].'</td>';
					
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";

		}
		catch (PDOException $e){
			reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
		}	
	break;
	case 6:  /*Query 2: Sample query.*/
		$tr_id=0; $tr_class='class="bckMngrtrOdd"';  //Used to display rows background color.
		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>Query A4 </th></tr>
				
			  </table><br>";

		try { /*Protect execution errors capturing exceptions.*/
			//Query to run
			$queryText = "select DISTINCT c.name,c.phone,r.reservationId,r.tableNumber,r.reservationDateTime,r.arrivalTime from Customer c ,Reservation r WHERE c.phone=r.phone
&& TIME(`reservationDateTime`)<arrivalTime && MONTH(`reservationDateTime`) < DATE_SUB(CURDATE(), INTERVAL 2 MONTH)" ;
			
			//Prepare the query. 
			$resultSet = $mysql->prepare($queryText);  
			
			/*Execute the query. Params are passed in order as they appear in the query text "?" */
			$resultSet->execute(array());
		
			/*** DISPLAY RESULT DATA  -- We will not consider any problem of table shifting because of data size.  *****/
			echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>";	//Try this: May change the whole table size.
			
			echo '<thead>' ;														//HTML Header - Columns headers
			echo 	'<tr class="bckMngr">';
			echo 	'<th class="bckMngr" style="width:150px;">name</th>';		 
			echo 	'<th class="bckMngr" style="width:260px;">phone</th>';
			echo 	'<th class="bckMngr" style="width:260px;">reservationId</th>';
			echo 	'<th class="bckMngr" style="width:260px;">tableNumber</th>';
			echo 	'<th class="bckMngr" style="width:260px;">reservationDateTime</th>';
			echo 	'<th class="bckMngr" style="width:260px;">arrivalTime</th>';

			 
			
			echo '</thead>';


			echo "<tbody>";
			while($row  = $resultSet->fetch(PDO::FETCH_ASSOC)){
				if ($tr_id == 0){$tr_class='class="bckMngrtrEven"'; $tr_id=1;} 		else {$tr_class='class="bckMngrtrOdd"' ; $tr_id=0;}
				echo '<tr '.$tr_class.'>';
					   //notice how to access empId field.
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['name'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['phone'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['reservationId'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['tableNumber'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['reservationDateTime'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['arrivalTime'].'</td>';
					
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";

		}
		catch (PDOException $e){
			reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
		}	
	break;
	case 7:  /*Query 2: Sample query.*/
		$tr_id=0; $tr_class='class="bckMngrtrOdd"';  //Used to display rows background color.
		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>Query A5</th></tr>
				
			  </table><br>";

		try { /*Protect execution errors capturing exceptions.*/
			//Query to run
			$queryText = "select c.name,c.phone from Customer c,Reservation WHERE c.phone=Reservation.phone && arrivalTime<DATE_ADD(TIME(`reservationDateTime`),INTERVAL 10 MINUTE)" ;
			
			//Prepare the query. 
			$resultSet = $mysql->prepare($queryText);  
			
			/*Execute the query. Params are passed in order as they appear in the query text "?" */
			$resultSet->execute(array());
		
			/*** DISPLAY RESULT DATA  -- We will not consider any problem of table shifting because of data size.  *****/
			echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>";	//Try this: May change the whole table size.
			
			echo '<thead>' ;														//HTML Header - Columns headers
			echo 	'<tr class="bckMngr">';
			echo 	'<th class="bckMngr" style="width:150px;">name</th>';		 
			echo 	'<th class="bckMngr" style="width:260px;">phone</th>';
			
			 
			
			echo '</thead>';


			echo "<tbody>";
			while($row  = $resultSet->fetch(PDO::FETCH_ASSOC)){
				if ($tr_id == 0){$tr_class='class="bckMngrtrEven"'; $tr_id=1;} 		else {$tr_class='class="bckMngrtrOdd"' ; $tr_id=0;}
				echo '<tr '.$tr_class.'>';
					   //notice how to access empId field.
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['name'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['phone'].'</td>';
					
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";

		}
		catch (PDOException $e){
			reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
		}	
	break;
	case 8:  /*Query 2: Sample query.*/
		$tr_id=0; $tr_class='class="bckMngrtrOdd"';  //Used to display rows background color.
		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>Query A6</th></tr>
			
			  </table><br>";

		try { /*Protect execution errors capturing exceptions.*/
			//Query to run
			$queryText = "select description , price from  MenuItem where  code NOT IN ( select DISTINCT code   from   Items);" ;
			
			//Prepare the query. 
			$resultSet = $mysql->prepare($queryText);  
			
			/*Execute the query. Params are passed in order as they appear in the query text "?" */
			$resultSet->execute(array());
		
			/*** DISPLAY RESULT DATA  -- We will not consider any problem of table shifting because of data size.  *****/
			echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>";	//Try this: May change the whole table size.
			
			echo '<thead>' ;														//HTML Header - Columns headers
			echo 	'<tr class="bckMngr">';
			echo 	'<th class="bckMngr" style="width:150px;">description</th>';		 
			echo 	'<th class="bckMngr" style="width:260px;">price</th>';
			
			 
			
			echo '</thead>';


			echo "<tbody>";
			while($row  = $resultSet->fetch(PDO::FETCH_ASSOC)){
				if ($tr_id == 0){$tr_class='class="bckMngrtrEven"'; $tr_id=1;} 		else {$tr_class='class="bckMngrtrOdd"' ; $tr_id=0;}
				echo '<tr '.$tr_class.'>';
					   //notice how to access empId field.
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['description'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['price'].'</td>';
					
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";

		}
		catch (PDOException $e){
			reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
		}	
	break;
	case 9:  /*Query 2: Sample query.*/
		$tr_id=0; $tr_class='class="bckMngrtrOdd"';  //Used to display rows background color.
		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>Query A7 </th></tr>

			  </table><br>";

		try { /*Protect execution errors capturing exceptions.*/
			//Query to run
			$queryText = "select DISTINCT Invoice.invNumber,name,Invoice.invoiceDateTime,SUM(qty*price) as subtotal from Invoice,Employee,Items,MenuItem WHERE Employee.empId=Invoice.empId && Items.invNumber=Invoice.invNumber && Items.code=MenuItem.code && DATE(`invoiceDateTime`)<DATE_ADD(NOW(),INTERVAL 15 DAY) GROUP BY Invoice.invNumber,name,Invoice.invoiceDateTime;" ;
			
			//Prepare the query. 
			$resultSet = $mysql->prepare($queryText);  
			
			/*Execute the query. Params are passed in order as they appear in the query text "?" */
			$resultSet->execute(array());
		
			/*** DISPLAY RESULT DATA  -- We will not consider any problem of table shifting because of data size.  *****/
			echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>";	//Try this: May change the whole table size.
			
			echo '<thead>' ;														//HTML Header - Columns headers
			echo 	'<tr class="bckMngr">';
			echo 	'<th class="bckMngr" style="width:150px;">InvoiceNumber</th>';		 
			echo 	'<th class="bckMngr" style="width:260px;">Name</th>';
			echo 	'<th class="bckMngr" style="width:260px;">Invoice Date And Time</th>';
			echo 	'<th class="bckMngr" style="width:260px;">Subtotal</th>';
			
			 
			
			echo '</thead>';


			echo "<tbody>";
			while($row  = $resultSet->fetch(PDO::FETCH_ASSOC)){
				if ($tr_id == 0){$tr_class='class="bckMngrtrEven"'; $tr_id=1;} 		else {$tr_class='class="bckMngrtrOdd"' ; $tr_id=0;}
				echo '<tr '.$tr_class.'>';
					   //notice how to access empId field.
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['invNumber'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['name'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['invoiceDateTime'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['subtotal'].'</td>';
					
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";

		}
		catch (PDOException $e){
			reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
		}	
	break;
	case 10:  /*Query 2: Sample query.*/
		$tr_id=0; $tr_class='class="bckMngrtrOdd"';  //Used to display rows background color.
		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>Query A8 </th></tr>
				
			  </table><br>";

		try { /*Protect execution errors capturing exceptions.*/
			//Query to run
			$queryText = "SELECT t1.operDate,t1.serialNo,t1.model,(t2.cash - t1.cash) AS cashdifference FROM DailyOperation t1,DailyOperation t2 WHERE t1.operation = 'O' AND t2.operation = 'C' AND  t1.serialNo = t2.serialNo AND t1.operDate>=DATE(NOW()) - INTERVAL 40 DAY;" ;
			
			//Prepare the query. 
			$resultSet = $mysql->prepare($queryText);  
			
			/*Execute the query. Params are passed in order as they appear in the query text "?" */
			$resultSet->execute(array());
		
			/*** DISPLAY RESULT DATA  -- We will not consider any problem of table shifting because of data size.  *****/
			echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>";	//Try this: May change the whole table size.
			
			echo '<thead>' ;														//HTML Header - Columns headers
			echo 	'<tr class="bckMngr">';
			echo 	'<th class="bckMngr" style="width:150px;">operDate</th>';		 
			echo 	'<th class="bckMngr" style="width:260px;">serialNo</th>';
			echo 	'<th class="bckMngr" style="width:260px;">model</th>';
			echo 	'<th class="bckMngr" style="width:260px;">cashdifference</th>';
			
			
			 
			
			echo '</thead>';


			echo "<tbody>";
			while($row  = $resultSet->fetch(PDO::FETCH_ASSOC)){
				if ($tr_id == 0){$tr_class='class="bckMngrtrEven"'; $tr_id=1;} 		else {$tr_class='class="bckMngrtrOdd"' ; $tr_id=0;}
				echo '<tr '.$tr_class.'>';
					   //notice how to access empId field.
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['operDate'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['serialNo'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['model'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['cashdifference'].'</td>';
					
					
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";

		}
		catch (PDOException $e){
			reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
		}	
	break;
	case 11:  /*Query 2: Sample query.*/
		$tr_id=0; $tr_class='class="bckMngrtrOdd"';  //Used to display rows background color.
		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>Query A9</th></tr>
				
			  </table><br>";

		try { /*Protect execution errors capturing exceptions.*/
			//Query to run
			$queryText = "select DISTINCT name,waiter from DinnerTable INNER JOIN Employee ON Employee.empId=DinnerTable.waiter INNER JOIN Reservation where Reservation.tableNumber<>DinnerTable.tableNumber && Reservation.address<>DinnerTable.address &&
DATE(`reservationDateTime`)>=DATE(NOW())-INTERVAL 40 DAY" ;
			
			//Prepare the query. 
			$resultSet = $mysql->prepare($queryText);  
			
			/*Execute the query. Params are passed in order as they appear in the query text "?" */
			$resultSet->execute(array());
		
			/*** DISPLAY RESULT DATA  -- We will not consider any problem of table shifting because of data size.  *****/
			echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>";	//Try this: May change the whole table size.
			
			echo '<thead>' ;														//HTML Header - Columns headers
			echo 	'<tr class="bckMngr">';
			echo 	'<th class="bckMngr" style="width:150px;">name</th>';		 
			echo 	'<th class="bckMngr" style="width:260px;">waiter</th>';
			
			
			
			 
			
			echo '</thead>';


			echo "<tbody>";
			while($row  = $resultSet->fetch(PDO::FETCH_ASSOC)){
				if ($tr_id == 0){$tr_class='class="bckMngrtrEven"'; $tr_id=1;} 		else {$tr_class='class="bckMngrtrOdd"' ; $tr_id=0;}
				echo '<tr '.$tr_class.'>';
					   //notice how to access empId field.
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['name'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['waiter'].'</td>';
					
					
					
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";

		}
		catch (PDOException $e){
			reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
		}	
	break;
	case 12:  /*Query 2: Sample query.*/
		$tr_id=0; $tr_class='class="bckMngrtrOdd"';  //Used to display rows background color.
		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>Query A10</th></tr>
				
			  </table><br>";

		try { /*Protect execution errors capturing exceptions.*/
			//Query to run
			
			$queryText = "select distinct e.name, 
   case w.manager
   when w.manager='1' then 'John Smith'
   when w.manager='9' then 'Wes'
   else null
   end as manager
   from DinnerTable d,Reservation r,Waiter w,Employee e WHERE e.empId=w.empId && w.empId=d.waiter && r.tableNumber=d.tableNumber && r.address=d.address" ;
			
			//Prepare the query. 
			$resultSet = $mysql->prepare($queryText);  
			
			/*Execute the query. Params are passed in order as they appear in the query text "?" */
			$resultSet->execute(array());
		
			/*** DISPLAY RESULT DATA  -- We will not consider any problem of table shifting because of data size.  *****/
			echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>";	//Try this: May change the whole table size.
			
			echo '<thead>' ;														//HTML Header - Columns headers
			echo 	'<tr class="bckMngr">';
			echo 	'<th class="bckMngr" style="width:150px;">waiter</th>';		 
			echo 	'<th class="bckMngr" style="width:260px;">manager</th>';
			#echo 	'<th class="bckMngr" style="width:260px;"></th>';
			
			
			
			 
			
			echo '</thead>';


			echo "<tbody>";
			while($row  = $resultSet->fetch(PDO::FETCH_ASSOC)){
				if ($tr_id == 0){$tr_class='class="bckMngrtrEven"'; $tr_id=1;} 		else {$tr_class='class="bckMngrtrOdd"' ; $tr_id=0;}
				echo '<tr '.$tr_class.'>';
					   //notice how to access empId field.
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['name'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['manager'].'</td>';
					
					
					
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";

		}
		catch (PDOException $e){
			reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
		}	
	break;
	case 13:  /*Query 2: Sample query.*/
		$tr_id=0; $tr_class='class="bckMngrtrOdd"';  //Used to display rows background color.
		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>Query A11</th></tr>
				
			  </table><br>";

		try { /*Protect execution errors capturing exceptions.*/
			//Query to run
			
			$queryText = "select distinct i.invNumber,i.invoiceDateTime,c.name,r.phone,SUM(qty*price),
   case  
   when SUM(qty*price)<=300.00 then '$20giftcard'
   when SUM(qty*price)<=500.00 then '$50giftcard'
   when SUM(qty*price)>500.00 then '$100giftcard'
   else null
   end as giftcardamount
   from Reservation r,Invoice i,Employee,Items,MenuItem,Customer c WHERE Employee.empId=i.empId && Items.invNumber=i.invNumber && Items.code=MenuItem.code && c.phone = i.customerPhone && DATE(`invoiceDateTime`)<DATE_ADD(NOW(),INTERVAL 35 DAY) && r.tableNumber=i.tableNumber && r.phone=i.customerPhone GROUP BY r.phone,i.invNumber,c.name,c.phone,i.invoiceDateTime having COUNT(r.phone)>2";
			
			//Prepare the query. 
			$resultSet = $mysql->prepare($queryText);  
			
			/*Execute the query. Params are passed in order as they appear in the query text "?" */
			$resultSet->execute(array());
		
			/*** DISPLAY RESULT DATA  -- We will not consider any problem of table shifting because of data size.  *****/
			echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>";	//Try this: May change the whole table size.
			
			echo '<thead>' ;														//HTML Header - Columns headers
			echo 	'<tr class="bckMngr">';
			echo 	'<th class="bckMngr" style="width:150px;">invNumber</th>';		 
			echo 	'<th class="bckMngr" style="width:260px;">invoiceDateTime</th>';
			echo 	'<th class="bckMngr" style="width:260px;">name</th>';
			echo 	'<th class="bckMngr" style="width:260px;">phone</th>';
			echo 	'<th class="bckMngr" style="width:260px;">SUM(qty*price)</th>';
			echo 	'<th class="bckMngr" style="width:260px;">giftcardamount</th>';

			#echo 	'<th class="bckMngr" style="width:260px;"></th>';
			
			
			
			 
			
			echo '</thead>';


			echo "<tbody>";
			while($row  = $resultSet->fetch(PDO::FETCH_ASSOC)){
				if ($tr_id == 0){$tr_class='class="bckMngrtrEven"'; $tr_id=1;} 		else {$tr_class='class="bckMngrtrOdd"' ; $tr_id=0;}
				echo '<tr '.$tr_class.'>';
					   //notice how to access empId field.
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['invNumber'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['invoiceDateTime'].'</td>';
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['name'].'</td>';
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['phone'].'</td>';
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['SUM(qty*price)'].'</td>';
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['giftcardamount'].'</td>';



					
					
					
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";

		}
		catch (PDOException $e){
			reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
		}	
	break;
	case 14:  /*Query 2: Sample query.*/
		$tr_id=0; $tr_class='class="bckMngrtrOdd"';  //Used to display rows background color.
		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>Query A12</th></tr>
				
			  </table><br>";

		try { /*Protect execution errors capturing exceptions.*/
			//Query to run
			$queryText = "select DISTINCT e.name as waiter,d.tableNumber,c.name as customer,c.phone,r.reservationId,r.reservationDateTime ,r.tableNumber from DinnerTable d INNER JOIN Waiter w LEFT JOIN Employee e ON d.waiter=e.empId LEFT JOIN Reservation r ON r.reservationDateTime='2017:02:07 19:00:00' && r.tableNumber=d.tableNumber && r.address=d.address LEFT JOIN Customer c ON c.phone=r.phone order by e.name" ;
			
			//Prepare the query. 
			$resultSet = $mysql->prepare($queryText);  
			
			/*Execute the query. Params are passed in order as they appear in the query text "?" */
			$resultSet->execute(array());
		
			/*** DISPLAY RESULT DATA  -- We will not consider any problem of table shifting because of data size.  *****/
			echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>";	//Try this: May change the whole table size.
			
			echo '<thead>' ;														//HTML Header - Columns headers
			echo 	'<tr class="bckMngr">';
			echo 	'<th class="bckMngr" style="width:150px;">waiter</th>';		 
			echo 	'<th class="bckMngr" style="width:260px;">assignedtable</th>';
			echo 	'<th class="bckMngr" style="width:260px;">customer</th>';
			echo 	'<th class="bckMngr" style="width:260px;">phone</th>';
			echo 	'<th class="bckMngr" style="width:260px;">reservationId</th>';
			echo 	'<th class="bckMngr" style="width:260px;">reservationDateTime</th>';
			#echo 	'<th class="bckMngr" style="width:260px;">tableNumber</th>';
			
			echo '</thead>';


			echo "<tbody>";
			while($row  = $resultSet->fetch(PDO::FETCH_ASSOC)){
				if ($tr_id == 0){$tr_class='class="bckMngrtrEven"'; $tr_id=1;} 		else {$tr_class='class="bckMngrtrOdd"' ; $tr_id=0;}
				echo '<tr '.$tr_class.'>';
					   //notice how to access empId field.
					echo '<td class="bckMngr" style="text-align:left;width:260px;">'. $row['waiter'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['assignedtable'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['customer'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['phone'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['reservationId'].'</td>';
					echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['reservationDateTime'].'</td>';
					#echo '<td class="bckMngr" style="text-align:center;width:150px;">'.$row['tableNumber'].'</td>';
					
					
							
					
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";

		}
		catch (PDOException $e){
			reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
		}	
	break;



	
    




	///////////////////////// TODO: Implement here the rest of the queries //////////////////////
	   // Put your code here
	/////////////////////////////////////////////////////////////////////////////////////////////

	/***************************************************************************************************************************************************/
	default: /*No valid query or query not implemented yet.*/
		echo '
	    <table width="90%" style="margin: auto;">
			<tr><td>
				<table cellspacing="0" cellpadding="0" valign="top" class="dbaserver" style="width:900px;margin: auto;" >
					<tr class="dbaserver"><th class="month" class="dbaserver" colspan = "2">Invalid query or query not implemented..</th></tr>
				</table>
			</td></tr>
			<tr><td>&nbsp;</td></tr>
		</table>	
		';
	break;
}

echo "<br>";
include ("./copyright.php"); 
?>

</body>
</html>



