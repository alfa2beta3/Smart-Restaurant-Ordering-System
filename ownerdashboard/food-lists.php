<!DOCTYPE html>
<html>
<head>
  <title>Table with MySQL Integration</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <table>
    <tr>
      <th>num</th>
      <th>food</th>
      <th>price</th>
      <th>pictures</th>
      <th>categories</th>
      <th>Action</th>
    </tr>
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
      
      // Retrieve data from the MySQL database
      $sql = "SELECT * FROM food_lists";
      $result = $conn->query($sql);
      
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["num"] . "</td>";
          echo "<td>" . $row["food"] . "</td>";
          echo "<td>" . $row["price"] . "</td>";
          echo "<td><img src='" . $row["pictures"] . "' alt='Food Picture'></td>";
          echo "<td>" . $row["categories"] . "</td>";
          echo "<td><form method='POST' action='delete_row.php'><input type='hidden' name='row_id' value='" . $row["num"] . "'><input type='submit' value='Delete'></form></td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='6'>No data found</td></tr>";
      }
      
      $conn->close();
    ?>
  </table>

  <!-- Add a form to add a new row -->
  <h2>Add a New Row</h2>
  <form method="POST" action="add_row.php">
    <input type="text" name="num" placeholder="num">
    <input type="text" name="food" placeholder="food">
    <input type="text" name="price" placeholder="price">
    <input type="text" name="pictures" placeholder="pictures">
    <input type="text" name="categories" placeholder="categories">
    <input type="submit" value="Add Row">
  </form>
</body>
</html>