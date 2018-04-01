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
        $msg = deleteUser();
        echo json_encode($msg);
    } else if ($_POST["action"] == "saveRole") {
        if ($_POST["txtUpdateId"] == NULL) {
            $msg = saveRole();
            echo json_encode($msg);
        } else {
            $msg = updateRole();
            echo json_encode($msg);
        }
    } else if ($_POST["action"] == "getAllRoles") {
        $roles = getAllRoles();
        echo json_encode($roles);
    } else if ($_POST["action"] == "editRole") {
        $role = getRole();
        echo json_encode($role);
    } else if($_POST["action"]=="deleteRole"){
        $msg=deleteRole();
        echo json_encode($msg);
    } else if ($_POST["action"] == "savePer") {
        if ($_POST["txtUpdateId"] == NULL) {
            $msg = savePer();
            echo json_encode($msg);
        } else {
            $msg = updatePer();
            echo json_encode($msg);
        }
    } else if ($_POST["action"] == "getAllPers") {
        $pers = getAllPers();
        echo json_encode($pers);
    } else if ($_POST["action"] == "editPer") {
        $per = getPer();
        echo json_encode($per);
    } else if($_POST["action"]=="deletePer"){
        $msg=deletePer();
        echo json_encode($msg);
    } else if($_POST["action"]=="fetchRoles"){
        $roles=fetchRoles();
        echo json_encode($roles);
    } else if($_POST["action"]=="fetchPers"){
        $pers=fetchPers();
        echo json_encode($pers);
    } else if($_POST["action"]=="getAllRolesPers"){
        $rolesPers=getAllRolesPers();
        echo json_encode($rolesPers);
    } else if($_POST["action"]=="editRolePer"){
        $rolePer=getRolePer();
        echo json_encode($rolePer);
    } else if($_POST["action"]=="deleteRolePer"){
        $msg=deleteRolePer();
        echo json_encode($msg);
    } else if ($_POST["action"] == "saveRolePer") {
        if ($_POST["txtUpdateId"] == NULL) {
            $msg = saveRolePer();
            echo json_encode($msg);
        } else {
            $msg = updateRolePer();
            echo json_encode($msg);
        }
    }

}


?>