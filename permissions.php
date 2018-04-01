<?php
session_start();
if (isset($_SESSION["user"]) == false)
    header("location: login.php");
$name=""; $description="";  $editId=0;
?>
<html>
<head>
    <title> Permission Management </title>
    <link href="styles.css" rel="stylesheet">
    <script src="jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="permFunctions.js"></script>
</head>
<body>
<?php
if($_SESSION["isAdmin"]==1)
    include("adminMenu.php");
?>
<div>
    <div class="container1" id="perForm" name="perForm" style="float:left;">
        <h1>Permission Management</h1>
        <input type="hidden" id="updateId" name="updateId">
        <span>Permission Name: </span> <input type="text" name="txtName" id="txtName" value="<?php echo $name;?>"><br>
        <span>Description: </span> <input type="text" name="txtDesc" id="txtDesc" value="<?php echo $description;?>"><br>
        <input type="button" id="btnSave" name="btnSave" value="Save">
        <input type="reset" id="btnClear" name="btnClear" value="Clear">
    </div>

    <div >
        <h3>Permissions Table</h3>
        <table border="1" id="myTable">
            <tr >
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </table>
    </div>
</div>
</body>
</html>