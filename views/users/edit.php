<h1>Edit</h1>

<?php if (isset($error)): ?>
  <div class="alert alert-danger">
      <?= $error?>
  </div>
<?php endif; ?>

<?php if (isset($user)): ?>
<form action="<?= route('user.edit', ['id' => $user->getId()]) ?>" method="post">
    <div class="form-group">
        <input type="email" name="email" value="<?= $user->getEmail() ?>" placeholder="Е-майл" class="form-control">
    </div>
    <div class="form-group">
        <input type="text" name="username" value="<?= $user->getUsername() ?>" placeholder="Пользователское имя" class="form-control">
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <input type="text" name="surname" value="<?= $user->getSurname() ?>" placeholder="Фамилия" class="form-control">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <input type="text" name="name" value="<?= $user->getName() ?>" placeholder="Имя" class="form-control">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <input type="text" name="patronymic" value="<?= $user->getPatronymic() ?>" placeholder="Отчество" class="form-control">
            </div>
        </div>
    </div>
    <div class="form-group">
        <input type="text" name="city" value="<?= $user->getCity() ?>" placeholder="Город" class="form-control">
    </div>
    <div class="form-group">
        <input type="text" name="region" value="<?= $user->getRegion() ?>" placeholder="Регион" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Обновить</button>
</form>
<?php endif; ?>