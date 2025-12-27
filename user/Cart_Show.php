<?php
ob_start();
session_start();
include_once("db_config.php"); // DB connection

// ✅ Correct session variable for logged-in user
if (!isset($_SESSION['logged_in_user'])) {
    header("Location: login.php");
    exit;
}
$username = $_SESSION['logged_in_user']['username'];

// Fetch cart items for this user
$stmt = $con->prepare("SELECT * FROM add_to_cart WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$cartItems = $result->fetch_all(MYSQLI_ASSOC);
?>

<style>
body {
    margin: 0;
    padding: 0;
    background: #fff0f6;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #880e4f;
}

.container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    background-color: #fce4ec;
    border-radius: 16px;
    box-shadow: 0 12px 28px rgba(233, 30, 99, 0.1);
}

h2 {
    text-align: center;
    font-weight: 700;
    font-size: 2.2rem;
    margin-bottom: 30px;
    color: #ad1457;
}

.cart-grid {
    display: grid;
    gap: 30px;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
}

.cart-item {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(214, 51, 108, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
}

.cart-item img {
    width: 100%;
    height: 200px;
    object-fit: contain;
    border-radius: 8px;
    margin-bottom: 10px;
    background: #fff0f6;
}

.cart-item h4 {
    font-size: 1.3rem;
    margin-bottom: 10px;
    color: #6a1b4d;
    text-align: center;
}

.cart-item p {
    font-size: 1rem;
    margin: 5px 0;
    text-align: center;
}

.cart-item input[type="number"] {
    width: 80px;
    padding: 6px;
    font-size: 1rem;
    border-radius: 6px;
    border: 1px solid #d6336c;
    text-align: center;
    margin: 10px auto;
}

.cart-item button {
    background-color: #d81b60;
    color: white;
    border: none;
    padding: 8px 14px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s ease;
    margin: 10px auto 0;
}

.cart-item button:hover {
    background-color: #a31549;
}

.grand-total-box {
    margin-top: 40px;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 6px 16px rgba(233, 30, 99, 0.1);
    text-align: center;
}

.grand-total-box .total {
    font-size: 1.4rem;
    font-weight: bold;
    margin-bottom: 20px;
    color: #880e4f;
}

.grand-total-box .btn {
    display: inline-block;
    padding: 12px 22px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    margin: 6px 8px;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.btn-primary {
    background-color: #ad1457;
    color: #fff;
}

.btn-primary:hover {
    background-color: #880e4f;
    box-shadow: 0 8px 20px rgba(136, 14, 79, 0.5);
}

.btn-danger {
    background-color: #d81b60;
    color: #fff;
}

.btn-danger:hover {
    background-color: #a31549;
    box-shadow: 0 8px 20px rgba(163, 21, 73, 0.5);
}

.empty-cart {
    text-align: center;
    font-size: 1.3rem;
    margin-top: 60px;
    color: #ad1457;
}
</style>

<div class="container">
    <h2>🛒 Your Shopping Cart</h2>

    <?php if (!empty($cartItems)): ?>
        <form method="post" action="order.php">
            <div class="cart-grid">
                <?php
                $grandTotal = 0;
                foreach ($cartItems as $item):
                    $itemTotal = $item['price'] * $item['qty'];
                    $grandTotal += $itemTotal;
                ?>
                <div class="cart-item" data-id="<?= htmlspecialchars($item['cart_id']) ?>">
                    <img src="<?= htmlspecialchars($item['img']) ?>" alt="<?= htmlspecialchars($item['pnm']) ?>">
                    <h4><?= htmlspecialchars($item['pnm']) ?></h4>
                    <p>Price: ₹<span class="item-price"><?= number_format($item['price'], 2) ?></span></p>
                    <label>Quantity:
                        <input type="number" name="quantities[<?= $item['cart_id'] ?>]" value="<?= (int)$item['qty'] ?>" min="1" class="qty-input">
                    </label>
                    <p>Total: ₹<span class="item-total"><?= number_format($itemTotal, 2) ?></span></p>
                    <label>
                        Select:
                        <input type="checkbox" class="product-checkbox" name="selected_products[]" value="<?= $item['cart_id'] ?>" checked>
                    </label>
                    <button type="button" class="btn btn-danger btn-remove" data-id="<?= $item['cart_id'] ?>">Remove</button>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="grand-total-box">
                <div class="total">Grand Total: ₹<span id="grandTotal"><?= number_format($grandTotal, 2) ?></span></div>
                <button type="submit" class="btn btn-primary">✅ Place Order</button>
                <a href="clear_cart.php" class="btn btn-danger">🗑️ Clear Cart</a>
                <a href="product.php" class="btn btn-primary">⬅️ Back to Products</a>
            </div>
        </form>
    <?php else: ?>
        <p class="empty-cart">Your cart is currently empty.</p>
        <div style="text-align:center; margin-top: 20px;">
            <a href="product.php" class="btn btn-primary">⬅️ Back to Products</a>
        </div>
    <?php endif; ?>
</div>

<script>
// Update item totals on quantity change
document.querySelectorAll('.qty-input').forEach(input => {
    input.addEventListener('input', () => {
        const item = input.closest('.cart-item');
        const price = parseFloat(item.querySelector('.item-price').textContent);
        let qty = parseInt(input.value);
        if (isNaN(qty) || qty < 1) qty = 1;
        input.value = qty;
        const total = price * qty;
        item.querySelector('.item-total').textContent = total.toFixed(2);
        updateGrandTotal();
    });
});

// Remove item from cart via AJAX
document.querySelectorAll('.btn-remove').forEach(button => {
    button.addEventListener('click', () => {
        const cart_id = button.getAttribute('data-id');
        fetch(`remove_from_cart.php?cart_id=${cart_id}`)
            .then(() => {
                button.closest('.cart-item').remove();
                updateGrandTotal();
            });
    });
});

// Update grand total based on selected checkboxes
document.querySelectorAll('.product-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateGrandTotal);
});

function updateGrandTotal() {
    let total = 0;
    document.querySelectorAll('.cart-item').forEach(item => {
        const checkbox = item.querySelector('.product-checkbox');
        if (checkbox.checked) {
            const itemTotal = parseFloat(item.querySelector('.item-total').textContent);
            total += itemTotal;
        }
    });
    document.getElementById('grandTotal').textContent = total.toFixed(2);
}
</script>

<?php
$Content1 = ob_get_clean();
include_once("layout.php");
?>
