<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php require LAYOUTS_PATH . 'requires/requires.head.php' ?>

    <title><?= TITLE ?> <?= isset($title) && !empty($title) ? "- $title" : '' ?></title>
</head>
<body>
<?php require VIEW_PATH . "elements/header.php" ?>

<?= $content ?>

<?php require VIEW_PATH . "elements/footer.php" ?>
<?php require LAYOUTS_PATH . 'requires/requires.bottom.php' ?>
</body>
</html>