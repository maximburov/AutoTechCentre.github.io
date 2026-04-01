<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/connect.php');

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$register_error = '';
$service = isset($_GET['service']) ? $_GET['service'] : '';

if (isset($_POST['register_submit'])) {
    $login = $_POST['register_login'];
    $email = $_POST['register_email'];
    $password = $_POST['register_password'];
    $privacy_agreement = isset($_POST['privacy_agreement']);

    // Проверка длины пароля
    if (strlen($password) < 6) {
        $register_error = "Пароль должен содержать минимум 6 символов";
    } elseif (!$privacy_agreement) {
        $register_error = "Необходимо согласие на обработку персональных данных";
    } else {
        // Сначала проверяем, существует ли пользователь с таким логином
        $check_sql = "SELECT id FROM users WHERE Login = ?";
        $check_stmt = mysqli_prepare($link, $check_sql);
        
        if ($check_stmt) {
            mysqli_stmt_bind_param($check_stmt, "s", $login);
            mysqli_stmt_execute($check_stmt);
            mysqli_stmt_store_result($check_stmt);
            
            if (mysqli_stmt_num_rows($check_stmt) > 0) {
                $register_error = "Пользователь с таким логином уже существует";
            } else {
                // Хэшируем пароль
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                $insert_sql = "INSERT INTO users (Login, password, email, status) VALUES (?, ?, ?, 0)";
                $insert_stmt = mysqli_prepare($link, $insert_sql);
                
                if ($insert_stmt) {
                    mysqli_stmt_bind_param($insert_stmt, "sss", $login, $hashed_password, $email);
                    
                    if (mysqli_stmt_execute($insert_stmt)) {
                        // Получаем данные только что созданного пользователя
                        $user_data = [
                            'Login' => $login,
                            'status' => 0,
                            'id' => mysqli_insert_id($link)
                        ];
                        $_SESSION['user'] = $user_data;
                        
                        if (!empty($service)) {
                            header("Location: index.php#request-form");
                        } else {
                            header("Location: index.php");
                        }
                        exit();
                    } else {
                        $register_error = "Ошибка при регистрации. Попробуйте позже.";
                    }
                    mysqli_stmt_close($insert_stmt);
                } else {
                    $register_error = "Ошибка подготовки запроса";
                }
            }
            mysqli_stmt_close($check_stmt);
        } else {
            $register_error = "Ошибка подготовки запроса";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - АвтоТехЦентр "Bosh"</title>
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
                <a href="login.php" class="nav-link">Вход</a>
            </nav>
        </div>
    </header>
    
    <main class="content">
        <div class="content-container">
            <form method="POST" class="form-section reg-form">
                <h2 class="section-title">Регистрация</h2>
                
                <?php if ($service): ?>
                    <div class="info-msg" style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                        Зарегистрируйтесь, чтобы записаться на выбранную услугу
                    </div>
                <?php endif; ?>
                
                <?php if ($register_error): ?>
                    <div class="error-msg"><?= htmlspecialchars($register_error) ?></div>
                <?php endif; ?>
                
                <div class="input-group">
                    <div class="field">
                        <label class="field-label">Введите логин</label>
                        <input class="text-input reg-login" name="register_login" type="text" placeholder="Логин" required>
                    </div>
                    
                    <div class="field">
                        <label class="field-label">Введите почту</label>
                        <input class="text-input email-field" name="register_email" type="email" placeholder="Email" required>
                    </div>
                    
                    <div class="field">
                        <label class="field-label">Введите пароль</label>
                        <input class="text-input reg-pass" name="register_password" type="password" placeholder="Пароль (минимум 6 символов)" required minlength="6">
                    </div>
                    
                    <div class="privacy-checkbox">
                        <input type="checkbox" id="privacy-agreement" name="privacy_agreement" required>
                        <label for="privacy-agreement">Я согласен на обработку персональных данных</label>
                    </div>
                    
                    <?php if ($service): ?>
                        <input type="hidden" name="service" value="<?= htmlspecialchars($service) ?>">
                    <?php endif; ?>
                    
                    <button type="submit" name="register_submit" class="action-btn">Зарегистрироваться</button>
                </div>
                
                <p style="text-align: center; margin-top: 1rem;">
                    Уже есть аккаунт? <a href="login.php<?= $service ? '?service='.$service : '' ?>" style="color: var(--primary);">Войдите</a>
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