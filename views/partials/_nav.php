<nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-bottom: 20px;">
    <a class="navbar-brand" href="<?= route('home')?>"><?= env('APP_NAME')?></a>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a href="<?= route('home') ?>" class="nav-link">Главная</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= route('users.list') ?>">Пользователи (загрузки)</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= route('contact') ?>">Как нас найти ?</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= route('news.list') ?>">Новости</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= route('user.register') ?>">Регистрация</a>
            </li>
        </ul>
    </div>
</nav>
