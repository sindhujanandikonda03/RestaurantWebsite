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
////////////////////////////////////////////////////////
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
if (isset($_GET["option"])	)	{ $OPTION_ID = intval($_GET["option"]); 	 }		else {	$OPTION_ID =1;	}	
switch ($OPTION_ID) {
	/************************************************************************************************************************************************/
	case 5:  /*Option 1: Add new Employee.*/
		if (isset($_POST["optionAdd"])	)	{ $optionAdd = intval($_POST["optionAdd"]); 	 }		else {	$optionAdd =0;	}	
		/*optionAdd will tell me is I have to show the form or process form data. Uses POST as I'm sending a form data.*/

		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>**Adding new reservation to the system**</th></tr>
				
			  </table><br>";
		switch ($optionAdd){ 
			case 0:	/*First invocation. Display Form.*/
				echo '
				    <table width="90%" style="margin: auto;">
						<tr><td>
							<form name="addReservation" id="addReservation" method="POST" action="./yourphp.php?option=5">
							<input type="hidden" name="optionAdd" id="optionAdd" value="1" >
							<table cellspacing="0" cellpadding="0" valign="top" class="dbaserver" style="width:500px;margin: auto;" >
								<tr class="dbaserver"><th class="month" class="dbaserver" colspan = "2">New Reservation Form</th></tr>
								<tr>
									<td>name</td>			<td><input type="text" name="name" id="name" style="width:250px;"></td>
								</tr>
								<tr>
									<td>reservationDateTime</td>			<td><input type="text" name="reservationDateTime" id="reservationDateTime" ></td>
								</tr>
								<tr>
									<td>reservationId</td>		<td><input type="text" name="reservationId" id="reservationId" style="width:250px;"></td>
								</tr>
								<tr>
									<td>address</td>			<td><input type="text" name="address" id="address" ></td>
								</tr>
								<tr>
									<td>tableNumber</td>	<td><input type="text" name="tableNumber" id="tableNumber" ></td>
								</tr>
								<tr>
									<td>phone</td>			<td><input type="text" name="phone" id="phone" ></td>
								</tr>
								<tr>
									<td>arrivalTime</td>			<td><input type="text" name="arrivalTime" id="arrivalTime" ></td>
								</tr>
								<tr>
									<td colspan="2" style="text-align:center;">
										<input 	name="addSubmit" 	type="button" 
										onclick="javascript:this.form.submit();" 
		 								class="normalbtn"	value="Confirm Add Reservation"> 	
					 			   	</td>
								</tr>
							</table>
							</form>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
					</table>	
					';
			break;
			case 1:
			    $name = $_POST["name"]; $vArgs["reservationDateTime"] = $_POST["reservationDateTime"];	$vArgs["reservationId"] = $_POST["reservationId"];
			    $vArgs["address"] = $_POST["address"];	$vArgs["tableNumber"] = $_POST["tableNumber"];	$vArgs["arrivalTime"] = $_POST["arrivalTime"];
			    $phone = $_POST["phone"];
			    try{
                   $stmt=null;
                   $queryText ="INSERT INTO dbmsassignment.Customer(name,phone) SELECT * FROM (SELECT '$name', '$phone' ) AS Temp WHERE NOT EXISTS (SELECT * FROM dbmsassignment.Customer c WHERE c.phone = '$phone' );";
                   $stmt= $mysql->prepare($queryText);
                   if ($stmt){  
                        $stmt->execute(array());
                   }
                }
                catch (PDOException $e){

                    reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
                }
                try{
                   $stmt=null;
                   $queryText ="INSERT INTO dbmsassignment.Reservation(reservationDateTime, reservationId, phone, address, tableNumber,arrivalTime) VALUES (?,?,?,?,?,?);";
                   $stmt= $mysql->prepare($queryText);
                   if ($stmt){  
                        $stmt->execute(array($vArgs["reservationDateTime"],$vArgs["reservationId"],$phone,$vArgs["address"],$vArgs["tableNumber"],$vArgs["arrivalTime"]));
                        echo '
						    <table width="90%" style="margin: auto;">
								<tr><td>
									<table cellspacing="0" cellpadding="0" valign="top" class="dbaserver" style="width:900px;margin: auto;" >
										<tr class="dbaserver"><th class="month" class="dbaserver" colspan = "2">Insertion OK.</th></tr>
									</table>
								</td></tr>
								<tr><td>&nbsp;</td></tr>
							</table>	
							'; 
                   }
                }
                catch (PDOException $e){

                    reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
                }
            break;
		}
	break;
	case 6: /*Data Manipulation DM2*/
	    if (isset($_POST["optionDel"])	)	{ $optionDel = intval($_POST["optionDel"]); 	 }		else {	$optionDel =0;	}	

		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>List/Delete Reservations. </th></tr>
				<tr class='bckMngr'><td class='bckMngr'>List and Delete reservations for the Employees.</td></tr>
			  </table><br>";
		switch ($optionDel){ 
			case 0:	/*First invocation. List Employees.*/
				$tr_id=0; $tr_class='class="bckMngrtrOdd"';  //Used to display rows background color.

				try {  
					 
					$queryText = "SELECT reservationDateTime,reservationId,phone,address,tableNumber,arrivalTime FROM dbmsassignment.Reservation ORDER BY reservationId;" ;
					
					//Prepare the query. 
					$resultSet = $mysql->prepare($queryText);  
					
					/*Execute the query. Params are passed in order as they appear in the query text "?" */
					$resultSet->execute(array());
				
					/*** DISPLAY RESULT DATA  -- We will not consider any problem of table shifting because of data size.  *****/
					echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>";	
					
					echo '<thead>' ;														
					echo 	'<tr class="bckMngr">';
					echo 	'<th class="bckMngr" style="width:150px;">reservationDateTime</th>';		
					echo 	'<th class="bckMngr" style="width:100px;">reservationId</th>';		
					echo 	'<th class="bckMngr" style="width:160px;">phone</th>';		
					echo 	'<th class="bckMngr" style="width:250px;">address</th>';
					echo 	'<th class="bckMngr" style="width:100px;">tableNumber</th>';
					echo 	'<th class="bckMngr" style="width:100px;">arrivalTime</th>';
					echo 	'<th class="bckMngr" style="width:100px;"></th>';
					echo '</thead>';


					echo "<tbody>";
					while($row  = $resultSet->fetch(PDO::FETCH_ASSOC)){
						if ($tr_id == 0){$tr_class='class="bckMngrtrEven"'; $tr_id=1;} 		else {$tr_class='class="bckMngrtrOdd"' ; $tr_id=0;}
						echo '<tr '.$tr_class.'>';
							echo '<td class="bckMngr" style="text-align:left;width:150px;">'. $row['reservationDateTime'].'</td>';
                            echo '<td class="bckMngr" style="text-align:left;width:150px;">'. $row['reservationId'].'</td>';
							echo '<td class="bckMngr" style="text-align:center;width:100px;">'. $row['phone'].'</td>';
							echo '<td class="bckMngr" style="text-align:center;width:160px;">'.$row['address'].'</td>';
							echo '<td class="bckMngr" style="text-align:left;width:250px;">'. $row['tableNumber'].'</td>';
							echo '<td class="bckMngr" style="text-align:center;width:100px;">'.$row['arrivalTime'].'</td>';
							echo '<td class="bckMngr" style="text-align:center;width:100px;">';
							echo "
									<form name='delete' id='delete_".$row["reservationId"]."' method='POST'>
										<input type='hidden' name='optionDel'  VALUE='1'/>
										<input type='hidden' name='reservationId' VALUE='".$row["reservationId"]."'/>
										<a href='#' onclick='document.getElementById(".'"'."delete_".$row["reservationId"].'"'.").submit();'>delete</a>
									</form>";
							echo '</td>';
						echo '</tr>';
					}
					echo "</tbody>";
					echo "</table>";

				}
				catch (PDOException $e){
					reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
				}	
			break;
			case 1: /*** Delete Reservation based on the parameters ***/  
				if (isset($_POST["reservationId"])	)	{ $vArgs["reservationId"] = intval($_POST["reservationId"]); 	 }		else {	reportErrorAndDie(100,"Insuficient Data.");	}

				try{
					$stmt=null;
					$qry ="DELETE FROM dbmsassignment.Reservation WHERE reservationId=?;";
					$stmt= $mysql->prepare($qry);

					if ($stmt){	 
						$stmt->execute(array( $vArgs["reservationId"] ) ) ;
						echo '
						    <table width="90%" style="margin: auto;">
								<tr><td>
									<table cellspacing="0" cellpadding="0" valign="top" class="dbaserver" style="width:900px;margin: auto;" >
										<tr class="dbaserver"><th class="month" class="dbaserver" colspan = "2">Reservation Deleted.</th></tr>
									</table>
								</td></tr>
								<tr><td>&nbsp;</td></tr>
							</table>	
							'; 
					}
				}
				catch (PDOException $e){
					reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );

					/* TIP/Question: 	What happend if the employee is already defined as a KitchenStaff, waiter or Cashier? What if is a waiter and has tables that references him/her? 
										When we should stop?  Think about. */

				}

			break;
        }
    break;
    case 7:	/*Option 3: Change the price of menuitems*/
		if (isset($_POST["optionAdd"])	)	{ $optionAdd = intval($_POST["optionAdd"]); 	 }		else {	$optionAdd =0;	}	
		/*optionAdd will tell me is I have to show the form or process form data. Uses POST as I'm sending a form data.*/

		echo "<table  style='margin: auto;width:750px;' class='disponibilidad'>
				<tr class='bckMngr'><th class='bckMngr'>**Adding new reservation to the system**</th></tr>
				
			  </table><br>";
		switch ($optionAdd){ 
			case 0:	/*First invocation. List Menuitems.*/
			    echo '
				    <table width="90%" style="margin: auto;">
						<tr><td>
						    <form name="addReservation" id="addReservation" method="POST" action="./yourphp.php?option=7">
							<input type="hidden" name="optionAdd" id="optionAdd" value="1" >
							<table cellspacing="0" cellpadding="0" valign="top" class="dbaserver" style="width:500px;margin: auto;" >
								<tr class="dbaserver"><th class="month" class="dbaserver" colspan = "2">New Reservation Form</th></tr>
								<tr>
									<td>price</td>			<td><input type="text" name="price" id="price" style="width:250px;"></td>
								</tr>
								<tr>
									<td>percentage</td>			<td><input type="text" name="percentage" id="percentage" ></td>
								</tr>
								<tr>
									<td colspan="2" style="text-align:center;">
										<input 	name="addSubmit" 	type="button" 
										onclick="javascript:this.form.submit();" 
		 								class="normalbtn"	value="UpdateTheItemPrice"> 	
					 			   	</td>
								</tr>
							</table>
							</form>
						</td></tr>
						<tr><td>&nbsp;</td></tr>
					</table>	
					';
            break;
            case 1:
            $price=$_POST["price"]; $percentage=$_POST["percentage"];
            $ratio=$percentage/100;
            
            #echo $ratio;
            

            try{
            $stmt=null;
            $queryText= "UPDATE dbmsassignment.MenuItem SET `price`=`price`+(`price`*$ratio) WHERE `price` < '$price';";
            #echo $price;
            #echo $percentage;
            $stmt = $mysql->prepare($queryText);  
					
					/*Execute the query. Params are passed in order as they appear in the query text "?" */
			#$stmt->execute(array());
			if($stmt){
			   $stmt->execute(array() ) ;

                
				echo '
						    <table width="90%" style="margin: auto;">
								<tr><td>
									<table cellspacing="0" cellpadding="0" valign="top" class="dbaserver" style="width:900px;margin: auto;" >
										<tr class="dbaserver"><th class="month" class="dbaserver" colspan = "2">**Updated**</th></tr>

									</table>
								</td></tr>
								<tr><td>&nbsp;</td></tr>
							</table>	
							'; 
            }	
			}
			catch (PDOException $e){
					reportErrorAndDie($e->getCode(), "SQL Exception:". $e->getMessage() );
				}
			break;			

		}
	break; 

    default: /*No valid option.*/
		echo '
	    <table width="90%" style="margin: auto;">
			<tr><td>
				<table cellspacing="0" cellpadding="0" valign="top" class="dbaserver" style="width:900px;margin: auto;" >
					<tr class="dbaserver"><th class="month" class="dbaserver" colspan = "2">Invalid Option or Not implemented..</th></tr>
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


