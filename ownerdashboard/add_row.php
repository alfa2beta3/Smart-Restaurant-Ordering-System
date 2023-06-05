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
  
  // Retrieve form data
  $num = $_POST["num"];
  $food = $_POST["food"];
  $price = $_POST["price"];
  $pictures = $_POST["pictures"];
  $categories = $_POST["categories"];
  
  // Insert data into the MySQL database
  $sql = "INSERT INTO food_lists (num, food, price, pictures, categories) VALUES ('$num', '$food', '$price', '$pictures', '$categories')";
  
  if ($conn->query($sql) === TRUE) {
    echo "New row added successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  
  $conn->close();
?>

<script>
  window.opener.location.reload();
  window.close();
</script>
