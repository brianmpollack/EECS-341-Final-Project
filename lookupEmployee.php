<?php
require("mysql.php");
$mysqli = MySql::getConnection();

//Get all of the customers
$employees = $mysqli->query("SELECT People.ID AS ID, `Name` FROM Employees INNER JOIN People on Employees.ID=People.ID");
if(!$employees){
	trigger_error("There was an error. Could not get the employees from the database. Error: $mysqli->error");
}

if(isset($_POST['submit'])){
	$employeeID = $_POST['employeeID'];
	$employee = $mysqli->query("SELECT `Name`, `Phone`, `Address`, `City`, `CurrentlyEmployed` FROM Employees INNER JOIN People on Employees.ID=People.ID AND Employees.ID='$employeeID'");
	if(!$employee){
		trigger_error("There was an error. Could not get the employee from the database. Error: $mysqli->error");
	}
	$employee = mysqli_fetch_assoc($employee);
	$name = $employee['Name'];
	$phone = $employee['Phone'];
	$address = $employee['Address'];
	$city = $employee['City'];
	$currentlyEmployed = $employee['CurrentlyEmployed'];
	if($currentlyEmployed == true){
		$currentlyEmployed = "Yes";
	}
	else {
		$currentlyEmployed = "No";
	}
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
			<h1>Welcome to the Coffee Shop. <small>Lookup Employee.</small></h1>
		</div>
		<p><a href="http://eecs341.pollack.tech">RETURN TO HOME</a></p>
		<form method="post">
			<select name="employeeID">
				<?php
				while($employees_row = mysqli_fetch_assoc($employees)){
					echo '<option value="'.$employees_row['ID'].'">'.$employees_row['Name'].'</option>';
				}
				?>
			</select>
			<button type="submit" name="submit" value="submit" class="btn btn-default">Submit</button>
		</form>
		<?php
		if(isset($employee)){
			echo '<table><tr><td>Name</td><td>'.$name.'</td></tr><tr><td>Phone</td><td>'.$phone.'</td></tr><tr><td>Address</td><td>'.$address.'</td></tr><tr><td>City</td><td>'.$city.'</td></tr><tr><td>Currently Employed&nbsp;&nbsp;&nbsp;</td><td>'.$currentlyEmployed.'</td></tr></table>';
		}
		?>
	</div>
	


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="bootstrap-3.3.6/js/bootstrap.min.js"></script>
</body>
</html>