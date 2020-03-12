<?php
session_start();
require_once "bg/con.php";

if (isset($_POST['logout_btn']))
    unset($_SESSION['id']);

if (!isset($_SESSION['id']))
    header('location:index.html');


//auth_2fa is the test table containing test data
$query = mysqli_query($conn, "SELECT * from authy_2fa where id={$_SESSION['id']}");
$row = mysqli_fetch_assoc($query);

if($row['2fa_status']=='on' && $_SESSION['2fa_verified']!=true){
    unset($_SESSION['id']);
    header('location:index.html');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to 2FA Setup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="main.js"></script>
</head>

<body>
    <div class="jumbotron col-lg-6" style="margin-top:10%;margin-left:25%;">
        <h2>Hello <?php echo $row['first_name']; ?>
            <form method="POST" style="float: right">
                <button class="btn btn-primary" type="submit" name="logout_btn" value="logout">Logout</button>
            </form>
        </h2>
        <br><br>
        <pr> Your 2 factor authentication is <?php echo $row['2fa_status']; ?>.

            <?php
            if ($row['2fa_status'] == 'on')
                echo '<button id="activate_button" type="button" class="btn btn-dark" name="deactivate_button" onclick="deactivate_2fa();">Deactivate</button>';
            else
                echo '<button id="activate_button" type="button" class="btn btn-dark" name="activate_button" onclick="show_data_section();">Activate</button>';
            ?>
        </pr>
    </div>
    <div class="container col-lg-6 " style="visibility:hidden;" id="data-container">
        <form method="javascript:void(0);" id="2fa_activation_form">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Email</span>
                </div>
                <input type="text" class="form-control" name="email" value=<?php echo $row['email']; ?> readonly>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Phone</span>
                </div>
                <input type="text" class="form-control" placeholder="Type your phone number" name="phone">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Country-code</span>
                </div>
                <input type="text" class="form-control" placeholder="Type your country code" name="country_code">
            </div>
            <button id="data_button" type='button' class="btn btn-success"onclick="activate_2fa();">Activate 2FA</button>
        </form>
    </div>
</body>

</html>