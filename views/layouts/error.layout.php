<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php require LAYOUTS_PATH . 'requires/requires.head.php' ?>

    <title><?= $code ?> - <?= $message ?></title>
</head>
<body>

<main class="error-container">
    <section class="error-block">
        <p class="error-icon"><i class="fa-solid fa-triangle-exclamation"></i></p>
        <h1 class="error-title"><?= $code ?></h1>
        <p class="error-text">[ <?= $message ?> ]</p>
        <a href="/" class="error-back-link"><i class="fa-solid fa-left"></i> вернуться на главную</a>
    </section>
</main>

<?php require LAYOUTS_PATH . 'requires/requires.bottom.php' ?>
</body>
</html>