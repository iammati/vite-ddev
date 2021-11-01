<?php

use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vite DDEV proof-of-concept</title>
    <?php echo ViteService::render('head') ?>
</head>
<body>
    <h1>
        Some content
    </h1>

    <?php echo ViteService::render('body') ?>
</body>
</html>
