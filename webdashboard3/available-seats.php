<!DOCTYPE html>
<html>
<head>
  <title>Available Seats!!</title>
  <style>
    table {
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid black;
      padding: 8px;
    }
  </style>
</head>
<body>
  <h1>Available Seats!!</h1>
  <table>
    <tr>
      <th>Time</th>
      <th>A0</th>
      <th>A1</th>
      <th>A2</th>
      <th>A3</th>
    </tr>
    <?php
      // Establish your SQL database connection here

      // Assuming you have a table called "seat_booking" with columns "time", "A0", "A1", "A2", "A3"
      // Modify the connection details according to your database setup
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "rms2";

      // Create connection
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
          $time = $row["time"];

          echo '<tr>';
          echo '<td>' . $time . '</td>';

          // Seat A0
          $A0 = $row["A0"];
          $toggleA0 = ($A0 === "0") ? "false" : "true";
          echo '<td>';
          echo '<span id="statusA0">' . ($A0 === "0" ? "Opened" : "Booked") . '</span>';
          echo '</td>';

          // Seat A1
          $A1 = $row["A1"];
          $toggleA1 = ($A1 === "0") ? "false" : "true";
          echo '<td>';
          echo '<span id="statusA1">' . ($A1 === "0" ? "Opened" : "Booked") . '</span>';
          echo '</td>';

          // Seat A2
          $A2 = $row["A2"];
          $toggleA2 = ($A2 === "0") ? "false" : "true";
          echo '<td>';
          echo '<span id="statusA2">' . ($A2 === "0" ? "Opened" : "Booked") . '</span>';
          echo '</td>';

          // Seat A3
          $A3 = $row["A3"];
          $toggleA3 = ($A3 === "0") ? "false" : "true";
          echo '<td>';
          echo '<span id="statusA3">' . ($A3 === "0" ? "Opened" : "Booked") . '</span>';
          echo '</td>';

          echo '</tr>';
        }
      } else {
        echo "No seats found.";
      }

      // Close the database connection
      $conn->close();
    ?>
  </table>

  <script>
    // Function to update status
    function changeStatus(seat) {
      var statusSpan = document.getElementById("status" + seat);
      var status = statusSpan.textContent;
      statusSpan.textContent = (status === "Booked") ? "Opened" : "Booked";
    }
  </script>
</body>
</html>