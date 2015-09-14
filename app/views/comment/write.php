<h2 class="thread-title"><?php encode_quotes($thread->title) ?></h2>

<?php if($comment->hasError()): ?>
<div class="alert alert-danger">

    <h4 class="alert-heading">
        <span class="glyphicon glyphicon-warning-sign"></span> Warning!
    </h4>

    <?php if(!empty($comment->validation_errors['body']['length'])): ?>
        <div><em>Comment</em> must be between
        <?php encode_quotes($comment->validation['body']['length'][1]) ?>
        and
        <?php encode_quotes($comment->validation['body']['length'][2]) ?>
        characters in length.
        </div>
    <?php endif ?>

</div>
<?php endif ?>

<form class="well" method="post" action="<?php encode_quotes(url('comment/write')) ?>">
    <div class="form-group">
        <label for="comment">Comment</label>
        <textarea id="comment" name="body" class="form-control"><?php encode_quotes(Param::get('body')) ?></textarea>
    </div>
    <input type="hidden" name="thread_id" value="<?php encode_quotes($thread->id) ?>">
    <input type="hidden" name="page_next" value="write_end">
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Comment</button>
    </div>
</form>
