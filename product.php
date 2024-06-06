<?php
session_start();
include 'php/config.php';
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <title>Лапки и Хвостики</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

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
                    <i class="bi bi-envelope-open fs-1 text-primary me-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Почта</h6>
                        <span>daniilfedoseev2999@gmail.com</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-phone-vibrate fs-1 text-primary me-3"></i>
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
            <h1 class="m-0 text-uppercase text-dark"><i class="bi bi-shop fs-1 text-primary me-3"></i>Лапки и Хвостики</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="index.php" class="nav-item nav-link">Дом</a>
                <a href="product.php" class="nav-item nav-link active">Товары</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="view_cart.php" class="nav-item nav-link">Корзина</a>
                    <a href="php/logout.php" class="nav-item nav-link">Выйти</a>
                <?php else: ?>
                    <a href="login.html" class="nav-item nav-link">Войти</a>
                <?php endif; ?>
                <a href="contact.php" class="nav-item nav-link nav-contact bg-primary text-white px-5 ms-lg-5">Связаться с нами <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Товары</h6>
                <h1 class="display-5 text-uppercase mb-0">Товары для ваших лучших друзей.</h1>
            </div>
            <div class="row">
                <?php
                $sql = "SELECT id, name, description, price, image FROM products";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4">';
                        echo '    <div class="product-item position-relative bg-light d-flex flex-column text-center">';
                        echo '        <img class="img-fluid mb-4" src="img/' . $row["image"] . '" alt="">';
                        echo '        <h6 class="text-uppercase">' . $row["name"] . '</h6>';
                        echo '        <h5 class="text-primary mb-0">' . $row["price"] . ' рублей</h5>';
                        echo '        <div class="btn-action d-flex justify-content-center">';
                        echo '            <form action="php/add_to_cart.php" method="post">';
                        echo '                <input type="hidden" name="product_id" value="' . $row["id"] . '">';
                        echo '                <input type="hidden" name="quantity" value="1">';
                        echo '                <button type="submit" class="btn btn-primary py-2 px-3"><i class="bi bi-cart"></i></button>';
                        echo '            </form>';
                        // echo '            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-eye"></i></a>';
                        echo '        </div>';
                        echo '    </div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Нет товаров для отображения.</p>';
                }
                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <!-- Products End -->

    <!-- Offer Start -->
    <div class="container-fluid bg-offer my-5 py-5">
        <div class="container py-5">
            <div class="row gx-5 justify-content-start">
                <div class="col-lg-7">
                    <div class="border-start border-5 border-dark ps-5 mb-5">
                        <h6 class="text-dark text-uppercase">Специальное предложение</h6>
                        <h1 class="display-5 text-uppercase text-white mb-0">СЭКОНОМЬТЕ 50% НА ВСЕХ ТОВАРАХ ПРИ ВАШЕМ ПЕРВОМ ЗАКАЗЕ</h1>
                    </div>
                    <p class="text-white mb-4">Успейте получить скидку на первый заказ в 50% при покупке от 3000 рублей.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-light mt-5 py-5">
        <div class="container pt-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Связаться</h5>
                    <p class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i>МО, г.о.Щелково, д.Долгое Ледово, ул. Центральная, стр. 33</p>
                    <p class="mb-2"><i class="bi bi-envelope-open text-primary me-2"></i>daniilfedoseev2999@gmail.com</p>
                    <p class="mb-0"><i class="bi bi-telephone text-primary me-2"></i>+79017091185</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Быстрый переход</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-body mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Домой</a>
                        <a class="text-body mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>О нас</a>
                        <a class="text-body mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Наши сервисы</a>
                        <a class="text-body mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Наша команда</a>
                        <a class="text-body" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Связаться с нами</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
