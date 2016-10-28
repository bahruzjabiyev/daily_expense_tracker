<?php

session_start();

include('data.php');

$year = $_GET['year'];
$month = $_GET['month'];
$day = $_GET['day'];

$date = $year."-".$month."-".$day;

$user_email = $_SESSION['email'];

function month_name($i) {

	$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September' , 'October', 'November', 'December');

	return $months[$i-1];

}

?>



<html>

	<head>

		<link rel="stylesheet" href="css/bootstrap.min.css">

		<link rel="stylesheet" href="css/bootstrap-theme.min.css">

		<link rel="stylesheet" href="jquery-ui-1.12.0/jquery-ui-1.12.0/jquery-ui.css">

		<link rel="stylesheet" href="font-awesome-4.6.3/font-awesome-4.6.3/css/font-awesome.css">

	</head>

	<body style="font-family: Georgia">

		<div class="container">
			<div style="margin-top: 5%" class="panel panel-default">
	  		<!-- Default panel contents -->
			    <div class="panel-heading" id="panel-heading" style="color:blue;font-weight: bold">Panel heading</div>
				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>Date</th>
								<th>Food</th>
								<th>Clothing</th>
								<th>Utilities</th>
								<th>Restaurant</th>
								<th>Other</th>	
							</tr>			
						</thead>	
						
						<tbody>
							<?php 

								if ($_GET['period'] == 'day'){
		   							$q = "SELECT date, category, sum(amount) as overallsum FROM tbl_expenses WHERE date='$date' and user_email='$user_email' group by date,category";
		   							$r = mysqli_query($dbc, $q);

		   							$food_expense = '0';
		   							$clothing_expense = '0';
		   							$utilities_expense = '0';
		   							$restaurant_expense = '0';
		   							$other_expense = '0';

		   							while($row = mysqli_fetch_assoc($r)){

		   									   							
		   								if($row['category'] == 'food')
		   									$food_expense = $row['overallsum'];

		   								else if($row['category'] == 'clothing')
		   									$clothing_expense = $row['overallsum'];	

		   								else if($row['category'] == 'utilities')
		   									$utilities_expense = $row['overallsum'];

		   								else if($row['category'] == 'restaurant')
		   									$restaurant_expense = $row['overallsum'];
		   									
		   								else if($row['category'] == 'other')
		   									$other_expense = $row['overallsum'];	

		   							} ?>

		   							<tr>	
			   							<th scope="row">1</th>
			   							<td><?php echo $date;?></td>
			   							<td><?php echo $food_expense;?></td>
			   							<td><?php echo $clothing_expense;?></td>
			   							<td><?php echo $utilities_expense;?></td>
			   							<td><?php echo $restaurant_expense;?></td>
		   								<td><?php echo $other_expense;?></td>
		   							</tr>		

		   						<?php }?><script type="text/javascript">document.getElementById('panel-heading').innerHTML = "<?php echo 'Stats for '.$date?>"</script>	 	
		   					

		   					<?php 

								if ($_GET['period'] == 'week'){

		   							$q = "SELECT date_sub('$date', interval 7 day) as date_one_week_ago";
		   							$r = mysqli_query($dbc, $q);
		   							$date_one_week_ago = mysqli_fetch_assoc($r)['date_one_week_ago'];

		   							$q = "SELECT DISTINCT date from (SELECT date, category, sum(amount) as overallsum FROM tbl_expenses WHERE date<='$date' and date>='$date_one_week_ago' and user_email='$user_email' group by date,category) temp";
		   							//echo $q;

		   							$total_food_expense = 0;
		   							$total_clothing_expense = 0;
		   							$total_utilities_expense = 0;
		   							$total_restaurant_expense = 0;
		   							$total_other_expense = 0;

		   							$r_date = mysqli_query($dbc, $q);

		   							$i = 0;

		   							while($date_row = mysqli_fetch_assoc($r_date)){

		   								$i = $i + 1;

		   								$q = "SELECT * from (SELECT date, category, sum(amount) as overallsum FROM tbl_expenses WHERE date<='$date' and date>='$date_one_week_ago' and user_email='$user_email' group by date,category) tmp WHERE date = '$date_row[date]'";
		   								//echo $q;
		   								$r = mysqli_query($dbc, $q);

		   								$food_expense = '0';
			   							$clothing_expense = '0';
			   							$utilities_expense = '0';
			   							$restaurant_expense = '0';
			   							$other_expense = '0';

			   							while($row = mysqli_fetch_assoc($r)){

			   								if($row['category'] == 'food')
			   									$food_expense = $row['overallsum'];

			   								else if($row['category'] == 'clothing')
			   									$clothing_expense = $row['overallsum'];	

			   								else if($row['category'] == 'utilities')
			   									$utilities_expense = $row['overallsum'];

			   								else if($row['category'] == 'restaurant')
			   									$restaurant_expense = $row['overallsum'];
			   									
			   								else if($row['category'] == 'other')
			   									$other_expense = $row['overallsum'];	

			   							} 

			   							$total_food_expense += $food_expense;
			   							$total_clothing_expense += $clothing_expense;
			   							$total_utilities_expense += $utilities_expense;
			   							$total_restaurant_expense += $restaurant_expense;
			   							$total_other_expense += $other_expense;

			   							?>

			   							<tr>	
				   							<th scope="row"><?php echo $i;?></th>
				   							<td><?php echo $date_row['date'];?></td>
				   							<td><?php echo $food_expense;?></td>
				   							<td><?php echo $clothing_expense;?></td>
				   							<td><?php echo $utilities_expense;?></td>
				   							<td><?php echo $restaurant_expense;?></td>
			   								<td><?php echo $other_expense;?></td>
			   							</tr>

		   					<?php   } ?>		

		   								<tr>	
				   							<th scope="row"><?php echo $i+1;?></th>
				   							<td><b>Total</b></td>
				   							<td><b><?php echo $total_food_expense;?></b></td>
				   							<td><b><?php echo $total_clothing_expense;?></b></td>
				   							<td><b><?php echo $total_utilities_expense;?></b></td>
				   							<td><b><?php echo $total_restaurant_expense;?></b></td>
			   								<td><b><?php echo $total_other_expense;?></b></td>
			   							</tr>
			   							<script type="text/javascript">document.getElementById('panel-heading').innerHTML = "<?php echo 'Stats between '.$date_one_week_ago.' and '.$date?>"</script>
						    <?php    }?>		

						    <?php 

								if ($_GET['period'] == 'month'){

		   							$q = "SELECT date_sub('$date', interval 1 month) as date_one_month_ago";
		   							$r = mysqli_query($dbc, $q);
		   							$date_one_month_ago = mysqli_fetch_assoc($r)['date_one_month_ago'];

		   							$q = "SELECT DISTINCT date from (SELECT date, category, sum(amount) as overallsum FROM tbl_expenses WHERE date<='$date' and date>='$date_one_month_ago' and user_email='$user_email' group by date,category) temp";
		   							//echo $q;

		   							$total_food_expense = 0;
		   							$total_clothing_expense = 0;
		   							$total_utilities_expense = 0;
		   							$total_restaurant_expense = 0;
		   							$total_other_expense = 0;

		   							$r_date = mysqli_query($dbc, $q);

		   							$i = 0;

		   							while($date_row = mysqli_fetch_assoc($r_date)){

		   								$i = $i + 1;

		   								$q = "SELECT * from (SELECT date, category, sum(amount) as overallsum FROM tbl_expenses WHERE date<='$date' and date>='$date_one_month_ago' and user_email='$user_email' group by date,category) tmp WHERE date = '$date_row[date]'";
		   								//echo $q;
		   								$r = mysqli_query($dbc, $q);

		   								$food_expense = '0';
			   							$clothing_expense = '0';
			   							$utilities_expense = '0';
			   							$restaurant_expense = '0';
			   							$other_expense = '0';

			   							while($row = mysqli_fetch_assoc($r)){

			   								if($row['category'] == 'food')
			   									$food_expense = $row['overallsum'];

			   								else if($row['category'] == 'clothing')
			   									$clothing_expense = $row['overallsum'];	

			   								else if($row['category'] == 'utilities')
			   									$utilities_expense = $row['overallsum'];

			   								else if($row['category'] == 'restaurant')
			   									$restaurant_expense = $row['overallsum'];
			   									
			   								else if($row['category'] == 'other')
			   									$other_expense = $row['overallsum'];	

			   							} 

			   							$total_food_expense += $food_expense;
			   							$total_clothing_expense += $clothing_expense;
			   							$total_utilities_expense += $utilities_expense;
			   							$total_restaurant_expense += $restaurant_expense;
			   							$total_other_expense += $other_expense;

			   							?>

			   							<tr>	
				   							<th scope="row"><?php echo $i;?></th>
				   							<td><?php echo $date_row['date'];?></td>
				   							<td><?php echo $food_expense;?></td>
				   							<td><?php echo $clothing_expense;?></td>
				   							<td><?php echo $utilities_expense;?></td>
				   							<td><?php echo $restaurant_expense;?></td>
			   								<td><?php echo $other_expense;?></td>
			   							</tr>

		   					<?php   } ?>		

		   								<tr>	
				   							<th scope="row"><?php echo $i+1;?></th>
				   							<td><b>Total</b></td>
				   							<td><b><?php echo $total_food_expense;?></b></td>
				   							<td><b><?php echo $total_clothing_expense;?></b></td>
				   							<td><b><?php echo $total_utilities_expense;?></b></td>
				   							<td><b><?php echo $total_restaurant_expense;?></b></td>
			   								<td><b><?php echo $total_other_expense;?></b></td>
			   							</tr>
			   							<script type="text/javascript">document.getElementById('panel-heading').innerHTML = "<?php echo 'Stats between '.$date_one_month_ago.' and '.$date?>"</script>
						    <?php    }?>    

						    <?php 

								if ($_GET['period'] == 'year'){

		   							$q = "SELECT date_sub('$date', interval 1 month) as date_one_month_ago";
		   							$r = mysqli_query($dbc, $q);
		   							$date_one_month_ago = mysqli_fetch_assoc($r)['date_one_month_ago'];

		   							$q = "SELECT DISTINCT month from (SELECT category, sum(amount) as overallsum, month(date) as month from tbl_expenses where date like '$year%' and user_email='$user_email' group by category, month ORDER BY `month` ASC) temp";
		   							//echo $q;

		   							$total_food_expense = 0;
		   							$total_clothing_expense = 0;
		   							$total_utilities_expense = 0;
		   							$total_restaurant_expense = 0;
		   							$total_other_expense = 0;

		   							$r_date = mysqli_query($dbc, $q);

		   							$i = 0;

		   							while($date_row = mysqli_fetch_assoc($r_date)){

		   								$i = $i + 1;

		   								$q = "SELECT * from (SELECT category, sum(amount) as overallsum, month(date) as month from tbl_expenses where date like '$year%' and user_email='$user_email' group by category, month ORDER BY `month` ASC ) tmp WHERE tmp.month = '$date_row[month]'";
		   								//echo $q;
		   								$r = mysqli_query($dbc, $q);

		   								$food_expense = '0';
			   							$clothing_expense = '0';
			   							$utilities_expense = '0';
			   							$restaurant_expense = '0';
			   							$other_expense = '0';

			   							while($row = mysqli_fetch_assoc($r)){

			   								if($row['category'] == 'food')
			   									$food_expense = $row['overallsum'];

			   								else if($row['category'] == 'clothing')
			   									$clothing_expense = $row['overallsum'];	

			   								else if($row['category'] == 'utilities')
			   									$utilities_expense = $row['overallsum'];

			   								else if($row['category'] == 'restaurant')
			   									$restaurant_expense = $row['overallsum'];
			   									
			   								else if($row['category'] == 'other')
			   									$other_expense = $row['overallsum'];	

			   							} 

			   							$total_food_expense += $food_expense;
			   							$total_clothing_expense += $clothing_expense;
			   							$total_utilities_expense += $utilities_expense;
			   							$total_restaurant_expense += $restaurant_expense;
			   							$total_other_expense += $other_expense;

			   							?>

			   							<tr>	
				   							<th scope="row"><?php echo $i;?></th>
				   							<td><?php echo month_name($date_row['month']);?></td>
				   							<td><?php echo $food_expense;?></td>
				   							<td><?php echo $clothing_expense;?></td>
				   							<td><?php echo $utilities_expense;?></td>
				   							<td><?php echo $restaurant_expense;?></td>
			   								<td><?php echo $other_expense;?></td>
			   							</tr>

		   					<?php   } ?>		

		   								<tr>	
				   							<th scope="row"><?php echo $i+1;?></th>
				   							<td><b>Total</b></td>
				   							<td><b><?php echo $total_food_expense;?></b></td>
				   							<td><b><?php echo $total_clothing_expense;?></b></td>
				   							<td><b><?php echo $total_utilities_expense;?></b></td>
				   							<td><b><?php echo $total_restaurant_expense;?></b></td>
			   								<td><b><?php echo $total_other_expense;?></b></td>
			   							</tr>
			   							<script type="text/javascript">document.getElementById('panel-heading').innerHTML = "<?php echo 'Stats for '.$year?>"</script>
						    <?php    }?>		
	   							 	
						</tbody>
	 
					</table>

				</div>
			</div>

		</div>

	</body>

