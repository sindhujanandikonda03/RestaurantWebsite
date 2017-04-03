<?php 
/*************************************************
Description:
		This is responsible for connecting to the Database
Author:
	J.Pastorino  Jan.2017
 *************************************************/ 


/**** CONNECTION PARAMETERS ****/
$db_database 	= 'dbmsassignment'					;  //Database Schema
$db_server_ip	= '192.168.56.101'	;  //DBMS IP
$db_user		= 'root'				;  //Database user
$db_pass		= 'dba'		;  //Database user password.

// Connect to server and select databse.
$dsn = 'mysql:host=localhost;dbname=dbmsassignment'; 
try {
    $mysql = new PDO($dsn,    $db_user,     $db_pass);
    $mysql->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //Throw exception on SQL Error.

} 
catch (PDOException $e) {
	echo '
    <table width="90%" style="margin: auto;">
		<tr><td>
			<table cellspacing="0" cellpadding="0" valign="top" class="dbaserver" style="width:900px;margin: auto;" >
				<tr class="dbaserver"><th class="month" class="dbaserver" colspan = "2">Connection Failed to MySQL Database.</th></tr>
				<tr class="dbaserver">
					<td>Database</td>	<td>'.$db_database.'</td>
				</tr>
				<tr class="dbaserver">
					<td>Server IP</td>	<td>'.$db_server_ip.'</td>
				</tr>
				<tr class="dbaserver">
					<td>User</td>		<td>'.$db_user.'</td>
				</tr>
				<tr class="dbaserver">
					<td>Password</td>	<td>'.$db_pass.'</td>
				</tr>
				<tr class="dbaserver">
					<td colspan="2">'.$e->getMessage().'</td>
				</tr>
			</table>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
	</table>	
	';
	include ("./copyright.php"); 
   
    die;
}

?>