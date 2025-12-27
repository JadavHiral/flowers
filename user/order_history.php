<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['logged_in_user']['username'];

ob_start();

// Fetch all orders of the user
$stmt = $con->prepare("
    SELECT o.*, s.name, s.address, s.city, s.state, s.country 
    FROM orders o 
    JOIN shipping s ON o.shipping_id = s.id 
    WHERE o.username = ? 
    ORDER BY o.order_date DESC
");
$stmt->bind_param("s", $username);
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<style>
  body {
      font-family: 'Open Sans', sans-serif;
      background: linear-gradient(to right, #ffeff7, #fff0f6);
      color: #5a2a4d;
  }

  .box-container {
      border: 1px solid #d6336c;
      background: #fff0f6;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 12px 25px rgba(214, 51, 108, 0.15);
      max-width: 900px;
      margin: 3rem auto;
  }

  h2 {
      text-align: center;
      color: #d6336c;
      margin-bottom: 2rem;
  }

  table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
  }

  table th, table td {
      border: 1px solid #d6336c;
      padding: 10px;
      text-align: center;
  }

  table th {
      background-color: #ffe6f0;
  }

  .btn-cancel {
      padding: 6px 12px;
      background-color: #d6336c;
      color: #fff;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      cursor: pointer;
  }

  .btn-cancel:hover {
      background-color: #ad1457;
  }

  .status-pending {
      color: #ff9800;
      font-weight: 600;
  }

  .status-completed {
      color: #4caf50;
      font-weight: 600;
  }

  .status-cancelled {
      color: #f44336;
      font-weight: 600;
  }
</style>

<div class="box-container">
    <h2>🛒 Your Orders</h2>

    <?php if ($orders): ?>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Total (₹)</th>
                <th>Status</th>
                <th>Shipping</th>
                <th>Action</th>
            </tr>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['o_id'] ?></td>
                    <td><?= $order['order_date'] ?></td>
                    <td><?= number_format($order['total_amount'], 2) ?></td>
                    <td>
                        <?php 
                        $status = $order['order_status'];
                        if ($status == 'pending') echo "<span class='status-pending'>Pending</span>";
                        elseif ($status == 'completed') echo "<span class='status-completed'>Completed</span>";
                        elseif ($status == 'cancelled') echo "<span class='status-cancelled'>Cancelled</span>";
                        ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($order['name']) ?><br>
                        <?= htmlspecialchars($order['address']) ?>, <?= htmlspecialchars($order['city']) ?>, <?= htmlspecialchars($order['state']) ?>, <?= htmlspecialchars($order['country']) ?>
                    </td>
                    <td>
                        <?php if ($order['order_status'] == 'pending'): ?>
                            <a class="btn-cancel" href="cancel_order.php?order_id=<?= $order['o_id'] ?>">Cancel</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">You have no orders yet.</p>
    <?php endif; ?>
</div>

<?php
$Content1 = ob_get_clean();
include_once("layout.php");
?>

