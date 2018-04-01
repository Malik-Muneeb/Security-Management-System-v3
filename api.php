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

function getAllRoles(){
    
}
?>