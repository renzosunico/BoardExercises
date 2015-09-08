<div class="row">
  <div class="col-xs-12 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">
    <h1 class="title">Create a Thread</h1>
  </div>
</div>

<?php if($thread->hasError() || $comment->hasError()): ?>
    <div class="row">
      <div class="col-xs-12 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">

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

            <?php if(!empty($thread->validation_errors['category']['content'])): ?>
                <div>
                    <em>Category</em> is required.
                </div>
            <?php endif ?>
        </div>

      </div>
    </div>
<?php endif ?>

<div class="row">
    <div class="col-xs-12 col-md-offset-2 col-md-8 col-lg-offset-2 col-lg-8">
        <div class="well">
            <form action="<?php echo url('') ?>" method="post" class="form-horizontal">
                <div class="form-group">
                    <label for="title" class="col-sm-1 control-label">Title: </label>
                    <div class="col-sm-offset-1 col-sm-4">
                        <input name="title" type="text" class="form-control" id="title" placeholder="Title">
                    </div>
                    <label for"category" class="col-sm-1 control-label">Category:</label>
                    <div class="col-sm-offset-1 col-sm-4">
                        <select class="form-control" id="category" name="category">
                            <option></option>
                            <option>Android</option>
                            <option>iOS</option>
                            <option>PHP</option>
                            <option>Unity</option>
                            <option>Graphics 2D&amp;3D</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="body" class="col-sm-1">Comment: </label>
                    <div class="col-sm-offset-1 col-sm-10">
                        <textarea name="body" id="body" class="form-control" placeholder="What bothers you?"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button class="btn btn-primary" type="submit">Create</button>
                        <input type="hidden" name="page_next" value="create_end">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>