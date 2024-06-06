<?php
include 'php/config.php';
session_start();

// Получаем имя пользователя из сессии, если пользователь аутентифицирован
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT username FROM users WHERE id = '$user_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
    } else {
        $username = "Пользователь";
    }
} else {
    $username = "Гость";
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$order_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['remove_product_id'])) {
        $remove_product_id = $_POST['remove_product_id'];
        $remove_stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        $remove_stmt->bind_param("ii", $user_id, $remove_product_id);
        $remove_stmt->execute();
        header("Location: view_cart.php");
        exit;
    } elseif (isset($_POST['update_product_id']) && isset($_POST['action'])) {
        $update_product_id = $_POST['update_product_id'];
        $action = $_POST['action'];
        
        $current_quantity_stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
        $current_quantity_stmt->bind_param("ii", $user_id, $update_product_id);
        $current_quantity_stmt->execute();
        $current_quantity_result = $current_quantity_stmt->get_result();
        
        if ($current_quantity_result->num_rows > 0) {
            $current_quantity_row = $current_quantity_result->fetch_assoc();
            $current_quantity = $current_quantity_row['quantity'];
            
            if ($action == "increase") {
                $new_quantity = $current_quantity + 1;
            } elseif ($action == "decrease") {
                $new_quantity = max(1, $current_quantity - 1); // Ensure quantity doesn't go below 1
            }
            
            $update_stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
            $update_stmt->bind_param("iii", $new_quantity, $user_id, $update_product_id);
            $update_stmt->execute();
            header("Location: view_cart.php");
            exit;
        }
    } elseif (isset($_POST['total_price'])) {
        $total_price = $_POST['total_price'];

        // Check if the cart is empty
        $cart_check_stmt = $conn->prepare("SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = ?");
        $cart_check_stmt->bind_param("i", $user_id);
        $cart_check_stmt->execute();
        $cart_check_result = $cart_check_stmt->get_result();
        $cart_count_row = $cart_check_result->fetch_assoc();

        if ($cart_count_row['cart_count'] == 0) {
            $order_message = "Ваша корзина пуста. Пожалуйста, добавьте товары в корзину перед оформлением заказа.";
        } else {
            $conn->begin_transaction();

            try {
                $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
                $stmt->bind_param("id", $user_id, $total_price);
                $stmt->execute();
                $order_id = $stmt->insert_id;

                $stmt = $conn->prepare("SELECT product_id, quantity FROM cart WHERE user_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($result && $row = $result->fetch_assoc()) {
                    $product_id = $row['product_id'];
                    $quantity = $row['quantity'];

                    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, (SELECT price FROM products WHERE id = ?))");
                    $stmt->bind_param("iiii", $order_id, $product_id, $quantity, $product_id);
                    $stmt->execute();
                }

                $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();

                $conn->commit();

                $order_message = "Заказ успешно оформлен!";
            } catch (Exception $e) {
                $conn->rollback();
                $order_message = "Не удалось оформить заказ: " . $e->getMessage();
            }
        }
    }
}

$stmt = $conn->prepare("SELECT products.id, products.name, products.price, cart.quantity FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid border-bottom d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-lg-4 text-center py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-geo-alt fs-1 text-primary me-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Офис</h6>
                        <span>МО, г.о.Щелково, д.Долгое Ледово, ул. Центральная, стр. 33</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center border-start border-end py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-envelope-open fs-1 text-primary ме-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Почта</h6>
                        <span>daniilfedoseev2999@gmail.com</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-phone-vibrate fs-1 text-primary ме-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Связаться с нами</h6>
                        <span>+79017091185</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm py-3 py-lg-0 px-3 px-lg-0 mb-5">
        <a href="index.html" class="navbar-brand ms-lg-5">
            <h1 class="m-0 text-uppercase text-dark"><i class="bi bi-shop fs-1 text-primary ме-3"></i>Лапки и Хвостики</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="index.php" class="nav-item nav-link">Дом</a>
                <a href="product.php" class="nav-item nav-link">Товары</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="view_cart.php" class="nav-item nav-link active">Корзина</a>
                <a href="php/logout.php" class="nav-item nav-link">Выйти</a>
                <p class="nav-item nav-user"><?php echo $username; ?></p>
                <?php else: ?>
                <a href="login.html" class="nav-item nav-link">Войти</a><br>
                <?php endif; ?>
                <a href="contact.php" class="nav-item nav-link nav-contact bg-primary text-white px-5 ms-lg-5">Связаться с нами <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <div class="cart">
    <h1>Ваша корзина</h1>
    <?php if ($order_message): ?>
        <div class="alert alert-info">
            <?php echo $order_message; ?>
        </div>
    <?php endif; ?>
    <table>
        <tr>
            <th>Товар</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Итого</th>
            <th>Действие</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td>
                    <form action="view_cart.php" method="post" style="display:inline-block;">
                        <input type="hidden" name="update_product_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="action" value="decrease">
                        <button type="submit">-</button>
                    </form>
                    <?php echo $row['quantity']; ?>
                    <form action="view_cart.php" method="post" style="display:inline-block;">
                        <input type="hidden" name="update_product_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="action" value="increase">
                        <button type="submit">+</button>
                    </form>
                </td>
                <td><?php echo $row['price'] * $row['quantity']; ?></td>
                <td>
                    <form action="view_cart.php" method="post">
                        <input type="hidden" name="remove_product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit">Удалить</button>
                    </form>
                </td>
            </tr>
            <?php $total_price += $row['price'] * $row['quantity']; ?>
        <?php endwhile; ?>
    </table>
    <h2>Общая сумма: <?php echo $total_price; ?></h2>
    <form action="view_cart.php" method="post">
        <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
        <button type="submit">Оформить заказ</button>
    </form>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
