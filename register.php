<?php
require "conn.php";

if($_POST["username"] != "" & $_POST["username"] != null & $_POST["email"] != "" & $_POST["email"] != null & $_POST["password"] != "" & $_POST["password"] != null){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
//check if user name exist
    $sql = "SELECT * FROM user where username = \"$username\"";
    $result = $conn->query($sql);
    if($result->num_rows >= 1){
        echo "<script language=\"javascript\">";
        echo "alert(\"User Name Occupaid\")";
        echo "location.href=\"index.html\"";
        echo "</script>";
    }
//check if email exist
    $sql = "SELECT * FROM user where email = \"$email\"";
    $result = $conn->query($sql);
    if($result->num_rows >= 1){
        echo "<script language=\"javascript\">";
        echo "alert(\"Email existed\")";
        echo "location.href=\"index.html\"";
        echo "</script>";
    }
//Creat new user
    $sql = "INSERT INTO user (username,email,password) VALUES (\"$username\",\"$email\",\"$password\")";
    if($conn->query($sql) === TRUE){
        echo "<script language=\"javascript\">";
        echo "location.href=\"index.html\"";
        echo "</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<!-- saved from url=(0061)http://webapplayers.com/inspinia_admin-v2.6.2.1/register.html -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Register</title>

    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/font-awesome.css" rel="stylesheet">
    <link href="./css/custom.css" rel="stylesheet">
    <link href="./css/animate.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">>colder</h1>
            </div>
            <h3>Register to >colder</h3>
            <p>Create account to see it in action.</p>
            <form class="m-t" role="form" action="register.php" method="post">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Name" required="">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <div class="form-group">
                        <div class="checkbox i-checks"><label class=""> <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div><i></i> Agree the terms and policy </label></div>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="./index.html">Login</a>
            </form>
            <p class="m-t"> <small>>colder © 2016</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="./js/jquery-2.1.1.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="./js/icheck.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>



</body></html>
<?php
require "conn_close.php";
?>
