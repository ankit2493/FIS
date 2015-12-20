<?php
include("config/sql.php");
$searchkey = "";
if (isset($_REQUEST['searchkey'])) {
$searchkey = $_REQUEST['searchkey'];
}
$sql    = searchFaculty($searchkey);
$result = mysqli_query($db, $sql);
if (mysqli_num_rows($result) >
0) {
// output data of each row
?>
<table id ="resultable" class="display">
  <thead>
  <tr>
    <th>
      S.No.
    </th>
    <th>
      NAME
    </th>
    <th>
      SCHOOL_NAME
    </th>
  </tr>
  </thead>
  <tbody>
  <?php
$count = 1;
while ($row = mysqli_fetch_assoc($result)) {
echo "
<tr>
<td>
$count
</td>
<td>
<a href='faculty.php?id=" . $row["faculty_id"] . "'>
" . $row["NAME"] . "
</a>
</td>
<td>
" . $row["SCHOOL_NAME"] . "
</td>
</tr>
";
$count++;
}
echo "</tbody>";
} else {
echo "0 results";
}

mysqli_close($db);
?>
      
</table>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.css">
      <script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js">
      </script>
      <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.js">
      </script>
      <style type="text/css">
      th{
      	text-align: left;
      }
      </style>
<script>
$(document).ready( function () {
    $('#resultable').DataTable();
} );
</script>