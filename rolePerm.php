<?php
session_start();
if (isset($_SESSION["user"]) == false)
    header("location: login.php");
?>
<html>
<head>
    <title> Role-Permission </title>
    <link href="styles.css" rel="stylesheet">
    <script src="jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="rolePermFunctions.js"></script>
</head>
<body>
<?php
if ($_SESSION["isAdmin"] == 1)
    include("adminMenu.php");
?>
<div>
    <div class="container1" style="float:left;">
        <h1>Role-Permissions Management</h1>
        <input type="hidden" id="updateId" name="updateId">
        <span>Role: </span><select name="cmbRole" id="cmbRole"></select><br>
        <span>Permission: </span> <select name="cmbPer" id="cmbPer"></select><br><br>
        <input type="button" id="btnSave" name="btnSave" value="Save">
        <input type="reset" id="btnClear" name="btnClear" value="Clear">
    </div>

    <div >
        <h3>Role-Permissions Table</h3>
        <table border="1" id="myTable">
            <tr >
                <th>ID</th>
                <th>Role</th>
                <th>Permission</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </table>
    </div>
</div>
</body>
</html>