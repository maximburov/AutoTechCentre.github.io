<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/connect.php');

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$login_error = '';
$service = isset($_GET['service']) ? $_GET['service'] : '';

if (isset($_POST['login_submit'])) {
    // Получаем данные от пользователя
    $login = $_POST['login_login'];
    $password = $_POST['login_password'];
    
    // Используем подготовленный запрос!
    $sql = "SELECT * FROM users WHERE Login = ?";
    $stmt = mysqli_prepare($link, $sql);
    
    if ($stmt) {
        // Привязываем параметр: s = string (строка)
        mysqli_stmt_bind_param($stmt, "s", $login);
        
        // Выполняем запрос
        mysqli_stmt_execute($stmt);
        
        // Получаем результат
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            // Проверяем пароль с помощью password_verify()
            if (password_verify($password, $row['password'])) {
                $_SESSION['user'] = $row;
                
                if (!empty($service)) {
                    header("Location: index.php#request-form");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                $login_error = "Неверный логин или пароль";
            }
        } else {
            $login_error = "Неверный логин или пароль";
        }
        
        mysqli_stmt_close($stmt);
    } else {
        $login_error = "Ошибка подготовки запроса";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - АвтоТехЦентр "Bosh"</title>
    <link rel="stylesheet" href="./css/style.css">
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
                <a href="register.php<?= $service ? '?service='.$service : '' ?>" class="nav-link">Регистрация</a>
            </nav>
        </div>
    </header>
    
    <main class="content">
        <div class="content-container">
            <form method="POST" class="form-section login-form">
                <h2 class="section-title">Вход</h2>
                
                <?php if ($service): ?>
                    <div class="info-msg" style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        Войдите, чтобы записаться на выбранную услугу
                    </div>
                <?php endif; ?>
                
                <?php if ($login_error): ?>
                    <div class="error-msg"><?= htmlspecialchars($login_error) ?></div>
                <?php endif; ?>
                
                <div class="input-group">
                    <div class="field">
                        <label class="field-label">Ваш логин</label>
                        <input class="text-input login-field" name="login_login" type="text" placeholder="Логин" required>
                    </div>
                    
                    <div class="field">
                        <label class="field-label">Ваш пароль</label>
                        <input class="text-input pass-field" name="login_password" type="password" placeholder="Пароль" required>
                    </div>
                    
                    <?php if ($service): ?>
                        <input type="hidden" name="service" value="<?= htmlspecialchars($service) ?>">
                    <?php endif; ?>
                    
                    <button type="submit" name="login_submit" class="action-btn">Войти</button>
                </div>
                
                <p style="text-align: center; margin-top: 1rem;">
                    Нет аккаунта? <a href="register.php<?= $service ? '?service='.$service : '' ?>" style="color: var(--primary);">Зарегистрируйтесь</a>
                </p>
            </form>
        </div>
    </main>
    
    <footer class="bottom-footer">
        <div class="footer-content">
            <div class="phone-number">
                Контактный номер: +7 (960) 570-95-30
            </div>
            <div class="copyright">
                &copy; 2026 АвтоТехЦентр "Bosh". Все права защищены.
            </div>
        </div>
    </footer>
</body>
</html>