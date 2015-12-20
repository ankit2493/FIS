<?php
  include("config.php");

function getFacultyDetails($facultyid)
{
  return "select * from faculty where faculty_id=".$facultyid.";"; 
}

function getSchoolByFacultyID($facultyid)
{
 return "select s.name SNAME from faculty f inner join school s on f.school_id = s.school_id where f.faculty_id=".$facultyid.";";
}

function getSchoolBySchoolID($schoolid)
{
 return "select * from school where school_id=".$schoolid.";";
}

function getSchoolBySchoolName($schoolName)
{
 return "select * from school where name='".$schoolName."';";
}

function getProjectsByFacultyID($facultyid)
{
return "select p.name PNAME,p.details PDETAILS from faculty f inner join facultyProject fp on f.faculty_id=fp.faculty_id inner join project p on fp.project_id=p.project_id where f.faculty_id =".$facultyid.";"; 
}

function getFacultyUnderSchool($school_id)
{
// 
}


function searchFaculty($searchkey)
{
	return "select faculty_id,f.name NAME,s.name SCHOOL_NAME,f.designation DESIGNATION from faculty f inner join school s on f.school_id=s.school_id where f.name like '%".$searchkey."%'";
}

function getDistinctDesignation()
{
  return "select distinct designation from faculty";
}

function getDistinctSchool()
{
  return "select distinct name from school";
}

?>