<?php

//database config
$host = "localhost";
$user = "root"; 
$password = ""; 
$dbname = "examination"; 


$con = mysqli_connect($host, $user, $password,$dbname);
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}

// $sql="select stu.name as student, sub.name as subject, result.marks as mark from students as stu, subjects as sub, result where result.student_id=stu.id and result.subject_id=sub.id ";

$sql="select stu.name as student, sub.name as subjects, result.marks as mark from students stu inner join result on result.student_id=stu.id 
inner join subjects sub on result.subject_id=sub.id";

$result=$con->query($sql);

$arr=array();

$student=array();
$subject=array();
$mark=array();
// echo $con->error;
while($row = $result->fetch_assoc()){

    array_push($student, $row['student']);
    array_push($subject, $row['subjects']);
    array_push($mark, $row['mark']);

    if (!isset($arr[$row['student']])) {
        $arr[$row['student']]['rowspan'] = 0;
    }
    $arr[$row['student']]['printed'] = 'no';
    $arr[$row['student']]['rowspan'] += 1;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>

table{
    /* border:1px solid black; */
}
tbody tr td{
    border-bottom: 1px solid black;
}
td[rowspan] {
  vertical-align: top;
  text-align: left;
}
</style>
<body>

<table >

<thead>
    <tr>
        <th>Student name</th>
        <th>Subject</th>
        <th>Marks</th>
    </tr>
</thead>
<tbody>
    <?php
    
    for($i=0; $i < sizeof($subject); $i++) {
        $student_name = $student[$i];
        echo "<tr>";
        if ($arr[$student_name]['printed'] == 'no') {
            echo "<td rowspan='".$arr[$student_name]['rowspan']."'>".$student_name."</td>";
            $arr[$student_name]['printed'] = 'yes';
        }
        echo "<td>".$subject[$i]."</td>";
        echo "<td>".$mark[$i]."</td>";
        echo "</tr>";
    }
    ?>
</tbody>

</table>


</body>
</html>
