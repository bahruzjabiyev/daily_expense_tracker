<?php

session_start();

include("data.php");

if($_POST){

  $q = "SELECT * from users where email = '$_POST[email]' and password = SHA1('$_POST[password]')";
  $r = mysqli_query($dbc, $q);

  if (mysqli_num_rows($r) == 1){

    $_SESSION['email'] = $_POST['email'];
    header("Location: index.php");


  }  

}

?>

<!DOCTYPE html>
<html>
<head>

  <title>Login Page</title>

  <link rel="stylesheet" href="css/bootstrap.min.css">

  <link rel="stylesheet" href="css/bootstrap-theme.min.css">

  <link rel="stylesheet" href="jquery-ui-1.12.0/jquery-ui-1.12.0/jquery-ui.css">

  <link rel="stylesheet" href="font-awesome-4.6.3/font-awesome-4.6.3/css/font-awesome.css">

</head>

<body style="font-family: Georgia">

<div class="container" style="margin-top: 5%">

  <div class="row">

    <div class="col-md-4 col-md-offset-4">

      <div class="panel panel-info">
        <div class="panel-heading"><b>Login Form</b></div>
        <div class="panel-body">
          
          <form action="login.php" method="post">
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Email" autocomplete="off">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password" autocomplete="off">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>

        </div>
      </div>

      

    </div> <!--column ends -->

  </div> <!--row ends -->

</div> <!--container ends -->

</body>
</html>