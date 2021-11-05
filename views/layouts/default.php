<!doctype html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">
    <?= asset('assets/css/app.css') ?>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= env('APP_NAME') ?></title>
</head>
<body>

<div class="container">
    <?php include (__DIR__.'/../partials/_nav.php'); ?>

    {{ content }}
</div>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>