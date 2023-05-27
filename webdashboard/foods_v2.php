<?php
// database connection code
$conn = mysqli_connect('localhost', 'root', '', 'rms2');

if (isset($_POST['foodName'])) {
  $txtTime = date("Y-m-d H:i:s");
  $txtName = "John";
  $txtDish = $_POST['foodName'];
  $txtNumber = "1";

  // database insert SQL code
  $sql = "INSERT INTO `orders` (`time`, `name`, `dish`, `number`) VALUES ('$txtTime', '$txtName', '$txtDish', '$txtNumber')";

  // insert in database
  $rs = mysqli_query($conn, $sql);

  if ($rs) {
    echo "Records Inserted";
  }
}
?>

<script>
  function sendRequest(foodName) {
    // Send the foodName parameter to the PHP script using AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'foods_v2.php', true); // Replace 'food_list.php' with the filename of your PHP script
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log('Response:', xhr.responseText);
      }
    };
    const data = 'foodName=' + encodeURIComponent(foodName); // Encode the foodName parameter
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
  echo '<div class="col-lg-3 col-6">';
  foreach ($foods as $food) {
    echo '<div class="food-item">';
    echo '<img class="food-image" src="' . $food['image'] . '" alt="' . $food['name'] . '">';
    echo '<div>';
    echo '<p class="food-name">' . $food['name'] . '</p>';
    echo '<button class="food-button" onclick="sendRequest(\'' . $food['name'] . '\')">Book</button>';
    echo '</div>';
    echo '</div>';
  }
  echo '</div>';
  ?>

</body>
</html>