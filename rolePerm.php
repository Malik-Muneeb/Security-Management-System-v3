<?php
session_start();
if (isset($_SESSION["user"]) == false)
    header("location: login.php");
include("conn.php");
$roleId = 0;
$perId = 0;
$roleName = "--Select--";
$perName = "--Select--";
$editId = 0;
if (isset($_GET["edit"])) {
    if ($_GET["edit"]) {
        $editId = $_GET["edit"];
        include("rolePerEditDAO.php");
        include("updateRolePerDAO.php");
    }
}
if ($editId == 0)
    include("addRolePerDAO.php");
?>

<html>
<head>
    <title> Role-Permission </title>
    <link href="styles.css" rel="stylesheet">
    <script>
        function main() {
            var btnSave = document.getElementById("btnSave");
            btnSave.onclick = function () {
                var rolePerObj = new Object();
                var role = document.getElementById("cmbRole");
                rolePerObj.role = role.options[role.selectedIndex].text;
                var per = document.getElementById("cmbPer");
                rolePerObj.per = per.options[per.selectedIndex].text;
                if (rolePerObj.role == "--Select--"){
                    alert("First Select Role.");
                    return false;
                }
                else if (rolePerObj.per == "--Select--"){
                    alert("First Select Permission.");
                    return false
                }
                return true;
            }
        }

        $("#btnClear").click(function () {
            $('rolePerForm')[0].reset();
        });
    </script>
</head>
<body onload="main();">

<?php
if ($_SESSION["isAdmin"] == 1)
    include("adminMenu.php");
include("showRolePerDD.php");
?>


</body>
</html>