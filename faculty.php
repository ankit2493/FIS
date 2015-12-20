<?php
  include("config/sql.php");

  $faculty_id = $_REQUEST['id'];
  $facultysql = getFacultyDetails($faculty_id);
  $result=mysqli_query($db,$facultysql);
  if (mysqli_num_rows($result) ==1) {
    // output data of each row
    $row = mysqli_fetch_assoc($result);
 	$facultyName = $row['name'];
 	$designation = $row['designation'];
  $availability_status = $row['availability_status'];
  $qualification = $row['qualification'];
  $timing = $row['timing'];
  $cabin = $row['cabin'];
  $subjects = $row['subjects'];


  $schoolid = $row['school_id'];
  }
  $schoolsql = getSchoolBySchoolID($schoolid);
  $result=mysqli_query($db,$schoolsql);
  if (mysqli_num_rows($result) ==1) {
    // output data of each row
    $row = mysqli_fetch_assoc($result);
 	$schoolname = $row['name'];
  }	
  else
  {
  	$schoolname = "NA";
  }
  $projectsql = getProjectsByFacultyID($faculty_id);
  $result=mysqli_query($db,$projectsql);
   $projects = array();
  if (mysqli_num_rows($result) > 0) {
  	while($row = mysqli_fetch_assoc($result)) {
  		$projectname = $row['PNAME'];
  		$projectdetails = $row['PDETAILS'];
  		$project = array($projectname,$projectdetails);
		array_push($projects,$project);
    }
  }
  mysqli_close($db);
?>

<html>
<body style="background:rgba(0,0,0,0)">
  <link rel="stylesheet" href="css/bootstrap.min.css">
 <div>
        <style>
       
        td {
            padding: 15px;
            vertical-align: top;
            font-weight: 500;
        }
        
        table {
          color:#375c8f;
            border-collapse: collapse;
            /*border: 1px solid black;*/
            margin: 0 auto;
        }
        
        tr {
            border-bottom: 1px solid rgba(0,0,0,0.2);
        }

        td.column,td.subcolumn{
          font-weight: 200;
        }
        
        div.tcontainer table {
            padding: 5px;
            width: 100%;
        }
        td.available{
          color:green;
        }
        td.unavailable{
          color:red;
        }
        h1,h3 {
          margin:0px;
        }
        </style>
        <div class="tcontainer">
            <table style="border-collapse:collapse;width:800px;" cellspacing="1" cellpadding="2">
                <tr>
                    <td colspan="3">
                        <h1><?php echo "$facultyName"; ?></h1>
                        <h3><span><?php echo "$schoolname"; ?></span>, <span><?php echo "$designation"; ?></span></h3>
                    </td>
                </tr>
                <tr>
                    <td rowspan="3" class="column">
                        Contact Information
                    </td>
                    <td class="subcolumn">
                        Cabin Location
                    </td>
                    <td>
                        <?php echo "$cabin"; ?>
                    </td>
                </tr>
                <tr>
                    <td class="subcolumn">
                        Timing
                    </td>
                    <td>
                        <?php echo "$timing"; ?>
                    </td>
                </tr>
                <tr>
                    <td class="subcolumn">
                        Availability Status
                    </td>
                    <?php 
                    echo "<td class='$availability_status'>";
                         echo "$availability_status"; 
                    ?>
                    </td>
                </tr>
                <tr>
                    <td rowspan="3" class="column">
                        Academic Information
                    </td>
                    <td class="subcolumn">
                        Qualification
                    </td>
                    <td>
                        <?php echo "$qualification"; ?>
                    </td>
                </tr>
                <tr>
                    <td class="subcolumn">
                        Subjects
                    </td>
                    <td>
                        <?php echo "$subjects"; ?>
                    </td>
                </tr>
                <tr>
                    <td class="subcolumn">
                        Projects
                    </td>
                    <td>
                      <?php
                      for ($i = 0; $i < count($projects); ++$i) {
                          $project = $projects[$i];
                          echo "<p><b>$project[0]</b><br/>$project[1]</p>";
                        }
                      ?>
                    </td>
                </tr>
            </table>
        </div>

</body>
</html>

