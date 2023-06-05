<?php
  // Establish a connection to the MySQL database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "rms2";
  
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  // Retrieve the row ID from the form submission
  $row_id = $_POST["row_id"];
  
  // Delete the row from the MySQL database
  $sql = "DELETE FROM food_lists WHERE num = '$row_id'";
  
  if ($conn->query($sql) === TRUE) {
    echo "Row deleted successfully";
  } else {
    echo "Error deleting row: " . $conn->error;
  }
  
  $conn->close();
?>

<script>
  window.opener.location.reload();
  window.close();
</script>