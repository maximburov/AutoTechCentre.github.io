<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Услуги автосервиса Bosh в Касимове">
    <meta name="keywords" content="автосервис услуги, ремонт автомобилей, диагностика">
    <title>Услуги - АвтоТехЦентр "Bosh"</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        .services-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .services-page h1 {
            font-size: 36px;
            text-align: center;
            margin: 30px 0 40px 0;
            color: #333;
            font-weight: 600;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 50px;
        }
        
        .service-card {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 25px;
            display: flex;
            flex-direction: column;
            height: 100%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .service-card h2 {
            font-size: 22px;
            color: #333;
            margin: 0 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #FF6B6B;
            font-weight: 600;
        }
        
        .service-desc {
            color: #666;
            line-height: 1.5;
            margin-bottom: 15px;
            font-size: 14px;
            flex-grow: 0;
        }
        
        .service-price {
            font-size: 24px;
            font-weight: 700;
            color: #FF6B6B;
            margin-bottom: 15px;
        }
        
        .service-price small {
            font-size: 14px;
            font-weight: 400;
            color: #999;
        }
        
        .service-features {
            list-style: none;
            padding: 0;
            margin: 0 0 20px 0;
            flex-grow: 1;
        }
        
        .service-features li {
            padding: 6px 0;
            color: #555;
            font-size: 14px;
            border-bottom: 1px dashed #f0f0f0;
            display: flex;
            align-items: center;
        }
        
        .service-features li:before {
            content: "✓";
            color: #FF6B6B;
            font-weight: 600;
            margin-right: 10px;
            font-size: 14px;
        }
        
        .service-features li:last-child {
            border-bottom: none;
        }
        
        .card-btn {
            display: inline-block;
            background: #FF6B6B;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            text-align: center;
            border: 1px solid #FF6B6B;
            transition: all 0.2s;
            margin-top: auto;
        }
        
        .card-btn:hover {
            background: #fff;
            color: #FF6B6B;
        }
        
        .card-btn.secondary {
            background: #6c757d;
            border-color: #6c757d;
            margin-top: 10px;
        }
        
        .card-btn.secondary:hover {
            background: #fff;
            color: #6c757d;
        }
        
        .warning-msg {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            font-size: 13px;
            text-align: center;
        }
        
        .info-block {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 40px;
            margin: 40px 0;
            text-align: center;
        }
        
        .info-block h3 {
            font-size: 28px;
            margin: 0 0 15px 0;
            color: #333;
        }
        
        .info-block p {
            color: #666;
            margin-bottom: 25px;
            font-size: 16px;
        }
        
        .info-block .btn {
            display: inline-block;
            background: #FF6B6B;
            color: #fff;
            padding: 12px 35px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            border: 1px solid #FF6B6B;
        }
        
        .info-block .btn:hover {
            background: #fff;
            color: #FF6B6B;
        }
        
        @media (max-width: 992px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 576px) {
            .services-grid {
                grid-template-columns: 1fr;
            }
            
            .services-page h1 {
                font-size: 28px;
                margin: 20px 0 30px 0;
            }
            
            .info-block {
                padding: 30px 20px;
            }
            
            .info-block h3 {
                font-size: 24px;
            }
        }
        
        .service-card {
            min-height: 450px;
        }
        
        .card-buttons {
            margin-top: auto;
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
                    <span class="nav-link">Вы: <strong><?= htmlspecialchars($_SESSION['user']['Login']) ?></strong></span>
                    <a href="?logout=1" class="nav-link">Выйти</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    
    <main class="content">
        <div class="services-page">
            <h1>Наши услуги</h1>
            
            <div class="services-grid">
                <div class="service-card">
                    <h2>Компьютерная диагностика</h2>
                    <p class="service-desc">Полная диагностика всех систем автомобиля. Оборудование Bosh, расшифровка ошибок.</p>
                    <div class="service-price">от 1 500 ₽ <small>/ полная</small></div>
                    <ul class="service-features">
                        <li>Считывание ошибок</li>
                        <li>Проверка датчиков</li>
                        <li>Анализ работы двигателя</li>
                        <li>Рекомендации по ремонту</li>
                    </ul>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="index.php#request-form" class="card-btn">Записаться</a>
                    <?php else: ?>
                        <div class="warning-msg">Для записи нужно авторизоваться</div>
                        <a href="register.php?service=diagnostics" class="card-btn">Регистрация</a>
                    <?php endif; ?>
                </div>
                
                <div class="service-card">
                    <h2>Замена масла</h2>
                    <p class="service-desc">Быстрая замена масла в двигателе. Используем качественные масла.</p>
                    <div class="service-price">от 2 000 ₽ <small>+ масло</small></div>
                    <ul class="service-features">
                        <li>Замена масла</li>
                        <li>Замена масляного фильтра</li>
                        <li>Проверка жидкостей</li>
                        <li>Утилизация отработки</li>
                    </ul>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="index.php#request-form" class="card-btn">Записаться</a>
                    <?php else: ?>
                        <div class="warning-msg">Для записи нужно авторизоваться</div>
                        <a href="register.php?service=oil_change" class="card-btn">Регистрация</a>
                    <?php endif; ?>
                </div>
                
                <div class="service-card">
                    <h2>Антикоррозийная обработка</h2>
                    <p class="service-desc">Защита кузова от коррозии. Обработка скрытых полостей и днища.</p>
                    <div class="service-price">от 8 000 ₽ <small>/ комплект</small></div>
                    <ul class="service-features">
                        <li>Обработка скрытых полостей</li>
                        <li>Защита днища</li>
                        <li>Обработка арок</li>
                        <li>Гарантия 3 года</li>
                    </ul>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="index.php#request-form" class="card-btn">Записаться</a>
                    <?php else: ?>
                        <div class="warning-msg">Для записи нужно авторизоваться</div>
                        <a href="register.php?service=anticor" class="card-btn">Регистрация</a>
                    <?php endif; ?>
                </div>
                
                <div class="service-card">
                    <h2>Ремонт подвески</h2>
                    <p class="service-desc">Диагностика и ремонт ходовой части. Замена амортизаторов и сайлентблоков.</p>
                    <div class="service-price">от 3 000 ₽ <small>/ узел</small></div>
                    <ul class="service-features">
                        <li>Диагностика подвески</li>
                        <li>Замена амортизаторов</li>
                        <li>Замена сайлентблоков</li>
                        <li>Сход-развал</li>
                    </ul>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="index.php#request-form" class="card-btn">Записаться</a>
                    <?php else: ?>
                        <div class="warning-msg">Для записи нужно авторизоваться</div>
                        <a href="register.php?service=suspension" class="card-btn">Регистрация</a>
                    <?php endif; ?>
                </div>
                
                <div class="service-card">
                    <h2>Шиномонтаж</h2>
                    <p class="service-desc">Сезонная замена шин, балансировка, ремонт проколов.</p>
                    <div class="service-price">от 2 500 ₽ <small>/ комплект</small></div>
                    <ul class="service-features">
                        <li>Сезонная замена шин</li>
                        <li>Балансировка</li>
                        <li>Ремонт проколов</li>
                        <li>Хранение шин</li>
                    </ul>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="index.php#request-form" class="card-btn">Записаться</a>
                    <?php else: ?>
                        <div class="warning-msg">Для записи нужно авторизоваться</div>
                        <a href="register.php?service=tires" class="card-btn">Регистрация</a>
                    <?php endif; ?>
                </div>
                
                <div class="service-card">
                    <h2>Мойка и детейлинг</h2>
                    <p class="service-desc">Комплексная мойка, химчистка салона, полировка.</p>
                    <div class="service-price">от 1 000 ₽ <small>/ комплекс</small></div>
                    <ul class="service-features">
                        <li>Мойка кузова</li>
                        <li>Химчистка салона</li>
                        <li>Полировка</li>
                        <li>Защитные покрытия</li>
                    </ul>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="index.php#request-form" class="card-btn">Записаться</a>
                    <?php else: ?>
                        <div class="warning-msg">Для записи нужно авторизоваться</div>
                        <a href="register.php?service=washing" class="card-btn">Регистрация</a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="info-block">
                <h3>Нужна другая услуга?</h3>
                <p>Оставьте заявку с описанием проблемы, и мы подберем оптимальное решение</p>
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="index.php#request-form" class="btn">Оставить заявку</a>
                <?php else: ?>
                    <a href="register.php" class="btn">Зарегистрироваться</a>
                <?php endif; ?>
            </div>
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