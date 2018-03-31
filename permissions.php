<?php
session_start();
if (isset($_SESSION["user"]) == false)
    header("location: login.php");
include ("conn.php");
$name=""; $description="";  $editId=0;
if(isset($_GET["edit"])) {
    if($_GET["edit"]) {
        $editId=$_GET["edit"];
        include ("perEditDAO.php");
        include ("updatePerDAO.php");
    }
}

if($editId==0)
    include ("addPerDAO.php");
?>
<html>
<head>
    <title> Permission Management </title>
    <link href="styles.css" rel="stylesheet">
    <script src="jquery-3.2.1.min.js" type="text/javascript"></script>
    <script>
        function main() {
            var btnSave = document.getElementById("btnSave");
            btnSave.onclick = function () {
                var perObj = new Object();
                perObj.perName = document.getElementById("txtName").value;
                perObj.perDesc = document.getElementById("txtDesc").value;
                if (perObj.perName == "") {
                    alert("Enter Permission!");
                    return false;
                }

                else if (perObj.perDesc == "") {
                    alert("Enter permissions's description");
                    return false;
                }
                return true;
            }
        }
        $("#btnClear").click(function(){
            $('perForm')[0].reset();
        });
    </script>
</head>
<body onload="main();">

<?php
if($_SESSION["isAdmin"]==1)
    include("adminMenu.php");
?>
<div>
    <form class="container1" method="post" action="permissionManagement.php?edit=<?php echo $editId;?>" name="perForm" style="float:left;">
        <h1>Permission Management</h1>
        <span>Permission Name: </span> <input type="text" name="txtName" id="txtName" value="<?php echo $name;?>"><br>
        <span>Description: </span> <input type="text" name="txtDesc" id="txtDesc" value="<?php echo $description;?>"><br>
        <input type="submit" id="btnSave" name="btnSave" value="Save">
        <input type="reset" id="btnClear" name="btnClear" value="Clear">
    </form>

    <form method="post" action="showPermissions.php">
        <div style="float:left;margin-left:20px;">
            <input type="submit" name="btnShow" value="Show Permissions" >
        </div>
    </form>
</div>

</body>
</html>