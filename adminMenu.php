<?php
if(isset($_GET['logout'])==1)
{
    session_destroy();
    header("location: login.php");
}
?>

<div  class="menu">
       <ul>
            <li> <a onclick="applyClass" href="home.php" >Home</a> </li>
            <li>  <a href="users.php" >User Management</a> </li>
            <li> <a href="roles.php" >Role Management</a> </li>
            <li> <a href="permissions.php" >Permissions Management</a> </li>
            <li> <a  href="rolePerm.php" >Role-Permissions Assignment</a> </li>
            <li> <a href="userRole.php" >User-Role Assignment</a> </li>
            <li> <a href="loginHistory.php" >Login History</a> </li>
            <li> <a href="?logout=1">Logout</a </li>
       </ul>
</div>