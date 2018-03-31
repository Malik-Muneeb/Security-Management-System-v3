<?php
function loginDAO()
{
    include("conn.php");
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

function fetchCities($countryId){
    include ("conn.php");
    $sql = "SELECT * FROM city WHERE countryid=$countryId";
    $result = mysqli_query($conn, $sql);
    $recordsFound = mysqli_num_rows($result);
    $cities=array();
    if ($recordsFound > 0) {
        $i=0;
        while ($row = mysqli_fetch_assoc($result)) {
            $cityId = $row["id"];
            $cityName = $row["name"];
            $cities[$i]=array("cityId" => $cityId, "name" => $cityName);
            $i++;
        }
    }
    return $cities;
}

function userAddDAO()
{
    include ("conn.php");
    $login = $_POST["txtLogin"];
    $password = $_POST["txtPassword"];
    $name = $_POST["txtName"];
    $email = $_POST["txtEmail"];
    $country = $_POST["cmbCountries"];
    $city=$_POST["cmbCities"];
    if ($_SESSION["isAdmin"]==1)
        $isAdmin = 1;
    else
        $isAdmin = 0;
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


?>