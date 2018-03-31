<?php
session_start();
if (isset($_SESSION["user"]) == false)
    header("location: login.php");
require('conn.php');
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
/*if (isset($_GET["edit"])) {
    if ($_GET["edit"]) {
        $editId = $_GET["edit"];
        include("editDAO.php");
        include("updateDAO.php");
    }
}

if ($editId == 0)
    include("userAddDAO.php");*/
?>
<html>
<head>
    <title> users </title>
    <link href="styles.css" rel="stylesheet">
    <script src="jquery-3.2.1.min.js" type="text/javascript"></script>
</head>
<script>
    $(document).ready(function () {
        alert("ready");



        var btnSave = $("#btnSave");
        btnSave.click(function () {
            var userObj = new Object();
            userObj.login = document.getElementById("txtLogin").value;
            userObj.password = document.getElementById("txtPassword").value;
            userObj.name = document.getElementById("txtName").value;
            userObj.email = document.getElementById("txtEmail").value;
            var countries = document.getElementById("cmbCountries");
            userObj.country = countries.options[countries.selectedIndex].value;
            var cities = document.getElementById("cmbCities");
            userObj.city = cities.options[cities.selectedIndex].value;

            if (userObj.login == "") {
                alert("Enter Login!");
                return false;
            }
            else if (userObj.password == "" || userObj.password.length < 8) {
                alert("Enter password and size of password must greater than 8");
                return false;
            }
            else if (userObj.name == "") {
                alert("Enter Name!");
                return false;
            }
            else if (userObj.email == "") {
                alert("Enter Email");
                return false;
            }
            else if (userObj.country == "--Select--") {
                alert("Select Country!");
                return false;
            }
            else if (userObj.city == "--Select--") {
                alert("Select City!");
                return false;
            }

            var dataToSend = {
                "txtLogin": userObj.login,
                "txtPassword": userObj.password,
                "txtName": userObj.name,
                "txtEmail": userObj.email,
                "cmbCountries": userObj.country,
                "cmbCities":userObj.city,
                action: "saveUser"
            };

            var settings = {
                type: "POST",
                dataType: "json",
                url: "apiAjax.php",
                data: dataToSend,
                success: function (result) {
                    alert(result);
                    $("#txtLogin").val("");
                    $("#txtPassword").val("");
                    $("#txtName").val("");
                    $("#txtEmail").val("");
                    $("#cmbCountries").val("--Select--");
                    $("#cmbCities").val("--Select--");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            };

            $.ajax(settings);
            console.log('request sent');
            return true;
        });

        $("#cmbCountries").change(function () {
            console.log("inchange");
            var countryId = $("#cmbCountries").val();
            console.log(countryId);
            var dataToSend = {
                "countryId": countryId,
                action: "fetchCities"
            };

            var settings = {
                type: "POST",
                dataType: "json",
                url: "apiAjax.php",
                data: dataToSend,
                success: function (result) {
                    $("#cmbCities").empty();
                    console.log(result.length);
                    for (var i = 0; i < result.length; i++) {
                        var city = result[i];
                        var opt = $("<option value=" + city.cityId + ">" + city.name + "</option>");
                        $("#cmbCities").append(opt);
                    }
                },
                error:function () {
                    alert("error");
                }
            };

            //Step-3: Make AJAX call
            $.ajax(settings);
            console.log('request sent');
            return false;
        });

        $("#btnClear").click(function () {
            $("#txtLogin").val("");
            $("#txtPassword").val("");
            $("#txtName").val("");
            $("#txtEmail").val("");
            $("#cmbCountries").val("--Select--");
            $("#cmbCities").val("--Select--");
        });
    });
</script>
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
        <span>Country: </span> <select name="cmbCountries" id="cmbCountries">
            <option value="<?php echo $countryId; ?>"><?php echo $countryName ?></option>
            <?php
            $sql = "SELECT * FROM country";
            $result = mysqli_query($conn, $sql);
            $recordsFound = mysqli_num_rows($result);
            if ($recordsFound > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $countryId = $row["id"];
                    $countryName = $row["name"];
                    echo "<option value='" . $countryId . "'>$countryName</option>";
                }
            }
            ?>
        </select><br>
        <span>City: </span> <select name="cmbCities" id="cmbCities">
            <option value="<?php echo $cityId; ?>"><?php echo $cityName ?></option>
        </select>
        <br><input <?php if (isset($isAdmin) && $isAdmin == 1) { ?> checked <?php } ?>
                type="checkbox" name="isAdmin" style="margin-left: -130px;">
        <Span style="margin-left: -130px;"><b>Is He/She Admin?</b></b></Span><br>
        <span id="errorSpan" style="color:red"><?php echo($error); ?></span>
        <input type="button" id="btnSave" name="btnSave" value="Save">
        <input type="reset" id="btnClear" name="btnClear" value="Clear">
    </div>
</div>

</body>
</html>