<?php
require("mysql.php");
$mysqli = MySql::getConnection();

$user_message = "";

if(isset($_POST['submit'])){
	$itemsOrdered = $_POST['item'];
	$quantityOrdered = $_POST['quantity'];

	$sql = "";
	foreach($itemsOrdered as $key=>$itemNumber){
		$quantity = $quantityOrdered[$key];
		$sql .= "INSERT INTO SupplyPurchase (`ItemNumber`, `Quantity`, `Date`, `SupplierID`) VALUES ('$itemNumber', '$quantity', now(), (SELECT `SupplierID` FROM Products WHERE `ItemNumber`='$itemNumber'));";
	}
	if($sql != ""){
		$order = $mysqli->multi_query($sql);
		if(!$order){
			trigger_error("Could not record order. Error: $mysqli->error()");
		}
		else{
			$user_message = "Thank you. Your order has been recorded.";
			do {
				$mysqli->use_result();
			} while($mysqli->next_result());
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
			<h1>Welcome to the Coffee Shop. <small>Order Inventory.</small></h1>
		</div>
		<?php
		if($user_message != ""){
			echo '<div class="alert alert-success" role="alert">'.$user_message.'</div>';
		}
		?>
		<p><a href="http://eecs341.pollack.tech">RETURN TO HOME</a></p>
		<form method="post">
				<?php
				
				echo '<table id="itemTable">';
				echo '<tr><th>Products</th></tr>';
				echo '<tr><td><input type="number" name="quantity[]" placeholder="Qty" style="width: 40px"/><td><select name="item[]">';
				$items = $mysqli->query("SELECT `Name`, `ItemNumber` FROM Products");
				if(!$items){
					trigger_error("There was an error. Error: $mysqli->error");
				}
				
				$itemsJavaScript = '<script>document.getElementById("addItem").onclick = function() {';
				$itemsJavaScript .= 'var tr = document.createElement("tr");';
				$itemsJavaScript .= 'var td = document.createElement("td");';
				$itemsJavaScript .= 'var td_qty = document.createElement("td");';
				$itemsJavaScript .= 'var input = document.createElement("input");';
				$itemsJavaScript .= 'td_qty.appendChild(input);';
				$itemsJavaScript .= 'input.setAttribute("type", "number");';
				$itemsJavaScript .= 'input.setAttribute("name", "quantity[]");';
				$itemsJavaScript .= 'input.setAttribute("placeholder", "Qty");';
				$itemsJavaScript .= 'input.setAttribute("style", "width: 40px");';
				$itemsJavaScript .= 'var select = document.createElement("select");';
				$itemsJavaScript .= 'select.setAttribute("name", "item[]");';
				while($items_row = mysqli_fetch_assoc($items)){
					echo '<option value="'.$items_row['ItemNumber'].'">'.$items_row['Name'].'</option>';
					$itemsJavaScript .= "var item".$items_row['ItemNumber'].' = document.createElement("option");';
					$itemsJavaScript .= "item".$items_row['ItemNumber'].'.setAttribute("value", "'.$items_row['ItemNumber'].'");';
					$itemsJavaScript .= "item".$items_row['ItemNumber'].'.text="'.$items_row['Name'].'";';
					$itemsJavaScript .= 'select.appendChild(item'.$items_row['ItemNumber'].');';
				}
				$itemsJavaScript .= 'tr.appendChild(td_qty);';
				$itemsJavaScript .= 'tr.appendChild(td);';
				$itemsJavaScript .= 'td.appendChild(select);';
				$itemsJavaScript .= 'document.getElementById("itemTable").appendChild(tr);';
				$itemsJavaScript .= 'return false; };</script>';
				echo '</select></td></tr></table>';
				echo '<p><a id="addItem">Add item</a></p>';
				echo $itemsJavaScript;
				
				?>
				<button type="submit" class="btn btn-default" name="submit" value="submit">Submit</button>
		</form>
	</div>
	


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="bootstrap-3.3.6/js/bootstrap.min.js"></script>
</body>
</html>