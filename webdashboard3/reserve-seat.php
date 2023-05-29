<!DOCTYPE html>
<html>
<head>
  <title>Book your seat!!</title>
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
  <h1>Book your seat!!</h1>
  <table>
    <tr>
      <th>Number</th>
      <th>Table Numbers</th>
      <th>Status</th>
    </tr>
    <tr>
      <td>1</td>
      <td>A1</td>
      <td>
        <span id="status1">Booked</span>
        <button onclick="changeStatus(1)">Toggle</button>
      </td>
    </tr>
    <tr>
      <td>2</td>
      <td>A2</td>
      <td>
        <span id="status2">Booked</span>
        <button onclick="changeStatus(2)">Toggle</button>
      </td>
    </tr>
    <tr>
      <td>3</td>
      <td>A3</td>
      <td>
        <span id="status3">Booked</span>
        <button onclick="changeStatus(3)">Toggle</button>
      </td>
    </tr>
  </table>

  <script>
    var sts = ["Booked", "Booked", "Booked"]; // Initial status
    var toggle = ["false","false","false"]; // Boolean to toggle status

    // Function to update status
    function changeStatus(row) {
      toggle[row - 1] = !toggle[row - 1];
      var statusSpan = document.getElementById("status" + row);
      statusSpan.textContent = toggle [row - 1]? sts[row - 1] : (sts[row - 1] === "Booked" ? "Opened" : "Booked");
    }
  </script>
</body>
</html>