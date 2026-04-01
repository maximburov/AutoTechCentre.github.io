<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/connect.php');

if (isset($_POST['request_submit']) && isset($_SESSION['user']) && $_SESSION['user']['status'] == 0) {
    $title = $_POST['request_title'];
    $text = $_POST['request_text'];
    
    $sql = "INSERT INTO news (title, text, link) VALUES (?, ?, 'на рассмотрении')";
    $stmt = mysqli_prepare($link, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $title, $text);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    
    header("Location: " . $_SERVER['PHP_SELF'] . "#request-form");
    exit();
}

if (isset($_POST['update_status']) && isset($_SESSION['user']) && $_SESSION['user']['status'] == 1) {
    $id = (int)$_POST['request_id'];  
    $status = $_POST['status'];
    
    $sql = "UPDATE news SET link = ? WHERE id = ?";
    $stmt = mysqli_prepare($link, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $status, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_GET['delete_request']) && isset($_SESSION['user']) && $_SESSION['user']['status'] == 1) {
    $id = (int)$_GET['delete_request'];
    
    $sql = "DELETE FROM news WHERE id = ?";
    $stmt = mysqli_prepare($link, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$requests = mysqli_query($link, "SELECT * FROM news ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Авторизованный автосервис Bosh в Касимове. Качественный ремонт, диагностика, антикоррозийная обработка и мойка автомобилей. Запись онлайн.">
    <meta name="keywords" content="автосервис, ремонт автомобилей, диагностика, Касимов, Bosh, замена масла, антикоррозийная обработка">
    <title>АвтоТехЦентр "Bosh"</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://api-maps.yandex.ru/2.1/?apikey=ваш_api_ключ&lang=ru_RU" type="text/javascript"></script>
    <style>
        #map {
            width: 100%;
            height: 450px;
            margin-bottom: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <header class="top-header">
        <div class="top-container">
            <div class="logo-box">
                <img src="./img/XXL_height-Photoroom.png" alt="" width="192" height="90">
                <div class="box-text">АвтоТехЦентр "Bosh"</div>
            </div>
            <nav class="main-nav">
                <a href="index.php" class="nav-link">Главная</a>
                <a href="services.php" class="nav-link">Услуги</a>
                <?php if (!isset($_SESSION['user'])): ?>
                    <a href="login.php" class="nav-link">Вход</a>
                    <a href="register.php" class="nav-link">Регистрация</a>
                <?php else: ?>
                    <a href="?logout=1" class="nav-link">Выйти</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    
    <main class="content">
        <div id="map"></div>
        
        <script type="text/javascript">
            ymaps.ready(init);
            
            function init() {
                var myMap = new ymaps.Map("map", {
                    center: [54.9515, 41.4249],
                    zoom: 17,
                    controls: ['zoomControl', 'fullscreenControl']
                });
                
                var myPlacemark = new ymaps.Placemark([54.9515, 41.4249], {
                    hintContent: 'АвтоТехЦентр "Bosh"',
                    balloonContent: '<strong>АвтоТехЦентр "Bosh"</strong><br>г. Касимов<br>Телефон: +7 (960) 570-95-30'
                }, {
                    preset: 'islands#redIcon'
                });
                
                myMap.geoObjects.add(myPlacemark);
                
                var searchControl = new ymaps.control.SearchControl({
                    options: {
                        provider: 'yandex#search'
                    }
                });
                myMap.controls.add(searchControl);
            }
        </script>
        
        <div class="content-container">
            <div class="container-list">
                <div class="list-text">О нас</div>
                <ul class="list">
                    <li class="list-el"><img src="./img/1.png" width="30" height="30">Антикор</li>
                    <li class="list-el"><img src="./img/1.png" width="30" height="30">Авторизованный диагностический центр</li>
                    <li class="list-el"><img src="./img/1.png" width="30" height="30">Предварительная запись</li>
                    <li class="list-el"><img src="./img/1.png" width="30" height="30">Wi-fi</li>
                    <li class="list-el"><img src="./img/1.png" width="30" height="30">Официальный автосервис</li>
                    <li class="list-el"><img src="./img/1.png" width="30" height="30">Мойка</li>
                </ul>
            </div>
            
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['status'] == 0): ?>
                <form method="POST" class="form-section add-request" id="request-form">
                    <h2 class="section-title">Оставить заявку на услугу</h2>
                    <div class="input-group">
                        <div class="field">
                            <label class="field-label">Название услуги</label>
                            <input class="text-input request-title" name="request_title" type="text" placeholder="Например: Замена масла" required>
                        </div>
                        <div class="field">
                            <label class="field-label">Описание проблемы</label>
                            <textarea class="text-input request-content" name="request_text" placeholder="Опишите проблему" required></textarea>
                        </div>
                        <button type="submit" name="request_submit" class="action-btn submit-request">Отправить заявку</button>
                    </div>
                </form>
            <?php endif; ?>

            <?php if (isset($_SESSION['user']) && $_SESSION['user']['status'] == 1): ?>
                <div class="requests-section divider">
                    <h2 class="section-title">Заявки на услуги</h2>
                    <div class="requests-list">
                        <?php while ($row = mysqli_fetch_assoc($requests)): ?>
                            <div class="request-item item-<?= $row['id'] ?>">
                                <h3 class="request-heading"><?= htmlspecialchars($row['title']) ?></h3>
                                <div class="request-body"><?= nl2br(htmlspecialchars($row['text'])) ?></div>
                                
                                <div class="request-status">
                                    <form method="POST" class="status-form">
                                        <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                                        <select name="status" class="status-select">
                                            <option value="на рассмотрении" <?= $row['link'] == 'на рассмотрении' ? 'selected' : '' ?>>На рассмотрении</option>
                                            <option value="в работе" <?= $row['link'] == 'в работе' ? 'selected' : '' ?>>В работе</option>
                                            <option value="готов" <?= $row['link'] == 'готов' ? 'selected' : '' ?>>Готов</option>
                                        </select>
                                        <button type="submit" name="update_status" class="action-btn update-btn">Обновить статус</button>
                                    </form>
                                    <span class="current-status">Текущий статус: <strong><?= htmlspecialchars($row['link']) ?></strong></span>
                                </div>

                                <div class="request-actions">
                                    <a href="?delete_request=<?= $row['id'] ?>" class="action-btn delete-btn"
                                        onclick="return confirm('Удалить заявку?')">Удалить</a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (!isset($_SESSION['user'])): ?>
                <div class="form-section" style="text-align: center;">
                    <h2 class="section-title">Хотите оставить заявку?</h2>
                    <p style="margin-bottom: 2rem;">Для оформления заявки необходимо авторизоваться или зарегистрироваться</p>
                    <div style="display: flex; gap: 1rem; justify-content: center;">
                        <a href="login.php" class="action-btn" style="padding: 1rem 2rem;">Войти</a>
                        <a href="register.php" class="action-btn" style="background-color: var(--secondary); padding: 1rem 2rem;">Зарегистрироваться</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
    
    <footer class="bottom-footer">
        <div class="footer-content">
            <div class="phone-number">
                <i class="fas fa-phone"></i>Контактный номер: +7 (960) 570-95-30
            </div>
            
            <div class="copyright">
                &copy; 2026 АвтоТехЦентр "Bosh". Все права защищены.
            </div>
        </div>
    </footer>
</body>
</html>