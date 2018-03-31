<?php
session_start();
if (isset($_SESSION["user"]) == false)
    header("location: login.php");
$login = "";
$password = "";
$name = "";
$email = "";
$countryId = 0;
$countryName = "--Select--";
$cityId = 0;
$cityName = "--Select--";
$error = "";
$editId = 0;
?>
<html>
<head>
    <title> Users </title>
    <link href="styles.css" rel="stylesheet">
    <script src="jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="functions.js"></script>
</head>
<body>
<?php
if ($_SESSION["isAdmin"] == 1)
    include("adminMenu.php");
?>
<div>
    <div class="container1" id="userForm" style="float:left;">
        <h1>Users</h1>
        <span>Login: </span> <input type="text" id="txtLogin" name="txtLogin" value="<?php echo($login); ?>"><br>
        <span>Password: </span> <input type="password" id="txtPassword" name="txtPassword"
                                       value="<?php echo($password); ?>"><br>
        <span>Name: </span> <input type="text" id="txtName" name="txtName" value="<?php echo($name); ?>"><br>
        <span>Email: </span> <input type="email" id="txtEmail" name="txtEmail" value="<?php echo($email); ?>"><br>
        <span>Country: </span> <select name="cmbCountries" id="cmbCountries"></select><br>
        <span>City: </span> <select name="cmbCities" id="cmbCities">
            <option value="0">--Select--</option>
        </select>
        <br><input type="checkbox" id="isAdmin" name="isAdmin" style="margin-left: -130px;">
        <Span style="margin-left: -130px;"><b>Is He/She Admin?</b></b></Span><br>
        <span id="errorSpan" style="color:red"><?php echo($error); ?></span>
        <input type="button" id="btnSave" name="btnSave" value="Save">
        <input type="reset" id="btnClear" name="btnClear" value="Clear">
    </div>

    <div >
        <h3>Users Table</h3>
        <table border="1" id="myTable">
            <tr >
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>
        </table>

    </div>
</div>
</body>
</html>