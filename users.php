<?php
session_start();
if (isset($_SESSION["user"]) == false)
    header("location: login.php");
require('conn.php');
$login=""; $password=""; $name="";
$email=""; $countryId=0; $countryName="--Select--";
$error=""; $editId=0;
if(isset($_GET["edit"])) {
    if($_GET["edit"]) {
        $editId=$_GET["edit"];
        include ("editDAO.php");
        include ("updateDAO.php");
    }
}

if($editId==0)
    include ("userAddDAO.php");
?>

<html>
<head>
    <title> Home </title>
    <link href="styles.css" rel="stylesheet">
    <script src="jquery-3.2.1.min.js" type="text/javascript"></script>
</head>
<script>
function main() {
    var btnSave=document.getElementById("btnSave");
    btnSave.onclick=function() {
        var userObj = new Object();
        userObj.login = document.getElementById("txtLogin").value;
        userObj.password = document.getElementById("txtPassword").value;
        userObj.name = document.getElementById("txtName").value;
        userObj.email = document.getElementById("txtEmail").value;
        var countries = document.getElementById("cmbCountries");
        userObj.country = countries.options[countries.selectedIndex].text;

        if (userObj.login == "") {
            alert("Enter Login!");
            return false;
        }
        else if (userObj.password == "" || userObj.password.length < 8){
            alert("Enter password and size of password must greater than 8");
            return false;
        }
        else if (userObj.name == ""){
            alert("Enter Name!");
            return false;
        }
        else if (userObj.email == ""){
            alert("Enter Email");
            return false;
        }
        else if (userObj.country == "--Select--"){
            alert("Select Country!");
            return false;
        }
        return true;
    }
}
$("#btnClear").click(function(){
    $('userForm')[0].reset();
});
</script>
<body onload="main();">

<?php
if($_SESSION["isAdmin"]==1)
    include("adminMenu.php");
?>
<div>
	<form class="container1" method="POST" name="userForm" action="userManagement.php?edit=<?php echo $editId;?>" style="float:left;">
        <h1>Users</h1>
        <span>Login: </span> <input type="text" id="txtLogin" name="txtLogin" value="<?php echo ($login);?>"><br>
        <span>Password: </span> <input type="password" id="txtPassword" name="txtPassword" value="<?php echo ($password);?>" ><br>
        <span>Name: </span> <input type="text" id="txtName" name="txtName" value="<?php echo ($name);?>"><br>
        <span>Email: </span> <input type="email" id="txtEmail" name="txtEmail" value="<?php echo ($email);?>"><br>
        <span>Country: </span> <select name="cmbCountries" id="cmbCountries">
            <option value="<?php echo $countryId;?>"><?php echo $countryName?></option>
            <?php
            $sql = "SELECT * FROM country";
            $result = mysqli_query($conn, $sql);
            $recordsFound = mysqli_num_rows($result);
            if ($recordsFound > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $countryId=$row["id"];
                    $countryName=$row["name"];
                    echo "<option value='".$countryId."'>$countryName</option>";
                }
            }
            ?>
        </select><br>
        <br><input <?php if(isset($isAdmin) && $isAdmin==1){ ?> checked <?php } ?> type="checkbox" name="isAdmin" style="margin-left: -130px;" >
        <Span style="margin-left: -130px;"><b>Is He/She Admin?</b></b></Span><br>
        <span id="errorSpan" style="color:red"><?php echo($error); ?></span>
        <input type="submit" id="btnSave" name="btnSave" value="Save">
        <input type="reset" id="btnClear" name="btnClear" value="Clear">
	</form>

    <form method="post" action="showRecords.php">
        <div style="float:left;margin-left:20px;">
          <input type="submit" name="btnShow" value="Show Records" >
        </div>
    </form>
</div>
   
</body>
</html>