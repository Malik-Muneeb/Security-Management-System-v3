<?php
session_start();
require('conn.php');
$error = "";
$login=""?>
<html>
<head>
    <title> Login </title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="jquery-3.2.1.min.js" type="text/javascript"></script>
</head>
<script>
    function main() {
        var btn = document.getElementById('btnLogin');
        btn.onclick = function () {
            var login = document.getElementById('txtLogin').value;
            var password = document.getElementById('txtPassword').value;
            if (login == "") {
                alert("Enter Login Name first!!!");
                return false;
            }
            else if (password == "") {
                alert("Enter Password!!!");
                return false;
            }
            return true;
        }

        $("#reset").click(function(){
            $('loginForm')[0].reset();
        });
    }
</script>
<?php include ("loginDAO.php");?>
<body class="bodyContainer" onload="main();">
<h1 style="background-color:#006600;color:white;float;margin-right:1050px">Security Manager</h1>
<div class="container" style="float:left;">
    <h1>Admin Login</h1>
    <form name="loginForm" method="post" action="login.php">
        Login: <input id="txtLogin" name="txtLogin" value="<?php echo ($login); ?>"/> <br>
        Password: <input id="txtPassword" name="txtPassword" type="password"/> <br>
        <span id="errorSpan" style="color:red"><?php echo($error); ?></span>
        <input type="submit" name="btnLogin" id="btnLogin" value="Login"/>
        <input class="cancelbtn" type="reset" value="cancel" id="btnReset"/>
    </form>
</div>
</body>
</html>