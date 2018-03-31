<?php
    function adminMenu(){
if(isset($_GET['logout'])==1)
{
    session_destroy();
    header("location: login.php");
}
?>

<div  class="menu">
    <ul>
        <li> <a onclick="applyClass" href="home.php" >Home</a> </li>
        <li>  <a href="userManagement.php" >User Management</a> </li>
        <li> <a href="roleManagement.php" >Role Management</a> </li>
        <li> <a href="permissionManagement.php" >Permissions Management</a> </li>
        <li> <a  href="rolePermissionManagement.php" >Role-Permissions Assignment</a> </li>
        <li> <a href="userRoleManagement.php" >User-Role Assignment</a> </li>
        <li> <a href="showLoginHistory.php" >Login History</a> </li>
        <li> <a href="?logout=1">Logout</a </li>
    </ul>
</div>
<?php
    }
?>