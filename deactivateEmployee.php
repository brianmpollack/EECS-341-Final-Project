<?php
require("mysql.php");
$mysqli = MySql::getConnection();

$user_message = "";

if(isset($_POST['submit'])){
	$employeeID = $_POST['employeeID'];
	$deactivation = $mysqli->query("UPDATE Employees SET `CurrentlyEmployed`='0' WHERE `ID`='$employeeID'");
	if(!$deactivation){
		$user_message = "There was an error. Could not deactivate the employee. Error: $mysqli->error";
	}
	else {
		$user_message = "Employee successfully deactivated.";
	}
}

//Get all of the employees who are active
$employees = $mysqli->query("SELECT People.ID AS ID, `Name` FROM Employees INNER JOIN People on Employees.ID=People.ID WHERE Employees.CurrentlyEmployed='1'");
if(!$employees){
	trigger_error("There was an error. Could not get the employees from the database. Error: $mysqli->error");
}
?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>EECS 341</title>
	<link href="bootstrap-3.3.6/css/bootstrap.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<div class="container">
		<div class="page-header">
			<h1>Welcome to the Coffee Shop. <small>Deactivate Employee.</small></h1>
		</div>
		<?php
		if($user_message != ""){
			echo '<div class="alert alert-success" role="alert">'.$user_message.'</div>';
		}
		?>
		<p><a href="http://eecs341.pollack.tech">RETURN TO HOME</a></p>
		<form method="post">
			<p>List of active employees:</p>
			<select name="employeeID">
				<?php
				while($employees_row = mysqli_fetch_assoc($employees)){
					echo '<option value="'.$employees_row['ID'].'">'.$employees_row['Name'].'</option>';
				}
				?>
			</select>
			<button type="submit" name="submit" value="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
	


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="bootstrap-3.3.6/js/bootstrap.min.js"></script>
</body>
</html>