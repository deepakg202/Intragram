<!DOCTYPE HTML>
<html>

<head>
	<title>NuStart-Orders</title>
	<?php require_once("./includes/config.php");?>
	<?php require_once("./includes/includers.php"); ?>

</head>

<body>
	<?php require_once("./includes/header.php");?>
	<br /><br /><br /><br /><br />
	<?php
	if(isset($_SESSION['user'])){
		$uid = $user['id'];

		// fetchCartWithUidStat defined in config
		$awaitCart= fetchCartWithUidStat(getDBconn(), $uid, "Awaiting");
		if(count($awaitCart)>0){
		?>
		<table class="table container">
			<thead>
				<tr>
					<th scope="col">Sl No.</th>
					<th scope="col">Field Of Job</th>
					<th scope="col">Description</th>
					<th scope="col">Date Of Order</th>
					<th scope="col">Due Date</th>
					<th scope="col">Status</th>
					<th scope="col">Price</th>
				</tr>
			</thead>
			<tbody>

				<?php 
						$total = 0;
						for($i=0; $i<count($awaitCart); $i++)
						{
							echo '<tr>
							  <th scope="row">'.strval($i+1).'</th>
							  <td>'.$awaitCart[$i]['FieldOfJob'].'</td>
							  <td>'.$awaitCart[$i]['DescriptionOfJob'].'</td>
							  <td>'.$awaitCart[$i]['DateOfOrder'].'</td>
							  <td>'.$awaitCart[$i]['DueDate'].'</td>
							  <td>'.$awaitCart[$i]['Status'].'</td>
							  <td>Rs. '.$awaitCart[$i]['Price'].'</td>
							</tr>';
							$total += $awaitCart[$i]['Price'];
						}

		echo '</table><br/>';
			echo '<h4 class="text-right container">Total: Rs. '.$total.'</h4>';
			?>
			<?php
		}

		else{
			echo '<h2 class="jumbotron container">No Orders Till Now</h2>';
			echo '<br><br><br><br><br><br>';
			} 
	}
	else{
		header('location: login.php');
	}

	?>
			<br><br>
			<br><br>
			<?php require_once("./includes/footer.php");?>
</body>

</html>

