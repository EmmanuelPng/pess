<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Police Emergency Service System</title>
	
	<link href="EmmanuelStyle.css" rel="stylesheet" type="text/css">
	
</head>

<body>
	
	<script>
	function Emmanuel()
		{
		var x=document.forms["frmLogCall"]["callerName"].value;
		if (x==null || x=="")
			{
				alert("Caller Name is required.");
				return false;
			}
		//may add code for validating other inputs
	}
	</script>
	
	<?php require "nav.php";?> <!-- menu bar code-->
	<?php require "db.php"; //database deails
	//create database connection
	$mysqli = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
	//check connection
	if ($mysqli->connect_errno)
	{
		die("Unable to connect to Database: ".$mysqli->connect_errno);
	}
	$sql = "SELECT * FROM incidenttype";
	//Test sql command in $sql, if error display error msg and exit.
	if (!($stmt = $mysqli->prepare($sql)))
	{
		die("Command error: ".$mysqli->errno);
	}
	//Check can run Command?
	if (!$stmt->execute())
	{
		die("Cannot run SQL command: ".$stmt->errno);
	}
	//Check any data in result set
	if (!($resultset = $stmt->get_result())){
		die("No data in resultset: ".$stmt->errno);
	}
	$incidentType; //an array variable
	
	while ($row = $resultset->fetch_assoc()){
		//create an associative array of $incidentType {incident_type_id, incident_type_desc}
		$incidentType [$row["incidentTypeId"]] = $row["incidentTypeDesc"];
	}
	$stmt->close();
	
	$resultset->close();
	
	$mysqli->close();
	
	?>
	
	<fieldset>
	<legend>Log Call</legend><div id="form1">
		<form id="form1" name="frmLogCall" method="post" action="dispatch.php" onSubmit="return Emmanuel();">
		<table width="40%" border="1" align="center" cellpadding="4" cellspacing="4">
			<tr>
			<td width="50%">Caller's Name:</td>
			<td width="50%"><input type="text" name="callerName" id="callerName"></td>
			</tr>
			
			<tr>
			<td width="50%">Contact No:</td>
			<td width="50%"><input type="text" name="contactNo" id="contactNo"></td>
			</tr>
			
			<tr>
			<td width="50%">Location:</td>
			<td width="50%"><input type="text" name="location" id="location"></td>
			</tr>
			
			<tr>
			<td width="50%">Incident Type:</td>
			<td width="50%"><select name="incidentType" id="incidentType">
				<?php
				foreach($incidentType as $key=> $value){
					?>
				<option value="<?php echo $key ?>">
					<?php echo $value ?></option>
				<?php }?>
				</select></td>
			</tr>
			<tr>
			<td width="50%">Discription:</td>
			<td width="50%"><textarea name="incidentDesc" id="incidentDesc" cols="45" rows="5"></textarea></td>
			</tr>
			
			<tr>
			<td><input type="reset" name="cancelProcess" id="cancelProcess" value="Reset"></td>
			<td><input type="submit" name="btnProcessCall" id="btnProcessCall" value="Process Call"></td>
			</tr>
			</table>
				
		</form></div>
	</fieldset>
	
</body>
</html>