<! DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ошибка</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="Ошибка">
    <link rel="stylesheet" type="text/css" href="/css/normalize.css.css" />
    <link rel="stylesheet" type="text/css" href="/css/error.css" />
</head>
<body>
    <div class="wrapper">
        <div class="block">
            <h1><?= $data['text'];?></h1>
            <br>
            <h3><?= $data['message'];?></h3>
        </div>
    </div>
</body>
</html>