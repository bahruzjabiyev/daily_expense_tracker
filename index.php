<?php

session_start();

if(!isset($_SESSION['email'])){

	header("Location: login.php");

} else {
	$user_email = $_SESSION['email'];
}

include('data.php');

include('js.php');

if(!isset($_GET['year']))
	$_GET['year'] = date("Y",time());
if(!isset($_GET['month']))
	$_GET['month'] = date("m",time());
if(!isset($_GET['day']))
	$_GET['day'] = date("j",time());


$year = $_GET['year'];
$month = $_GET['month'];
$day = $_GET['day'];

$date = $year."-".$month."-".$day;

$q = "SELECT user_name from users where email = '$user_email'";
$r = mysqli_query($dbc, $q);
$user_name = mysqli_fetch_assoc($r)['user_name'];


//echo $date;

?>

<html>

	<head>

		<title><?php echo "Hi, $user_name" ?></title>

		<link rel="stylesheet" href="css/bootstrap.min.css">

		<link rel="stylesheet" href="css/bootstrap-theme.min.css">

		<link rel="stylesheet" href="jquery-ui-1.12.0/jquery-ui-1.12.0/jquery-ui.css">

		<link rel="stylesheet" href="font-awesome-4.6.3/font-awesome-4.6.3/css/font-awesome.css">

	</head>

	<body style="font-family: Georgia">

		<div class="container">

			<div class="row">

				<div class="col-xs-6">

					<h2><?php echo "Hi, ". ucfirst($user_name) ?></h2>
				
					<h3 class="alert alert-success"><?php echo $date ?></h3>

				</div>

			</div>


			<?php

				if(isset($_GET['expenseid'])) {

					$q = "SELECT * FROM tbl_expenses WHERE id = $_GET[expenseid]";
					$r = mysqli_query($dbc, $q);

					$edited = mysqli_fetch_assoc($r);

				}	

				//echo $edited;

				if(isset($_POST['submitted']) == 1 && isset($_POST['name']) && $_POST['name'] != '' && $_POST['amount'] != ''){

					if($_POST['editedid'] != "0") {

						$q = "UPDATE tbl_expenses SET name = '$_POST[name]', amount = '$_POST[amount]', category = '$_POST[category]' WHERE id = $_POST[editedid]";

					} else {

						$q = "INSERT into tbl_expenses (user_email, name, amount, category, date) VALUES ('$user_email', '$_POST[name]', '$_POST[amount]', '$_POST[category]', '$date') ";	

					}

					$r = mysqli_query($dbc, $q);

				}
			
			?>

			<form class="form-inline" role="form" method="get" action="index.php">

				<div class="form-group">					
					<select class="form-control timebox" name="year" id="y-box">

						<option value="2016">2016</option>
						<option value="2017">2017</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>	
						<option value="2020">2020</option>

						<script type="text/javascript">document.getElementById('y-box').value = "<?php echo $_GET['year']?>"</script>	

					</select>	
				</div>	

				<div class="form-group">					
					<select class="form-control timebox" name="month" id="m-box">

						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>	
						<option value="05">May</option>	
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>	
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>

						<script type="text/javascript">document.getElementById('m-box').value = "<?php echo $_GET['month']?>"</script>

					</select>	
				</div>

				<div class="form-group">					
					<select class="form-control timebox" name="day" id="d-box">

						<option value="01">01</option>
						<option value="02">02</option>
						<option value="03">03</option>
						<option value="04">04</option>	
						<option value="05">05</option>	
						<option value="06">06</option>
						<option value="07">07</option>
						<option value="08">08</option>
						<option value="09">09</option>	
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
						<option value="15">15</option>
						<option value="16">16</option>
						<option value="17">17</option>
						<option value="18">18</option>
						<option value="19">19</option>
						<option value="20">20</option>
						<option value="21">21</option>
						<option value="22">22</option>
						<option value="23">23</option>
						<option value="24">24</option>
						<option value="25">25</option>
						<option value="26">26</option>
						<option value="27">27</option>
						<option value="28">28</option>
						<option value="29">29</option>
						<option value="30">30</option>
						<option value="31">31</option>

						<script type="text/javascript">document.getElementById('d-box').value = "<?php echo $_GET['day']?>"</script>


					</select>	
				</div>

				<button type="submit" class="btn btn-info">Go</i></button>
				<span class="pull-right">
					<a class="btn btn-info" href="stats.php?period=day&year=<?php echo $year; ?>&month=<?php echo $month; ?>&day=<?php echo $day; ?>">Daily-stats</a>
					<a class="btn btn-info" href="stats.php?period=week&year=<?php echo $year; ?>&month=<?php echo $month; ?>&day=<?php echo $day; ?>">Weekly-stats</a>
					<a class="btn btn-info" href="stats.php?period=month&year=<?php echo $year; ?>&month=<?php echo $month; ?>&day=<?php echo $day; ?>">Monthly-stats</a>
					<a class="btn btn-info" href="stats.php?period=year&year=<?php echo $year; ?>&month=<?php echo $month; ?>&day=<?php echo $day; ?>">Yearly-stats</a>
					<a class="btn btn-danger" href="logout.php">Logout</a>
				</span>

				
			</form>	

				<form class="form-inline" role="form" method="post" action="index.php?year=<?php echo $year; ?>&month=<?php echo $month; ?>&day=<?php echo $day; ?>">

					<div class="form-group">

						<input class="form-control" value="<?php if(isset($edited)) echo $edited['name']?>" type="text" name="name" id="name" placeholder="What?">

					</div>
					
					<div class="form-group">		

						<input class="form-control" value="<?php if(isset($edited)) echo $edited['amount']?>" type="text" name="amount" id="amount" placeholder="How much?">

					</div>

					<div class="form-group">

						<select class="form-control" name="category" id="category">

							<option <?php if(isset($edited)){if($edited['category'] == 'food') echo ' selected="selected"';}?> value="food">Food</option>
							<option <?php if(isset($edited)){if($edited['category'] == 'clothing') echo ' selected="selected"';}?> value="clothing">Clothing</option>
							<option <?php if(isset($edited)){if($edited['category'] == 'utilities') echo ' selected="selected"';}?> value="utilities">Utilities</option>
							<option <?php if(isset($edited)){if($edited['category'] == 'restaurant') echo ' selected="selected"';}?> value="restaurant">Restaurant</option>	
							<option <?php if(isset($edited)){if($edited['category'] == 'other') echo ' selected="selected"';}?> value="other">Other</option>	

						</select>	

					</div>

					<button type="submit" class="btn btn-success">Save</i></button>
					<input type="hidden" name="submitted" value="1">
					<input type="hidden" name="editedid" value="<?php if(isset($edited)) echo $edited['id']; else echo "0";?>">

				</form>

				
				<div class="table-responsive">
  					<table class="table table-striped">
   						<thead>
   							<tr>
   								<th>#</th>
   								<th>Name</th>
   								<th>Amount</th>
   								<th>Category</th>	
   							</tr>			
   						</thead>
   				
   						
   						<tbody>
   						<?php 
   							$q = "SELECT * FROM tbl_expenses WHERE date='$date' and user_email='$user_email'";
   							$r = mysqli_query($dbc, $q);
   							$i = 0;

   							while($expense = mysqli_fetch_assoc($r)){

   								$i = $i + 1;
   								
   							?>
								<tr id="row_<?php echo $expense['id'];?>">	
		   							<th scope="row"><?php echo $i; ?></th>
		   							<td><?php echo $expense['name'];?></td>
		   							<td><?php echo $expense['amount'];?></td>
		   							<td><?php echo $expense['category'];?> 
		   								<span class="pull-right">
		   									<a href="#" id="del_<?php echo $expense['id'];?>" class="btn btn-danger btn-delete"><i class="fa fa-trash-o"></i></a> 
		   									<a href="index.php?year=<?php echo $year; ?>&month=<?php echo $month; ?>&day=<?php echo $day; ?>&expenseid=<?php echo $expense['id'];?>" class="btn btn-default"><i class="fa fa-edit"></i></a>
		   								</span>
		   							</td>
	   							</tr>

   							<?php } ?>
	   								   							
   						</tbody>
   						

 					</table>
				</div>


		</div>

	</body>

</html>