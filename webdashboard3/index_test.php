<?php 

$conn = mysqli_connect("localhost","root","","rms2") or die("Connection Failed");
$indicator = "";

if ($conn) {
    $indicator = "Connection Successful";

    $query = "SELECT `dish` FROM `orders` ORDER BY time DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $lastData = $row['dish'];
        
        // Display the last data within the variable "name"
        echo $lastData. "<br>";
    } else {
        echo "No data found for variable 'dish'";
    }
} else {
    echo "Connection Failed";
}

?>