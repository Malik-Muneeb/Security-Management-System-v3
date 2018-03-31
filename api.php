<?php
function loginDAO()
{
    include ("conn.php");
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



?>