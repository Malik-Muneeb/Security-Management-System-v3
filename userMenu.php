<?php
if(isset($_GET['logout'])==1)
{
    session_destroy();
    /*$_SESSION["user"]=null;
    $_SESSION["isAdmin"]=null;
    */
    header("location: login.php");

}
?>


<div  class="menu">
    <ul>
        <li><a class="active" href="Home.php" >Home</a></li>
        <li><a href="?logout=1" >Logout</a></li>
    </ul>
</div>