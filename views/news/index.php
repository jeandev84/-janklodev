<h2 class="title">Новости</h2>

<div style="margin-top: 20px;">
  <a href="<?= route('news.create')?>" class="btn btn-success">Create</a>
  <div class="row" style="margin-top: 10px;">
    <?php foreach ($news as $new): ?>
        <div id="post-<?= $new->getId() ?>" class="posts col-md-4" style="margin-bottom: 30px;">
            <h3>
                <a href="<?= route('news.show', ['id' => $new->getId()])?>">
                    <?= $new->getTitle() ?>
                </a>
            </h3>
            <p><?=  $new->getContent() ?></p>
            <small>published at : <?= $new->getPublishedAt()->format('d-m-Y') ?></small>
        </div>
    <?php endforeach; ?>
  </div>
</div>
