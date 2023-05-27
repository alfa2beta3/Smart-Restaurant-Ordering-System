<?php
// database connection code
// $con = mysqli_connect('localhost', 'database_user', 'database_password','database');

$conn = mysqli_connect('localhost', 'root', '','rms2');

// get the post records
$txtTime = $_POST['txtTime'];
$txtName = $_POST['txtName'];
$txtDish = $_POST['txtDish'];
$txtNumber = $_POST['txtNumber'];

// database insert SQL code
$sql = "INSERT INTO `orders` (
    `time`, 
    `name`, 
    `dish`, 
    `number`
    ) VALUES ('$txtTime', 
    '$txtName',
     '$txtDish', 
     '$txtNumber')";

// insert in database 
$rs = mysqli_query($conn, $sql);

if($rs)
{
	echo " Records Inserted";
}

?>