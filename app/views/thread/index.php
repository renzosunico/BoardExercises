<div class="row">
    <div class="col-xs-12 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-7">
        <div class="well well-small">
            <a class="btn btn-primary" href="<?php echo url('thread/create') ?>"><span class="glyphicon glyphicon-pencil"></span>
        Create Thread</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-7">
        <?php if(empty($threads)): ?>
            <div class="panel panel-primary">
                <div class="panel-body">
                    No available threads. ☹☹☹
                </div>
            </div>
        <?php endif ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-7">
        <?php foreach($threads as $v): ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <p class="smallsize"> <?php echo "{$v->user_id}"?></p>
                    <p class="smallersize"><?php echo readable_text(date("l, F d, Y h:i a", strtotime($v->created))); ?></p>
                </div>
                <div class="panel-body" onclick="location.href='<?php encode_quotes(url('comment/view', array('thread_id' => $v->id))) ?>'" style="cursor:pointer;">
                    <p><?php encode_quotes($v->title) ?> </p>
                </div>
                <div id="footer" class="panel-footer">
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal"><span class="glyphicon glyphicon-font"></span> Edit</button>
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Edit Thread</h4>
                          </div>
                          <div class="modal-body">
                            <form action="<?php echo url('') ?>" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label for="title" class="col-sm-1 control-label">Title: </label>
                                    <div class="col-sm-offset-1 col-sm-4">
                                        <input name="title" type="text" class="form-control" id="title" value="<?php encode_quotes($v->title) ?>">
                                    </div>
                                    <label for"category" class="col-sm-1 control-label">Category:</label>
                                    <div class="col-sm-offset-1 col-sm-4">
                                        <select class="form-control" id="category" name="category">
                                            print_r($v->category_name);
                                            <option></option>
                                            <option <?php echo ($v->category_name == 'Android') ? 'selected' : '' ?>>Android</option>
                                            <option <?php echo ($v->category_name == 'iOS') ? 'selected' : '' ?>>iOS</option>
                                            <option <?php echo ($v->category_name == 'PHP') ? 'selected' : '' ?>>PHP</option>
                                            <option <?php echo ($v->category_name == 'Unity') ? 'selected' : '' ?>>Unity</option>
                                            <option <?php echo ($v->category_name == 'Graphics 2D&3D') ? 'selected' : '' ?>>Graphics 2D&amp;3D</option>
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
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?php if($pages > 1): ?>
    <div class="row">
        <div class="col-xs-12 col-md-offset-0 col-md-6 col-lg-offset-0 col-lg-7">
            <div class="well">
                    <ul class="pagination pagination-centerted">
                            <?php if($pagination->current > 1): ?>
                                <li><a href='?page=<?php echo $pagination->prev ?>'>Previous</a></li>
                            <?php else: ?>
                                <li class="disabled"><a href="#" >Previous</a></li>
                            <?php endif ?>

                            <?php for($i = 1; $i <= $pages; $i++): ?>
                                <?php if($i == $page): ?>
                                    <li class="active"><a href="#" ><?php echo $i ?></a></li>
                                <?php else: ?>
                                    <li><a href='?page=<?php echo $i ?>'><?php echo $i ?></a></li>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if(!$pagination->is_last_page): ?>
                                <li><a href='?page=<?php echo $pagination->next ?>'>Next</a></li>
                            <?php else: ?>
                                <li class="disabled"><a href="#" >Next</a></li>
                            <?php endif ?>
                    </ul>
            </div>
        </div>
    </div>
<?php endif ?>