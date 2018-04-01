<?php
include("conn.php");

function loginDAO()
{
    global $conn;
    if (isset($_POST["btnLogin"])) {
        $login = $_POST["txtLogin"];
        $password = $_POST["txtPassword"];
        if ($login == "" && $password = "")
            return "You missed login or Password";
        else {
            $sql = "SELECT * FROM users WHERE login='" . $login . "' And password='" . $password . "' ";
            $result = mysqli_query($conn, $sql);
            $recordsFound = mysqli_num_rows($result);
            if ($recordsFound > 0) {
                $row = mysqli_fetch_assoc($result);
                $isAdmin = $row["isadmin"];
                $_SESSION["userId"] = $row["userid"];
                $_SESSION["user"] = $row["name"];
                $_SESSION["isAdmin"] = $isAdmin;
                include("loginHistory.php");
                header("Location: home.php");
            } else {
                $_SESSION["user"] = null;
                return "Invalid login or Password";
            }
        }
    }
}

function fetchCountries()
{
    global $conn;
    $sql = "SELECT * FROM country";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    $countries = array();
    if ($recordsFound > 0) {
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $countryId = $row["id"];
            $countryName = $row["name"];
            $countries[$i] = array("countryId" => $countryId, "name" => $countryName);
            $i++;
        }
    }
    return $countries;
}

function fetchCities($countryId)
{
    global $conn;
    $sql = "SELECT * FROM city WHERE countryid=$countryId";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    $cities = array();
    if ($recordsFound > 0) {
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $cityId = $row["id"];
            $cityName = $row["name"];
            $cities[$i] = array("cityId" => $cityId, "name" => $cityName);
            $i++;
        }
    }
    return $cities;
}

function userAddDAO()
{
    global $conn;
    $login = $_POST["txtLogin"];
    $password = $_POST["txtPassword"];
    $name = $_POST["txtName"];
    $email = $_POST["txtEmail"];
    $country = $_POST["cmbCountries"];
    $city = $_POST["cmbCities"];
    $isAdmin = $_POST["adminStatus"];
    if ($login == "" && $password == "" && $name == "" && $email == "")
        return "Please Enter All Information";
    else {
        $userId = $_SESSION["userId"];
        $date = date('Y-m-d H:i:s');
        $sql = "Insert into users VALUES (NULL,'" . $login . "','" . $password . "','" . $name . "','" . $email . "'," .
            "'" . $country . "','" . $city . "','" . $date . "',$userId,$isAdmin)";
        if (mysqli_query($conn, $sql) === TRUE) {
            return "Record is added successfully.";
        } else {
            return "Some Problem has occurred";
        }
    }
}

function getAllUsers()
{
    global $conn;
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    $users = array();
    if ($recordsFound > 0) {
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['userid'];
            $name = $row['name'];
            $email = $row['email'];
            $users[$i] = array("id" => $id, "name" => $name, "email" => $email);
            $i++;
        }
        return $users;
    } else {
        return "No Records Found";
    }
}

function getUser()
{
    global $conn;
    $sql = "SELECT * FROM users WHERE userid='" . $_POST["editId"] . "'";
    $result = mysqli_query($conn, $sql);
    $user = array();
    if ($row = mysqli_fetch_assoc($result)) {
        $user["userId"] = $row["userid"];
        $user["login"] = $row["login"];
        $user["password"] = $row["password"];
        $user["name"] = $row["name"];
        $user["email"] = $row["email"];
        $user["countryId"] = $row["countryid"];
        $user["cityId"] = $row["cityid"];
        $user["isAdmin"] = $row["isadmin"];
        return $user;
    }
}

function updateUser()
{
    global $conn;
    $updateId = $_POST["txtUpdateId"];
    $login = $_POST["txtLogin"];
    $password = $_POST["txtPassword"];
    $name = $_POST["txtName"];
    $email = $_POST["txtEmail"];
    $countryId = $_POST["cmbCountries"];
    $cityId = $_POST["cmbCities"];
    $isAdmin = $_POST["adminStatus"];
    if ($login == "" && $password == "" && $name == "" && $email == "")
        return "Please Enter All Information";
    else {
        $userId = $_SESSION["userId"];
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE users set login='" . $login . "', password='" . $password . "', name='" . $name . "'," .
            "email='" . $email . "', countryid='" . $countryId . "', cityid='" . $cityId . "', createdon='" . $date . "', " .
            "createdby='" . $userId . "', isadmin=$isAdmin where userid=$updateId";
        if (mysqli_query($conn, $sql) === TRUE) {
            return "Record is updated successfully.";
        } else {
            return "Some Problem has occurred while updating record";
        }
    }
}

function deleteUser()
{
    global $conn;
    $deleteId = $_POST["deleteId"];
    $sql = "DELETE FROM users WHERE userid=$deleteId";
    if (mysqli_query($conn, $sql))
        return "Record deleted successfully";
    else
        return "Error deleting record";
}

function saveRole()
{
    global $conn;
    $name = $_POST["txtName"];
    $description = $_POST["txtDesc"];
    if ($name == "" && $description == "")
        return "Please Enter All Information";
    else {
        $userId = $_SESSION["userId"];
        $date = date('Y-m-d H:i:s');
        $sql = "Insert into roles VALUES (NULL,'" . $name . "','" . $description . "'," .
            "'" . $date . "',$userId)";
        if (mysqli_query($conn, $sql) === TRUE)
            return "Role is added successfully.";
        else
            return "Some Problem has occurred while adding role";
    }
}

function getAllRoles()
{
    global $conn;
    $sql = "SELECT * FROM roles";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        $roles = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $roles[$i] = array("roleId" => $row['roleid'], "name" => $row['name'],
                "description" => $row['description']);
            $i++;
        }
        return $roles;
    } else
        return "No Roles Found";
}

function getRole()
{
    global $conn;
    $editId = $_POST["editId"];
    $sql = "SELECT * FROM roles WHERE roleid='" . $editId . "'";
    $result = mysqli_query($conn, $sql);
    $role = array();
    if ($row = mysqli_fetch_assoc($result)) {
        $role["roleId"] = $row["roleid"];
        $role["name"] = $row["name"];
        $role["description"] = $row["description"];
        $role["createdOn"] = $row["createdon"];
        $role["createdBy"] = $row["createdby"];
        return $role;
    }
}

function updateRole()
{
    global $conn;
    $updateId = $_POST["txtUpdateId"];
    $name = $_POST["txtName"];
    $description = $_POST["txtDesc"];
    $userId = $_SESSION["userId"];
    $date = date('Y-m-d H:i:s');
    $sql = "UPDATE roles set name='" . $name . "',description='" . $description . "'" .
        ",createdon='" . $date . "',createdby='" . $userId . "' where roleid=$updateId";
    if (mysqli_query($conn, $sql))
        return "Role updated successfully";
    else
        return "Error while updating role";
}

function deleteRole()
{
    global $conn;
    $deleteId = $_POST["deleteId"];
    $sql = "DELETE FROM roles WHERE roleid=$deleteId";
    if (mysqli_query($conn, $sql))
        return "Role deleted successfully";
    else
        return "Error while deleting role";
}

function savePer()
{
    global $conn;
    $name = $_POST["txtName"];
    $description = $_POST["txtDesc"];
    if ($name == "" && $description == "")
        return "Please Enter All Information";
    else {
        $userId = $_SESSION["userId"];
        $date = date('Y-m-d H:i:s');
        $sql = "Insert into permissions VALUES (NULL,'" . $name . "','" . $description . "'," .
            "'" . $date . "',$userId)";
        if (mysqli_query($conn, $sql) === TRUE)
            return "Permission is added successfully.";
        else
            return "Some Problem has occurred while adding Permission";
    }
}

function getAllPers()
{
    global $conn;
    $sql = "SELECT * FROM permissions";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        $pers = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $pers[$i] = array("permissionId" => $row['permissionid'], "name" => $row['name'],
                "description" => $row['description']);
            $i++;
        }
        return $pers;
    } else
        return "No Permission Found";
}

function getPer()
{
    global $conn;
    $editId = $_POST["editId"];
    $sql = "SELECT * FROM permissions WHERE permissionid='" . $editId . "'";
    $result = mysqli_query($conn, $sql);
    $per = array();
    if ($row = mysqli_fetch_assoc($result)) {
        $per["permissionId"] = $row["permissionid"];
        $per["name"] = $row["name"];
        $per["description"] = $row["description"];
        $per["createdOn"] = $row["createdon"];
        $per["createdBy"] = $row["createdby"];
        return $per;
    }
}

function updatePer()
{
    global $conn;
    $updateId = $_POST["txtUpdateId"];
    $name = $_POST["txtName"];
    $description = $_POST["txtDesc"];
    $userId = $_SESSION["userId"];
    $date = date('Y-m-d H:i:s');
    $sql = "UPDATE permissions set name='" . $name . "',description='" . $description . "'" .
        ",createdon='" . $date . "',createdby='" . $userId . "' where permissionid=$updateId";
    if (mysqli_query($conn, $sql))
        return "Permission updated successfully";
    else
        return "Error while updating Permission";
}

function deletePer()
{
    global $conn;
    $deleteId = $_POST["deleteId"];
    $sql = "DELETE FROM permissions WHERE permissionid=$deleteId";
    if (mysqli_query($conn, $sql))
        return "Permission deleted successfully";
    else
        return "Error while deleting Permission";
}

function fetchRoles()
{
    global $conn;
    $sql = "SELECT * FROM roles";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        $roles = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $roleId = $row["roleid"];
            $name = $row["name"];
            $roles[$i] = array("roleId" => $roleId, "name" => $name);
            $i++;
        }
        return $roles;
    }
}

function fetchPers()
{
    global $conn;
    $sql = "SELECT * FROM permissions";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        $pers = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $perId = $row["permissionid"];
            $name = $row["name"];
            $pers[$i] = array("permissionId" => $perId, "name" => $name);
            $i++;
        }
        return $pers;
    }
}

function getAllRolesPers()
{
    global $conn;
    $sql = "SELECT * FROM role_permission";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        $rolesPers = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $roleId = $row["roleid"];
            $perId = $row["permissionid"];
            $sql = "SELECT * FROM roles WHERE roleid=$roleId";
            $result1 = mysqli_query($conn, $sql);
            $row1 = mysqli_fetch_assoc($result1);
            $roleName = $row1["name"];
            $sql = "SELECT * FROM permissions WHERE permissionid=$perId";
            $result1 = mysqli_query($conn, $sql);
            $row1 = mysqli_fetch_assoc($result1);
            $perName = $row1["name"];
            $rolesPers[$i] = array("id" => $row['id'], "roleName" => $roleName, "perName" => $perName);
            $i++;
        }
        return $rolesPers;
    } else
        return "No Records Found";
}

function getRolePer()
{
    global $conn;
    $editId = $_POST["editId"];
    $sql = "SELECT * FROM role_permission WHERE id='" . $editId . "'";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $id = $row["id"];
        $roleId = $row["roleid"];
        $perId = $row["permissionid"];
        $rolePer = array("id" => $id, "roleId" => $roleId, "perId" => $perId);
        return $rolePer;
    }

}

function deleteRolePer()
{
    global $conn;
    $deleteId = $_POST["deleteId"];
    $sql = "DELETE FROM role_permission WHERE id=$deleteId";
    if (mysqli_query($conn, $sql))
        return "Role-Permission deleted successfully";
    else
        return "Error while deleting Role-Permission";
}

function saveRolePer()
{
    global $conn;
    $roleId = $_POST["cmbRole"];
    $perId = $_POST["cmbPer"];
    if ($roleId == 0 && $perId == 0)
        return "Please Select All Information";
    else {
        $sql = "Insert into role_permission VALUES (NULL,$roleId,$perId)";
        if (mysqli_query($conn, $sql) === TRUE)
            return "Role-Permission is added successfully.";
        else
            return "Some Problem has occurred while adding Role-Permission";
    }
}

function updateRolePer(){
    global $conn;
    $updateId=$_POST["txtUpdateId"];
    $roleId=$_POST["cmbRole"];
    $perId=$_POST["cmbPer"];
    $sql = "UPDATE role_permission set roleid=$roleId, permissionid=$perId where id=$updateId";
    if (mysqli_query($conn, $sql))
       return "Role-Permisson updated successfully";
    else
        return "Error while updating Role-Permission";
}

function fetchUsers()
{
    global $conn;
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        $users = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $userId = $row["userid"];
            $name = $row["name"];
            $users[$i] = array("userId" => $userId, "name" => $name);
            $i++;
        }
        return $users;
    }
}

function getAllUsersRoles()
{
    global $conn;
    $sql = "SELECT * FROM user_role";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    if ($recordsFound > 0) {
        $userRoles = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $roleId = $row["roleid"];
            $userId = $row["userid"];
            $sql = "SELECT * FROM roles WHERE roleid=$roleId";
            $result1 = mysqli_query($conn, $sql);
            $row1 = mysqli_fetch_assoc($result1);
            $roleName = $row1["name"];
            $sql = "SELECT * FROM users WHERE userid=$userId";
            $result1 = mysqli_query($conn, $sql);
            $row1 = mysqli_fetch_assoc($result1);
            $userName = $row1["name"];
            $userRoles[$i] = array("id" => $row['id'], "roleName" => $roleName, "userName" => $userName);
            $i++;
        }
        return $userRoles;
    } else
        return "No Records Found";
}

function getUserRole()
{
    global $conn;
    $editId = $_POST["editId"];
    $sql = "SELECT * FROM user_role WHERE id='" . $editId . "'";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $id = $row["id"];
        $roleId = $row["roleid"];
        $userId = $row["userid"];
        $userRole = array("id" => $id, "roleId" => $roleId, "userId" => $userId);
        return $userRole;
    }

}

function deleteUserRole()
{
    global $conn;
    $deleteId = $_POST["deleteId"];
    $sql = "DELETE FROM user_role WHERE id=$deleteId";
    if (mysqli_query($conn, $sql))
        return "User-Role deleted successfully";
    else
        return "Error while deleting User-Role";
}

function saveUserRole()
{
    global $conn;
    $roleId = $_POST["cmbRole"];
    $userId = $_POST["cmbUser"];
    if ($roleId == 0 && $userId == 0)
        return "Please Select All Information";
    else {
        $sql = "Insert into role_permission VALUES (NULL,$roleId,$perId)";
        if (mysqli_query($conn, $sql) === TRUE)
            return "Role-Permission is added successfully.";
        else
            return "Some Problem has occurred while adding Role-Permission";
    }
}

function updateUserRole(){
    global $conn;
    $updateId=$_POST["txtUpdateId"];
    $roleId=$_POST["cmbRole"];
    $perId=$_POST["cmbPer"];
    $sql = "UPDATE role_permission set roleid=$roleId, permissionid=$perId where id=$updateId";
    if (mysqli_query($conn, $sql))
        return "Role-Permisson updated successfully";
    else
        return "Error while updating Role-Permission";
}