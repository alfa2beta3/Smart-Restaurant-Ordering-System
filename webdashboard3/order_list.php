<!DOCTYPE html>
<html>
<head>
    <title>Latest Names from MySQL Database</title>
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
+
    <?php
    $conn = mysqli_connect("localhost", "root", "", "rms2") or die("Connection Failed");

    // Retrieve the latest orders (time, name, dish, table) from the MySQL database
    if ($conn) {
        $query = " SELECT `time`, `name`, `dish`, `number` FROM `orders` ORDER BY `time` DESC LIMIT 3";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $orders = array(
                array("time" => "No data found", "name" => "No data found", "dish" => "No data found", "number" => "No data found"),
                array("time" => "No data found", "name" => "No data found", "dish" => "No data found", "number" => "No data found"),
                array("time" => "No data found", "name" => "No data found", "dish" => "No data found", "number" => "No data found")
            );
        }
    } else {
        $orders = array(
            array("time" => "Connection Failed", "name" => "Connection Failed", "dish" => "Connection Failed", "number" => "Connection Failed"),
            array("time" => "Connection Failed", "name" => "Connection Failed", "dish" => "Connection Failed", "number" => "Connection Failed"),
            array("time" => "Connection Failed", "name" => "Connection Failed", "dish" => "Connection Failed", "number" => "Connection Failed")
        );
    }

    ?>
    <table>
        <thead>
            <tr>
                <th>Time</th>
                <th>Name</th>
                <th>Dish</th>
                <th>Number</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order) : ?>
                <tr>
                    <td><?php echo isset($order['time']) ? $order['time'] : "No data found"; ?></td>
                    <td><?php echo isset($order['name']) ? $order['name'] : "No data found"; ?></td>
                    <td><?php echo isset($order['dish']) ? $order['dish'] : "No data found"; ?></td>
                    <td><?php echo isset($order['number']) ? $order['number'] : "No data found"; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
