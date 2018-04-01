<?php
session_start();
if (isset($_SESSION["user"]) == false)
    header("location: login.php");
?>
<html>
<head>
    <title> Login History </title>
    <link href="styles.css" rel="stylesheet">
</head>
</html>

<?php
include("conn.php");
if ($_SESSION["isAdmin"] == 1)
    include("adminMenu.php");
$sql = "SELECT * FROM loginhistory";
$result = mysqli_query($conn, $sql);
$recordsFound = mysqli_num_rows($result);
if ($recordsFound > 0) {
    ?>
    <table id="myTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>login</th>
            <th>Login Time</th>
            <th>Machine IP</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['userid']; ?></td>
                <td><?php echo $row['login']; ?></td>
                <td><?php echo $row["logintime"]; ?></td>
                <td><?php echo $row["machineip"]; ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
} else {
    ?>
    <script>alert("No Login History")</script><?php
}
?>

