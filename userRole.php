<?php
session_start();
if (isset($_SESSION["user"]) == false)
    header("location: login.php");
include("conn.php");
$roleId = 0;
$userId = 0;
$roleName = "--Select--";
$userName = "--Select--";
$editId = 0;
if (isset($_GET["edit"])) {
    if ($_GET["edit"]) {
        $editId = $_GET["edit"];
        include("userRoleEditDAO.php");
        include("updateUserRoleDAO.php");
    }
}
if ($editId == 0)
    include("addUserRoleDAO.php");
?>

<html>
<head>
    <title> User-Role </title>
    <link href="styles.css" rel="stylesheet">
    <script>
        function main() {
            var btnSave = document.getElementById("btnSave");
            btnSave.onclick = function () {
                var userRoleObj = new Object();
                var user = document.getElementById("cmbUser");
                userRoleObj.user = user.options[user.selectedIndex].text;
                var role = document.getElementById("cmbRole");
                userRoleObj.role = role.options[role.selectedIndex].text;
                if (userRoleObj.user == "--Select--"){
                    alert("First Select User.");
                    return false;
                }
                else if (userRoleObj.role == "--Select--"){
                    alert("First Select Role.");
                    return false;
                }
                return true;
            }
        }
        $("#btnClear").click(function () {
            $('userRoleForm')[0].reset();
        });
    </script>
</head>
<body onload="main();">

<?php
if ($_SESSION["isAdmin"] == 1)
    include("adminMenu.php");
include("showUserRoleDD.php");
?>

</body>
</html>