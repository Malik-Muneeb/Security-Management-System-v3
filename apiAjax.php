<?php
session_start();
include("api.php");
if (isset($_POST["action"])) {
    if ($_POST["action"] == "saveUser") {
        if ($_POST["txtUpdateId"] == NULL) {
            $msg = userAddDAO();
            echo json_encode($msg);
        } else {
            $msg = updateUser();
            echo json_encode($msg);
        }
    } else if ($_POST["action"] == "fetchCountries") {
        $countries = fetchCountries();
        echo json_encode($countries);
    } else if ($_POST["action"] == "fetchCities") {
        $cities = fetchCities($_POST["countryId"]);
        echo json_encode($cities);
    } else if ($_POST["action"] == "getAllUsers") {
        $users = getAllUsers();
        echo json_encode($users);
    } else if ($_POST["action"] == "editUser") {
        $user = getUser();
        echo json_encode($user);
    } else if ($_POST["action"] == "deleteUser") {
        //$msg = "in api ajax";
        $msg=deleteUser();
        echo json_encode($msg);
    }

}


?>