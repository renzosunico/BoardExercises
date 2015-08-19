<h1 class="white"><?php eh($thread->title) ?></h1>

<div class="well">

<?php foreach($comments as $k => $v): ?>

<div class="comment">

<div class="meta">
	<?php eh($starting_index++) ?>: <?php eh($v->username) ?> <?php eh($v->created) ?>
</div>

<div><?php echo readable_text($v->body) ?></div>

</div>

<?php endforeach ?>

<!--Pagination Here -->
<?if ($pages > 1): ?>

	<?php if($pagination->current > 1): ?>
		<a href="?thread_id=<?php echo $thread->id ?>
		&page=<?php echo $pagination->prev ?>">Previous</a>
	<?php else: ?>
		Previous
	<?php endif ?>

	<?php for($i=1; $i<=$pages; $i++): ?>
		<?php if($i == $page): ?>
			<?php echo $i ?>
		<?php else: ?>
			<a href="?thread_id=<?php echo $thread->id ?>
				&page=<?php echo $i ?>"?><?php echo $i ?>
			</a>
		<?php endif ?>
	<?php endfor ?>

	<?php if(!$pagination->is_last_page): ?>
		<a href="?thread_id=<?php echo $thread->id ?>
			&page=<?php echo $pagination->next ?>">Next</a>
	<?php else: ?>
		Next
	<?php endif ?>

<?php endif ?>
</div>

<hr>

<form class="well" method="post" action="<?php eh(url('comment/write')) ?>">
	<label>Comment</label>
	<textarea class="span4" name="body"><?php eh(Param::get('body')) ?></textarea>
	<input type="hidden" name="thread_id" value="<?php eh($thread->id) ?>">
	<input type="hidden" name="page_next" value="write_end">
	<button type="submit" class="btn btn-primary">Comment</button>
</form>