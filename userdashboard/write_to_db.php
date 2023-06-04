<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $seatNumber = $_POST["seatNumber"];

  // Database connection parameters
  $servername = "localhost";  // Replace with your server name
  $username = "root";     // Replace with your database username
  $password = "";     // Replace with your database password
  $dbname = "rms2";       // Replace with your database name

  $conn = new mysqli($servername, $username, $password, $dbname);

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // SQL query to retrieve seat data
      $sql = "SELECT `time`, `A0`, `A1`, `A2`, `A3` FROM `seat_booking` ORDER BY `time` DESC LIMIT 1";
      $result = $conn->query($sql);

      // Generate HTML based on retrieved data
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $A0 = $row["A0"];
          $A1 = $row["A1"];
          $A2 = $row["A2"];
          $A3 = $row["A3"];
        }
      }else {
        echo "No seats found.";
      }
      $conn->close();

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

switch ($seatNumber) {
  case 0:
    $A0 = 1;
    break;
  case 1:
    $A1 = 1;
    break;
  case 2:
    $A2 = 1;
    break;
  case 3:
    $A3 = 1;
    break;
  default:
    $A0 = 1;
}

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