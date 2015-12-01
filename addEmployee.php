<?php
require("mysql.php");
$mysqli = MySql::getConnection();

$user_message = "";

if(isset($_POST['submit'])){
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$insert = $mysqli->query("INSERT INTO People (`Name`, `Phone`, `Address`, `City`) VALUES ('$name', '$phone', '$address', '$city')");
	if(!$insert){
		trigger_error("There was an error. Could not insert into the database. Error: $mysqli->error");
	}
	else {
		$employee_id = $mysqli->insert_id;
		$insert = $mysqli->query("INSERT INTO Customers (`ID`, `CurrentlyEmployed`) VALUES ('$employee_id', true)");
		if(!$insert){
			trigger_error("There was an error. Could not insert into the database. Error: $mysqli->error");
		}
		else {
			$user_message = "Thank you. The employee has successfully been added.";
		}
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
			<h1>Welcome to the Coffee Shop. <small>Add a New Employee.</small></h1>
		</div>
		<?php
		if($user_message != ""){
			echo '<div class="alert alert-success" role="alert">'.$user_message.'</div>';
		}
		?>
		<p><a href="http://eecs341.pollack.tech">RETURN TO HOME</a></p>
		<form method="post">
			<div class="row">
				<div class="col-md-4">
					<input type="text" name="name" class="form-control" placeholder="Name"/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<input type="text" name="address" class="form-control" placeholder="Address"/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<input type="text" name="city" class="form-control" placeholder="City"/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<input type="text" name="phone" class="form-control" placeholder="Phone"/>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<button type="submit" class="btn btn-default" name="submit" value="submit">Submit</button>
				</div>
			</div>
				
				
				
				
				
				
		</form>
	</div>
	


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="bootstrap-3.3.6/js/bootstrap.min.js"></script>
</body>
</html>