<div>
    <h3><?= $news->getTitle() ?>  #<?= $news->getId() ?></h3>
    <div><?= $news->getContent() ?></div>
    <small><?= $news->getPublishedAt()->format('d-m-Y') ?>
</div>
<div style="margin: 10px 0;">
    <a href="<?= route('news.list')?>">Back to List</a>
</div>