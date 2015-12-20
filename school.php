<?php
  include("config/sql.php");
  $searchkey = $_REQUEST['id'];
  $sql="select name from school where school_id=".$searchkey.";";
echo $sql;
$result=mysqli_query($db,$sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    ?>
    <?php
    while($row = mysqli_fetch_assoc($result)) {
        echo "<p>NAME:".$row["name"]."</p>";
    }	
} else {
    echo "0 results";
}

mysqli_close($db);
?>


