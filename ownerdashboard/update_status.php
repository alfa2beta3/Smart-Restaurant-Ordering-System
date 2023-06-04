<?php
$conn = mysqli_connect("localhost", "root", "", "rms2") or die("Connection Failed");

if ($conn) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = $_POST["id"];
        $sts = $_POST["sts"];

        if ($sts < 3)
        $sts ++;
        else
        $sts = "0";
        echo 'sts is' . $sts;


        $query = "UPDATE `orders` SET `status` = '$sts' WHERE `id` = $id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Success";
        } else {
            echo "Error occurred while updating status.";
        }
    } else {
        echo "Invalid request.";
    }
} else {
    echo "Connection Failed";
}
?>