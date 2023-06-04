
<?php
$path = 'idcount.txt';

// Opens countlog.txt to read the number of hits.
$file  = fopen( $path, 'r' );
$txtId = fgets( $file, 1000 );
fclose( $file );

?>

<?php

// Globally define the Timezone
define( 'TIMEZONE', 'Asia/Singapore' );

// Set Timezone
date_default_timezone_set( TIMEZONE );
// database connection code
$conn = mysqli_connect('localhost', 'root', '', 'rms2');

if (isset($_POST['foodName'])) {
  $txtTime = date("Y-m-d H:i:s");
  $txtName = "John";
  $txtDish = $_POST['foodName'];
  $txtSeat = "1";
  $txtStatus = "0";

  // database insert SQL code
  $sql = "INSERT INTO `orders` (`id`,`time`, `name`, `dish`, `number`,`status` ) VALUES ('$txtId', '$txtTime', '$txtName', '$txtDish', '$txtSeat','$txtStatus' )";

  // insert in database
  $rs = mysqli_query($conn, $sql);

  if ($rs) {
    echo "Records Inserted \n";
    
    echo $txtTime;
  }

  // Include the PHP file that contains the function
  require_once 'counter.php';
  
  // Call the function
  inc();

}


?>

<script>
  function sendRequest(foodName) {
  // Add animation class to the button
  const button = event.target;
  button.classList.add('animate');

  // Send the foodName parameter to the PHP script using AJAX
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'foods_v2.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      console.log('Response:', xhr.responseText);
      // Remove animation class after receiving the response
      button.classList.remove('animate');
    }
  };
  const data = 'foodName=' + encodeURIComponent(foodName);
  xhr.send(data);
}
</script>

<!DOCTYPE html>
<html>
<head>
  <title>Food List</title>
  <style>
    .food-item {
      display: inline-block;
      width: 23%;
      margin: 10px;
      text-align: center;
    }

    .food-image {
      width: 100px; /* Adjust the width as desired */
      height: auto;
      margin-bottom: 10px;
    }

    .food-name {
      font-weight: bold;
    }

    .food-button {
      padding: 5px 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }

    .animate {
    animation-name: myAnimation;
    animation-duration: 2s;
    animation-timing-function: ease-in-out; /* Example of an animation timing function */
    animation-delay: 0.2s; /* Example of an animation delay */
    animation-iteration-count: 1; /* Example of the number of times the animation should repeat */
    animation-direction: normal; /* Example of the animation direction */
    /* Additional animation properties */
  }

  @keyframes myAnimation {
    0% {
      /* Initial state */
      transform: scale(1);
      opacity: 1;
    }

    50% {
      /* Mid-state */
      transform: scale(1.5);
      opacity: 0.5;
    }

    100% {
      /* Final state */
      transform: scale(1);
      opacity: 1;
    }
  }
  </style>
</head>
<body>
  <h1>Food List</h1>
  
  <?php include "food_list_input.php"; ?>

  <?php
  // PHP variables with food names and image sources
  $foods = array(
    array('name' => $foodname['0'], 'image' => $foodimages['0']),
    array('name' => $foodname['1'], 'image' => $foodimages['1']),
    array('name' => $foodname['2'], 'image' => $foodimages['2']),
    array('name' => $foodname['3'], 'image' => $foodimages['3']),
    array('name' => $foodname['4'], 'image' => $foodimages['4']),
    array('name' => $foodname['5'], 'image' => $foodimages['5']),
    array('name' => $foodname['6'], 'image' => $foodimages['6']),
    array('name' => $foodname['7'], 'image' => $foodimages['7']),
  );
  // Generate HTML for each food item
  foreach ($foods as $food) {
    echo '<div class="food-item">';
    echo '<img class="food-image" src="' . $food['image'] . '" alt="' . $food['name'] . '">';
    echo '<div>';
    echo '<p class="food-name">' . $food['name'] . '</p>';
    echo '<button class="food-button" onclick="sendRequest(\'' . $food['name'] . '\')">Book</button>';
    echo '</div>';
    echo '</div>';
  }
  ?>

</body>
</html>