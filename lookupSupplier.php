<?php
require("mysql.php");
$mysqli = MySql::getConnection();

//Get all of the customers
$suppliers = $mysqli->query("SELECT `SupplierID`, `CompanyName` FROM Suppliers");
if(!$suppliers){
	trigger_error("There was an error. Could not get the suppliers from the database. Error: $mysqli->error");
}

if(isset($_POST['submit'])){
	$supplierID = $_POST['customerID'];
	$supplier = $mysqli->query("SELECT `CompanyName`, `ContactName`, `Phone`, `Address`, `City` FROM Suppliers WHERE `SupplierID`='$supplierID'");
	if(!$supplier){
		trigger_error("There was an error. Could not get the customer from the database. Error: $mysqli->error");
	}
	$supplier = mysqli_fetch_assoc($supplier);
	$companyName = $supplier['CompanyName'];
	$contactName = $supplier['ContactName'];
	$phone = $supplier['Phone'];
	$address = $supplier['Address'];
	$city = $supplier['City'];
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
			<h1>Welcome to the Coffee Shop. <small>Lookup Supplier.</small></h1>
		</div>
		<p><a href="http://eecs341.pollack.tech">RETURN TO HOME</a></p>
		<form method="post">
			<select name="customerID">
				<?php
				while($suppliers_row = mysqli_fetch_assoc($suppliers)){
					echo '<option value="'.$suppliers_row['SupplierID'].'">'.$suppliers_row['CompanyName'].'</option>';
				}
				?>
			</select>
			<button type="submit" name="submit" value="submit" class="btn btn-default">Submit</button>
		</form>
		<?php
		if(isset($supplier)){
			echo '<table><tr><td>Company Name&nbsp;&nbsp;&nbsp;</td><td>'.$companyName.'</td></tr><tr><td>Contact Name</td><td>'.$contactName.'</td></tr><tr><td>Phone</td><td>'.$phone.'</td></tr><tr><td>Address</td><td>'.$address.'</td></tr><tr><td>City</td><td>'.$city.'</td></tr></table>';
		}
		?>
	</div>
	


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="bootstrap-3.3.6/js/bootstrap.min.js"></script>
</body>
</html>