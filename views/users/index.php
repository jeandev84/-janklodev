<div>
    <div>
        <h2 style="display:inline-block; float: left;">Users</h2>
        <a href="<?= route('reset.users')?>" class="btn btn-danger" style="margin: 20px 0;display: inline-block;float:right;font-size: 13px!important;" onclick="confirm('Are you sure to remove list ?')">Reset</a>
    </div>
    <table class="table table-striped">
       <thead>
           <tr>
               <th scope="col">#</th>
               <th scope="col">Электронная почта</th>
               <th scope="col">Ф.И.О</th>
               <th scope="col">Регион</th>
               <th scope="col">Город</th>
               <th scope="col">Действия</th>
           </tr>
       </thead>
        <tbody>
        <?php if (! empty($users)) : ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <th scope="row"><?= $user->getId() ?></th>
                    <td><?= $user->getEmail() ?></td>
                    <td><?= $user->getFullname() ?></td>
                    <td><?= $user->getRegion() ?></td>
                    <td><?= $user->getCity() ?></td>
                    <td>
                        <a class="btn btn-outline-warning" href="<?= route('user.edit', ['id' => $user->getId()])?>">
                            <i class="fa fa-fw fa-edit"></i>
                        </a>

                        <a class="btn btn-outline-danger" href="<?= route('user.remove', ['id' => $user->getId()])?>">
                            <i class="fa fa-fw fa-trash"></i>
                        </a>

                        <!--
                        <a class="btn btn-outline-success" href="#">
                            <i class="fa fa-fw fa-wrench"></i>
                        </a>

                        <a class="btn btn-outline-info" href="#">
                            <i class="fa fa-fw fa-stop"></i>
                        </a>
                        -->
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>