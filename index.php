<?php
session_start();
include 'php/config.php';

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
?>

<!DOCTYPE html>
<html lang="en">

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
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm py-3 py-lg-0 px-3 px-lg-0">
        <a href="index.html" class="navbar-brand ms-lg-5">
            <h1 class="m-0 text-uppercase text-dark"><i class="bi bi-shop fs-1 text-primary me-3"></i>Лапки и Хвостики</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="index.php" class="nav-item nav-link active">Дом</a>
                <a href="product.php" class="nav-item nav-link">Товары</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="view_cart.php" class="nav-item nav-link">Корзина</a>
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


    <!-- Hero Start -->
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-start">
                <div class="col-lg-8 text-center text-lg-start">
                    <h1 class="display-1 text-uppercase text-dark mb-lg-4">Лапки и Хвостики</h1>
                    <h1 class="text-uppercase text-white mb-lg-4">Сделай своего питомца счастливее</h1>
                    <p class="fs-4 text-white mb-lg-4">Что может быть лучше чем счастье и здоровье своего питомца?! Правильно, ничего. Именно поэтому мы и заботимся о качесвте наших товаров и услуг.</p>
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-start pt-5">
                        
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->


    <!-- Video Modal Start -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always"
                            allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video Modal End -->


    <!-- About Start -->
    <section id="about">
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded" src="img/about.jpg" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="border-start border-5 border-primary ps-5 mb-5">
                        <h6 class="text-primary text-uppercase">О НАС</h6>
                        <h1 class="display-5 text-uppercase mb-0">МЫ ПОСТОЯННО ЗАБОТИМСЯ О ТОМ, ЧТОБЫ ВАШИ ПИТОМЦЫ БЫЛИ СЧАСТЛИВЫ</h1>
                    </div>
                 
                    <div class="bg-light p-4">
                        <ul class="nav nav-pills justify-content-between mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item w-50" role="presentation">
                                <button class="nav-link text-uppercase w-100 active" id="pills-1-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1"
                                    aria-selected="true">Наша миссия</button>
                            </li>
                            <li class="nav-item w-50" role="presentation">
                                <button class="nav-link text-uppercase w-100" id="pills-2-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2"
                                    aria-selected="false">Наше видение</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                                <p class="mb-0">Мисиия нашей компании заключается в том, что мы продаем только лучшие из лучших товаров. Все для ваших животных, все для их счастья!</p>
                            </div>
                            <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                                <p class="mb-0">Не всегда товары, которые мы покупаем своим питомцам, удволетворяют нашим требованиям. Много химии, ноль качества. По нашему мнению, питомцы должны питаться качественной и здоровой пищей, которую мы и предоставляем!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    
    <!-- About End -->
    

    <!-- Services Start -->
    <section id="service">
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Сервисы</h6>
                <h1 class="display-5 text-uppercase mb-0">Наши услуги по уходу за домашними животными</h1>
            </div>
            <div class="row g-5">
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-house display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Размещение домашних животных</h5>
                            <p>Подберем лучший питомник, если вам надо уехать в командировку, а оставить питомца не с кем.</p>
                           
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-food display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Питание домашних животных</h5>
                            <p>Подберем лучший корм вашему питомцу</p>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-grooming display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Груммниг</h5>
                            <p>Наши грумминг спциалисты сделают вашего питоца еще более красивым!</p>
                           
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-cat display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Кинологические услуги</h5>
                            <p>Кинологи с оытом более 10 лет работы с животными помогут сделать из вашего питоца "императора" животного мира.</p>
                          
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-dog display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Упражнение для домашних животных</h5>
                            <p>Консультация кинологов по занятиям в домашних условиях со своим питомцем.</p>
                           
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item bg-light d-flex p-4">
                        <i class="flaticon-vaccine display-1 text-primary me-4"></i>
                        <div>
                            <h5 class="text-uppercase mb-3">Рекомендации</h5>
                            <p>Рекомендации от ветеринаров по уходом за вашим питомцем</p>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- Services End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Товары</h6>
                <h1 class="display-5 text-uppercase mb-0">Товары для ваших лучших друзей.</h1>
            </div>
            <div class="owl-carousel product-carousel">
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="img/product-1.png" alt="">
                        <h6 class="text-uppercase">Корм для попугаев (сухой)</h6>
                        <h5 class="text-primary mb-0">400 рублей</h5>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-cart"></i></a>
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="img/product-2.png" alt="">
                        <h6 class="text-uppercase">Сухой корм для кошек</h6>
                        <h5 class="text-primary mb-0">600 рублей</h5>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-cart"></i></a>
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="img/product-3.png" alt="">
                        <h6 class="text-uppercase">Сухой корм для собак</h6>
                        <h5 class="text-primary mb-0">4000 рублей</h5>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-cart"></i></a>
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="img/product-4.png" alt="">
                        <h6 class="text-uppercase">Сухой корм для рыб</h6>
                        <h5 class="text-primary mb-0">500 рублей</h5>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-cart"></i></a>
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="img/product-5.png" alt="">
                        <h6 class="text-uppercase">Сухой корм для черепах</h6>
                        <h5 class="text-primary mb-0">700 рублей</h5>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-cart"></i></a>
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-eye"></i></a>
                        </div>
                    </div>
                </div>
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


    <!-- Pricing Plan Start -->
    
    <!-- Pricing Plan End -->


    <!-- Team Start -->
    <section id="team">
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Члены команды</h6>
                <h1 class="display-5 text-uppercase mb-0">Квалифицированные специалисты по уходу за домашними животными</h1>
            </div>
            <div class="owl-carousel team-carousel position-relative" style="padding-right: 25px;">
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="img/team-1.jpg" alt="">
                    </div>
                    <div class="bg-light text-center p-4">
                        <h5 class="text-uppercase">Дарья</h5>
                        <p class="m-0">Груминг специалист</p>
                    </div>
                </div>
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="img/team-2.jpg" alt="">
                    </div>
                    <div class="bg-light text-center p-4">
                        <h5 class="text-uppercase">Анастасия</h5>
                        <p class="m-0">Кинолог</p>
                    </div>
                </div>
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="img/team-3.jpg" alt="">
                    </div>
                    <div class="bg-light text-center p-4">
                        <h5 class="text-uppercase">Валентина</h5>
                        <p class="m-0">Груминг специалист</p>
                    </div>
                </div>
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="img/team-4.jpg" alt="">
                    </div>
                    <div class="bg-light text-center p-4">
                        <h5 class="text-uppercase">Алина</h5>
                        <p class="m-0">Ветеринар</p>
                    </div>
                </div>
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="img/team-5.jpg" alt="">
                    </div>
                    <div class="bg-light text-center p-4">
                        <h5 class="text-uppercase">Надежда</h5>
                        <p class="m-0">Специалист</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- Team End -->
    
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
                        <a class="text-body mb-2" href="index.php"><i class="bi bi-arrow-right text-primary me-2"></i>Домой</a>
                        <a class="text-body mb-2" href="#about"><i class="bi bi-arrow-right text-primary me-2"></i>О нас</a>
                        <a class="text-body mb-2" href="#service"><i class="bi bi-arrow-right text-primary me-2"></i>Наши сервисы</a>
                        <a class="text-body mb-2" href="#team"><i class="bi bi-arrow-right text-primary me-2"></i>Наша команда</a>
                        <a class="text-body" href="contact.php"><i class="bi bi-arrow-right text-primary me-2"></i>Связаться с нами</a>
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