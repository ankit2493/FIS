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
    function formSubmit(el)
    {
      console.log(el);
      var schoolFilter = document.getElementById('school-filter'),
          designationFilter = document.getElementById('designation-filter'),
          schoolName = schoolFilter.options[schoolFilter.selectedIndex].value,
          designationName = designationFilter.options[designationFilter.selectedIndex].value,
          searchInput = document.createElement('input'),
          designationInput = document.createElement('input');
          searchInput.style.display = "none";
          searchInput.setAttribute('type','text');
          searchInput.setAttribute('name','schoolFilter');
          searchInput.setAttribute('value',schoolName == '--None--' ? '' : schoolName);
          designationInput.setAttribute('type','text');
          designationInput.style.display = "none";
          designationInput.setAttribute('name','designationFilter');
          designationInput.setAttribute('value',designationName == '--None--' ? '' : designationName);
         el.appendChild(searchInput);
         el.appendChild(designationInput);
      return true;
    }

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
                <li class='active'><a href='index.php'><span>Search Faculty</span></a></li>
                <li><a href='#'><span>Search Project</span></a></li>
                <li class='last'><a href='school2.php'><span>Search School</span></a></li>
            </ul>
        </div>
        <div class="inner-container">
            <div class="search-container">
                <div id="search">
                    <form action="index.php" method="POST" onsubmit="return formSubmit(this);" id="search-form">
                        <fieldset class="clearfix">
                            <input type="search" name="searchkey" <?php if($searhflag==true){echo 'value='.$searchkey;}else {echo 'value='.'"Enter faculty name"';} ?> onBlur="if(this.value=='')this.value='Enter faculty name'" onFocus="if(this.value=='Enter faculty name')this.value='' ">
                            <input type="submit" value="Search" class="button">
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="search-results">
            <div class="fleft">
                <div id='filters'>
                  
<h6 style="padding:4px;background: rgba(55,92,143,0.67); color: #D1D3DC;"><span class="glyphicon glyphicon-filter" aria-hidden="true" style="margin-right:6px"></span>Search Filters</h6>
<table>
  <tr>
    <td>School </td>
    <td>  
        <select id="school-filter">
          <option>--None--</option>
          <?php
            $ssql    = getDistinctSchool();
            $sresult = mysqli_query($db, $ssql);
            while ($srow = mysqli_fetch_assoc($sresult)) {
            echo "<option>".$srow['name']."</option>";
            }
          ?>
        </select>
    </td>
  </tr>
  <tr>
    <td>Designation </td>
    <td>
        <select id="designation-filter">
          <option>--None--</option>
          <?php
            $dsql    = getDistinctDesignation();
            $dresult = mysqli_query($db, $dsql);
            while ($drow = mysqli_fetch_assoc($dresult)) {
            echo "<option>".$drow['designation']."</option>";
            }
          ?>
        </select>
        <script type="text/javascript">
            var schoolFilterInput = "<?php if(isset($schoolFilter)){ echo $schoolFilter; } ?>"; 
            var designationFilterInput = "<?php if(isset($designationFilter)){echo $designationFilter;} ?>"; 
            var schoolFilter = document.getElementById("school-filter");
            for(var i=0;i<schoolFilter.options.length;i++)
            {
              if(schoolFilter.options[i].value == schoolFilterInput)
              {
                schoolFilter.options.selectedIndex = i;
              }
            }
            var designationFilter = document.getElementById("designation-filter");
            for(var i=0;i<designationFilter.options.length;i++)
            {
              if(designationFilter.options[i].value == designationFilterInput)
              {
                designationFilter.options.selectedIndex = i;
              }
            }
        </script>
    </td>
  </tr>
</table>
              

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
echo "</tbody></table>";
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