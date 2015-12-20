<?php
$searhflag =false;
include("config/sql.php");
if (isset($_REQUEST['searchkey']) && strlen(trim($_REQUEST['searchkey']))>0) {
$searchkey = $_REQUEST['searchkey'];
$sql    = searchFaculty($searchkey);
$schoolFilter = "";
$designationFilter = "";
if(isset($_REQUEST['schoolFilter']) && strlen(trim($_REQUEST['schoolFilter']))>0)
{
  $sql = $sql."and s.name='".$_REQUEST['schoolFilter']."'"; 
  $schoolFilter = $_REQUEST['schoolFilter'];
}

if(isset($_REQUEST['designationFilter']) && strlen(trim($_REQUEST['designationFilter']))>0)
{
  $sql = $sql."and f.designation='".$_REQUEST['designationFilter']."'"; 
  $designationFilter = $_REQUEST['designationFilter'];
}

$sql = $sql.";";

$result = mysqli_query($db, $sql);
$searhflag = true;
}
?>
<html>

<head>
    <?php include( "base/header.php"); ?>
    <script type="text/javascript">

    function openCloseFacultyInfo(status)
    { 
      var el = document.getElementById('faculty-frame-container');
      var childNodes = el.parentNode.children;
      

      if(status)
      {
        for(var i=0;i<childNodes.length;i++)
        {
          childNodes[i].style.display = "none";
        }
        el.style.display ="";
      }
      else {
        for(var i=0;i<childNodes.length;i++)
        {
          childNodes[i].style.display = "";
        }
        el.style.display ="none";
      }
    }
    </script>
</head>
<body>
    <div class="header">
        <h4>Faculty Information System <a class="login-btn"><span class="glyphicon glyphicon-user login-btn" aria-hidden="true">LOGIN</span></a></h4>
    </div>
    <div class="head-container">
        <div id='cssmenu'>
            <ul>
                <li><a href='index.php'><span>Search Faculty</span></a></li>
                <li><a href='#'><span>Search Project</span></a></li>
                <li class='active'><a href='school2.php'><span>Search School</span></a></li>
            </ul>
        </div>
        <div class="inner-container">
           <!--  <div class="search-container" style="display:none">
                <div id="search">
                    <form action="index.php" method="POST" onsubmit="return formSubmit(this);" id="search-form">
                        <fieldset class="clearfix">
                            <input type="search" name="searchkey" <?php if($searhflag==true){echo 'value='.$searchkey;}else {echo 'value='.'"Enter faculty name"';} ?> onBlur="if(this.value=='')this.value='Enter faculty name'" onFocus="if(this.value=='Enter faculty name')this.value='' ">
                            <input type="submit" value="Search" class="button">
                        </fieldset>
                    </form>
                </div>
            </div> -->
            <div class="search-results" style="top:45px">
            <div class="fleft">
                <div id='filters'>
                  
<h6 style="padding:4px;background: rgba(55,92,143,0.67); color: #D1D3DC;"><span class="glyphicon glyphicon-filter" aria-hidden="true" style="margin-right:6px"></span>Select School</h6>
        <form action="school2.php" method="POST" id="search-form">
                        <fieldset class="clearfix">
                            <input type="search" name="searchkey" value="%" style="display:none;">
                            <table>
                              <tr>
                                <td>
                            <select id="school-filter" name="schoolFilter">
                              <?php
                                $ssql    = getDistinctSchool();
                                $sresult = mysqli_query($db, $ssql);
                                while ($srow = mysqli_fetch_assoc($sresult)) {
                                echo "<option>".$srow['name']."</option>";
                                }
                              ?>
                            </select>
                          </td>
                          <td>
                            <input type="submit" value="Search" class="btn btn-primary" style="background:#375c8f;opacity:0.67;font-size: 11px;height: 25px;">
                          </td>
                        </tr>
                      </table>
                        </fieldset>
        </form>
         <script type="text/javascript">
            var schoolFilterInput = "<?php if(isset($schoolFilter)){ echo $schoolFilter; } ?>"; 
            var schoolFilter = document.getElementById("school-filter");
            for(var i=0;i<schoolFilter.options.length;i++)
            {
              if(schoolFilter.options[i].value == schoolFilterInput)
              {
                schoolFilter.options.selectedIndex = i;
              }
            }
        </script>
              

                </div>
            </div>
            <div class="fright">
              <div id="faculty-frame-container" style="width:100%;height:100%;display:none">
                <input type="button" class="btn btn-primary" style="background: #375c8f;opacity:0.67;border-radius: 3px;position:absolute;top:10px;left:15px;z-index:2" value="Go back" onclick="return openCloseFacultyInfo(false)">
                <iframe name="faculty-frame" style="border:0px;width:100%;height:100%">
                </iframe>
              </div>
             

              <?php
              if ($searhflag==true && mysqli_num_rows($result) >0) {
                ?>
                 <div>
                  <style>
                  .school-name{
                    margin-top:2px;
                  }
                  .school-desc {
                      font-family: tahoma;
                      font-size: 20px;
                      line-height: 23px;
                      margin-top: 7px;
                   }
                  </style>
                  <?php  
                                $schoolsql    = getSchoolBySchoolName($schoolFilter);
                                $schoolresult = mysqli_query($db, $schoolsql);
                                if (mysqli_num_rows($schoolresult) ==1) {
                                    // output data of each row
                                    $schoolrow = mysqli_fetch_assoc($schoolresult);
                                    $schoolname = $schoolrow['name'];
                                    $schooldesc = $schoolrow['desc'];

                                } 
                              
                ?>
                <h1 class="school-name"><?php  echo "$schoolname"?></h1>
                <h3 class="school-desc"><?php  echo "$schooldesc"?> </h3>
                <br/>
                <br/>
                <h4 style="width:100%;text-align:center;margin-bottom:10px;padding:2px;color:#000;font-weight:500;border-top:1px solid black;border-bottom:1px solid black;background:#375c8f;opacity:0.67;"> <?php  echo "$schoolFilter"?> School - Faculty List</h4>
                <table id="resultable" class="display">
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
                            <th>
                                DESIGNATION
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
<a href='faculty.php?id=" . $row["faculty_id"] . "' target='faculty-frame' onclick='return openCloseFacultyInfo(true);'>
" . $row["NAME"] . "
</a>
</td>
<td>
" . $row["SCHOOL_NAME"] . "
</td>
<td>
" . $row["DESIGNATION"] . "
</td>
</tr>
";
$count++;
}
echo "</tbody></table></div>";
 ?>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
      <script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js">
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


 <?php
              }
              else
              {
                if($searhflag)
                {
                echo "<h5>No Results</h5>";
                }
              }
              ?>
            </div>
          </div>
        </div>
        <div class="footer">
            <h4>footer note</h4></div>
    </div>
</body>

</html>
<?php
mysqli_close($db);
?>