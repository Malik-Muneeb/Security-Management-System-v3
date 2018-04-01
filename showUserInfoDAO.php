<?php
include ("conn.php");
$userId=$_SESSION["userId"];
$sql = "SELECT * FROM user_role WHERE userid=$userId";
$result = mysqli_query($conn, $sql);
$roleIdArr=[];
$count=0;
while($row = mysqli_fetch_assoc($result)){
    $roleIdArr[$count]=$row["roleid"];
    $count++;
}
$perIdArr = [];
$count = 0;
$perCountArr=[];
$count1=0;
for($i=0; $i<count($roleIdArr); $i++) {
    $sql = "SELECT * FROM role_permission WHERE roleid=$roleIdArr[$i]";
    $result = mysqli_query($conn, $sql);
    $permissionPerRole=0;
    while ($row = mysqli_fetch_assoc($result)) {
        $perIdArr[$count] = $row["permissionid"];
        //echo $perIdArr[$count]."<br>";
        $count++;
        $permissionPerRole++;
    }
    $perCountArr[$count1]=$permissionPerRole; //store no of permission per role.
  //  echo $perCountArr[$count1]."<br>";
    $count1++;
}


$roleNameArr=[];
$count=0;
for($i=0; $i<count($roleIdArr); $i++) {
    $sql = "SELECT * FROM roles WHERE roleid=$roleIdArr[$i]";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $roleNameArr[$count] = $row["name"];
        $count++;
    }
}

$perNameArr=[];
$count=0;
?>
<div class="rolePermission">
    <ol>
        <?php
for($i=0,$perCount=0; $i<count($roleIdArr); $i++) {
    echo "<li class=roleProperty> Role: ".$roleNameArr[$i]."</li>";
    echo "<b>Permissions</b>";
    $numOfPer=$perCountArr[$i];
    //echo $numOfPer;
    for($j=0; $j<$numOfPer; $j++){
        //echo $perCount[$j]."<br>";
       // echo $perIdArr[$j]."<br>";
        $sql = "SELECT * FROM permissions WHERE permissionid=$perIdArr[$perCount]";
        $perCount++;
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $perNameArr[$count] = $row["name"];
            echo "<ul><li>".$perNameArr[$count]."</li></ul>";
            $count++;
        }
    }

}
?>
    </ol>
</div>
