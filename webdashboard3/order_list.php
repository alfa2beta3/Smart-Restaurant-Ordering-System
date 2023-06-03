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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Attach click event to the dynamically generated buttons
            $(document).on('click', '.status-button', function() {
                var id = $(this).data('id');
                var sts = $(this).data('sts');
                updateStatus(id, sts);
            });

            function updateStatus(id, sts) {
                // Perform AJAX request to update the status in the database
                $.ajax({
                    url: 'update_status.php',
                    method: 'POST',
                    data: { id: id, sts: sts },
                    success: function(response) {
                        alert('Status updated successfully!');
                        // You can add additional code here to handle the successful update response
                    },
                    error: function(xhr, sts, error) {
                        alert('Error occurred while updating status.');
                        // You can add additional code here to handle the error response
                    }
                });
            }
        });
    </script>
</head>
<body>
    <?php
    $conn = mysqli_connect("localhost", "root", "", "rms2") or die("Connection Failed");

    // Retrieve the latest orders (time, name, dish, table) from the MySQL database
    if ($conn) {
        $query = "SELECT `id`, `time`, `name`, `dish`, `number`, `status` FROM `orders` ORDER BY `time` DESC LIMIT 3";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $orders = array(
                array("id" => "No data found", "name" => "No data found", "dish" => "No data found", "number" => "No data found", "status" => "0"),
                array("id" => "No data found", "name" => "No data found", "dish" => "No data found", "number" => "No data found", "status" => "0"),
                array("id" => "No data found", "name" => "No data found", "dish" => "No data found", "number" => "No data found", "status" => "0")
            );
        }
    } else {
        $orders = array(
            array("id" => "Connection Failed", "name" => "Connection Failed", "dish" => "Connection Failed", "number" => "Connection Failed", "status" => "0"),
            array("id" => "Connection Failed", "name" => "Connection Failed", "dish" => "Connection Failed", "number" => "Connection Failed", "status" => "0"),
            array("id" => "Connection Failed", "name" => "Connection Failed", "dish" => "Connection Failed", "number" => "Connection Failed", "status" => "0")
        );
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>User</th>
                <th>Time</th>
                <th>Dish</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order) : ?>
                <tr>
                    <td><?php echo isset($order['number']) ? $order['number'] : "No data found"; ?></td>
                    <td><?php echo isset($order['name']) ? $order['name'] : "No data found"; ?></td>
                    <td><?php echo isset($order['time']) ? $order['time'] : "No data found"; ?></td>
                    <td><?php echo isset($order['dish']) ? $order['dish'] : "No data found"; ?></td>
                    <td>
                        <?php
                        $id = isset($order['id']) ? $order['id'] : "";
                        $sts = isset($order['status']) ? $order['status'] : "0";
                        $buttonText = ($sts === "0") ? "Ready" : "Finished";
                        ?>
                        <button class="status-button" data-id="<?php echo $id; ?>" data-sts="<?php echo $sts; ?>"><?php echo $buttonText; ?></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>