<h1 class="title">Sign-up</h1>

<form action="<?= route('user.register') ?>" method="post">
    <div class="form-group">
        <input type="email" name="email" value="jeanyao@ymail.com" placeholder="Е-майл" class="form-control">
    </div>
    <div class="form-group">
        <input type="password" name="password" value="123" placeholder="Пароль" class="form-control">
    </div>
    <div class="form-group">
        <input type="text" name="username" value="jeanyao" placeholder="Пользователское имя" class="form-control">
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <input type="text" name="surname" value="Яо" placeholder="Фамилия" class="form-control">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <input type="text" name="name" value="Куасси Жан-Клод" placeholder="Имя" class="form-control">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <input type="text" name="patronymic" value="" placeholder="Отчество" class="form-control">
            </div>
        </div>
    </div>
    <div class="form-group">
        <input type="text" name="city" value="Москва" placeholder="Город" class="form-control">
    </div>
    <div class="form-group">
        <input type="text" name="region" value="Курганская область" placeholder="Регион" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Создать</button>
</form>