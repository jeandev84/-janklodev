<h3>Create New</h3>
<form action="<?= route('news.create') ?>" method="post">
    <div class="form-group">
        <input type="text" name="title" placeholder="Title" class="form-control" required="required">
    </div>
    <div class="form-group">
        <textarea name="content" id="" cols="30" rows="10" class="form-control" required="required"></textarea>
    </div>
    <div class="form-group">
        <input type="date" name="publishedAt" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Save</button>
</form>