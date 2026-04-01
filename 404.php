<?php
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница не найдена | АвтоТехЦентр "Bosh"</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .error-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
        }
        
        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            line-height: 1;
        }
        
        .error-title {
            font-size: 32px;
            color: #e74c3c;
            margin-bottom: 20px;
        }
        
        .error-message {
            font-size: 18px;
            color: #7f8c8d;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .home-button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .home-button:hover {
            background-color: #2980b9;
        }
        
        .error-image {
            max-width: 300px;
            margin: 30px auto;
        }
        
        .links-section {
            margin-top: 40px;
            text-align: left;
        }
        
        .links-section h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }
        
        .links-section ul {
            list-style-type: none;
            padding: 0;
        }
        
        .links-section li {
            margin-bottom: 10px;
        }
        
        .links-section a {
            color: #3498db;
            text-decoration: none;
        }
        
        .links-section a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header class="top-header">
        <div class="top-container">
            <div class="logo-box">
                <img src="./img/XXL_height-Photoroom.png" alt="Логотип АвтоТехЦентр Bosh" width="192" height="90">
                <div class="box-text">АвтоТехЦентр "Bosh"</div>
            </div>
            <nav class="main-nav">
                <a href="#login" class="nav-link">Вход</a>
                <a href="#register" class="nav-link">Регистрация</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="error-container">
            <div class="error-code">404</div>
            <div class="error-title">Страница не найдена</div>
            <div class="error-message">
                <p>К сожалению, запрашиваемая вами страница не существует или была перемещена.</p>
                <p>Пожалуйста, проверьте правильность URL-адреса или воспользуйтесь навигацией по сайту.</p>
            </div>

            <div class="error-image">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#e74c3c" width="120px" height="120px">
                    <path d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
            </div>
            <a href="index.php" class="home-button">Вернуться на главную</a>
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