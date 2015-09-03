<h1 class="white">Create a Thread</h1>

<?php if($thread->hasError() || $comment->hasError()): ?>
    <div class="alert alert-danger">
        <h4 class="alert-heading">Validation Error!</h4>
        <?php if (!empty($thread->validation_errors['title']['length'])): ?>
            <div><em>Title</em> must be between
                <?php encode_quotes($thread->validation['title']['length'][1]) ?> and
                <?php encode_quotes($thread->validation['title']['length'][2]) ?> characters in length.
            </div>
        <?php endif ?>

        <?php if(!empty($comment->validation_errors['body']['length'])): ?>
            <div><em>Comment</em> must be between
                <?php encode_quotes($comment->validation['body']['length'][1]) ?> and
                <?php encode_quotes($comment->validation['body']['length'][2]) ?> characters in length.
            </div>
        <?php endif ?>
    </div>
<?php endif ?>

<form class="well" method=post action="<?php encode_quotes(url('')) ?>">
  <div class="form-group">
    <label for="title">Title:</label>
    <input type="text" class="form-control" id="title" name="title" value="<?php encode_quotes(Param::get('title')) ?>">
  </div>
  <div class="form-group">
    <label for="body">Comment:</label>
    <textarea name="body" id="body" class="form-control"><?php encode_quotes(Param::get('body')) ?></textarea>
  </div>
  <div class="form-group">
        <button type="submit" class="btn btn-primary">Create</button>
  </div>
  <input type="hidden" name="page_next" value="create_end">

</form>