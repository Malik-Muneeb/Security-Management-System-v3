<?php
session_start();
include ("api.php");
if(isset($_POST["action"])){
    if($_POST["action"]=="saveUser"){
        $msg=userAddDAO();
        echo json_encode($msg);
    }
    else if($_POST["action"]=="fetchCities"){
        $cities=fetchCities($_POST["countryId"]);
        echo json_encode($cities);
    }
}


?>