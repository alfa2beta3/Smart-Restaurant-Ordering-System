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
    echo '<button class="food-button"  onclick="sendRequest(\'' . $food['name'] . '\')">Book</button>';
    echo '</div>';
    echo '</div>';
    
  }
  echo '</div>';

  ?>
  
</body>
</html>

<script>
function sendRequest(foodName) {
  const url = 'https://example.com/api'; // Replace with the URL of the other website's API

  fetch(url, {
    method: 'POST',
    body: JSON.stringify({ foodName: foodName }),
    headers: {
      'Content-Type': 'application/json'
    }
  })
  .then(response => {
    if (response.ok) {
      // Request successful
      console.log('Request sent successfully');
      // You can perform any additional actions here
    } else {
      // Request failed
      console.error('Error sending request');
    }
  })
  .catch(error => {
    console.error('Error sending request:', error);
  });
}
</script>