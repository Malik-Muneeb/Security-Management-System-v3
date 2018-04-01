<?php
session_start();
if (isset($_SESSION["user"]) == false)
    header("location: login.php");
?>
<html>
<head>
    <title> User-Role </title>
    <link href="styles.css" rel="stylesheet">
    <script src="jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="userRoleFunctions.js"></script>
</head>
<body>
<?php
if ($_SESSION["isAdmin"] == 1)
    include("adminMenu.php");
?>

<div>
    <form class="container1" name="userRoleForm" style="float:left;">
        <h1>User-Role Management</h1>
        <input type="hidden" id="updateId" name="updateId">
        <span>User: </span> <select name="cmbUser" id="cmbUser"></select><br>
        <span>Role: </span> <select name="cmbRole" id="cmbRole"></select><br><br>
        <input type="button" id="btnSave" name="btnSave" value="Save">
        <input type="reset" id="btnClear" name="btnClear" value="Clear">
    </form>

    <div >
        <h3>User-Role Table</h3>
        <table border="1" id="myTable">
            <tr >
                <th>ID</th>
                <th>User</th>
                <th>Role</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </table>
    </div>
</div>

</body>
</html>