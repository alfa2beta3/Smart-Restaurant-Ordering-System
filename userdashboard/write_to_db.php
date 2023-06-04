<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $seatNumber = $_POST["seatNumber"];

  // Database connection parameters
  $servername = "localhost";  // Replace with your server name
  $username = "root";     // Replace with your database username
  $password = "";     // Replace with your database password
  $dbname = "rms2";       // Replace with your database name

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

// Prepare and bind the statement
$stmt = $conn->prepare("INSERT INTO seat_booking (time, A0, A1, A2, A3) VALUES (?, ?, ?, ?, ?)");

// Generate the values based on seatNumber
$time = date("Y-m-d H:i:s");  // Current timestamp
$A0 = ($seatNumber == 0) ? 1 : 0;
$A1 = ($seatNumber == 1) ? 1 : 0;
$A2 = ($seatNumber == 2) ? 1 : 0;
$A3 = ($seatNumber == 3) ? 1 : 0;

$stmt->bind_param("siiii", $time, $A0, $A1, $A2, $A3);

  // Execute the statement
  if ($stmt->execute()) {
    echo "Seat " . $seatNumber . " written to database successfully!";
  } else {
    echo "Error occurred while writing Seat " . $seatNumber . " to the database.";
  }

  // Close the statement and connection
  $stmt->close();
  $conn->close();
}
?>