<h1 class="title">Contact-us</h1>

<form action="<?= route('contact') ?>" method="post">
    <div class="form-group">
        <input type="email" name="email" value="jeanyao@ymail.com" placeholder="Е-майл" class="form-control">
    </div>
    <div class="form-group">
        <input type="text" name="name" value="Куасси Жан-Клод" placeholder="Ф.И.О" class="form-control">
    </div>
    <div class="form-group">
        <textarea name="message" id="" cols="30" rows="10" class="form-control"></textarea>
    </div>
    <!--<input type="hidden" name="_method" value="PUT">-->
    <input type="hidden" name="_token" value="<?= md5(uniqid()) ?>">
    <button type="submit" class="btn btn-success">Отправить</button>
</form>
<div><?= $method ?></div>