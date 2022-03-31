<! DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if (!empty($title)): ?>
        <title><?= $title;?></title>
    <?php endif; ?>
    <meta name="robots" content="noindex, nofollow">
    <?php if (!empty($title)): ?>
        <meta name="description" content="<?= $title;?>">
    <?php endif; ?>

    <link rel="stylesheet" type="text/css" href="/css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="/css/main.css" />
    <link rel="stylesheet" type="text/css" href="/css/main_reg.css" />
    <script src="/js/main.js"></script>
    <script src="/js/reg.js"></script>
</head>
<body>
    <div class="content-wrapper">
        <header class="header">
            <h1>Шаблон Пользователь авторизован</h1>
            <div class="authorization">
                <a class="logout" href="">Выход</a>
                <p><?= $login;?></p>
            </div>
        </header>

        <div class="container clearfix">
            <?php include 'app/views/'.$contentView;?>
        </div>

        <footer class="footer">
            <p>&#169;2022</p>
        </footer>
    </div>

    <div id="popup"></div>
    <div id="invalid_feedback"></div>
</body>
</html>