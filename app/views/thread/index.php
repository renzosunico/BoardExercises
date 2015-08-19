<h1 class="white">All Threads</h1>

<ul>
	<?php foreach($threads as $v): ?>
	<div class="well well-small">
		<a href="<?php eh(url('comment/view', array('thread_id' => $v->id))) ?>">
		<?php eh($v->title) ?></a>
	</div>
	<?php endforeach ?>
</ul>

<?php if($pages > 1): ?>
	<?php if($pagination->current > 1): ?>
		<a href='?page=<?php echo $pagination->prev ?>'>Previous</a>
	<?php else: ?>
		Previous
	<?php endif ?>

	<?php for($i = 1; $i <= $pages; $i++): ?>
		<?php if($i == $page): ?>
			<?php echo $i ?>
		<?php else: ?>
			<a href='?page=<?php echo $i ?>'><?php echo $i ?></a>
		<?php endif; ?>
	<?php endfor; ?>

	<?php if(!$pagination->is_last_page): ?>
		<a href='?page=<?php echo $pagination->next ?>'>Next</a>
	<?php else: ?>
	Next
	<?php endif ?>
<?php endif ?>

<br/><br/>

<a class="btn btn-large btn-primary span3 middle" href="<?php eh(url('thread/create')) ?>">Create</a>