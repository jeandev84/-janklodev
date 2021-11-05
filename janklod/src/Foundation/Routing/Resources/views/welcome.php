<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base href="/">
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="/assets/fonts/font-awesome.min.css"> -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= env('APP_NAME') ?></title>
</head>
<body>

<?php include('partials/nav.php'); ?>
<div class="container text-center mt-5">
    <h1 style="margin: 25% auto 0;">
        Welcome to <a href="https://github.com/jeandev84/jankloddev" style="text-decoration: none;" target="_blank">
            <?= env('APP_NAME') ?>
        </a>
    </h1>
    <small>You are ready for bulding a web application ...</small>
</div>

<footer>
    <div class="container">

    </div>
</footer>
<!-- scripts -->
<script src="assets/js/bootstrap.min.js" type="application/javascript"></script>
</body>
</html>