<?php
	if(!defined('OSTCLIENTINC') || !$thisclient || !$ticket || !$ticket->checkUserAccess($thisclient)) die('Access Denied!');
	
	?>
<div id="edit-new">
	<h1>
		<?php echo sprintf(__('Editing Request #%s'), $ticket->getNumber()); ?>
	</h1>
	<form action="tickets.php" method="post">
		<?php echo csrf_token(); ?>
		<input type="hidden" name="a" value="edit"/>
		<input type="hidden" name="id" value="<?php echo Format::htmlchars($_REQUEST['id']); ?>"/>
		<div>
			<table width="800">
				<tbody id="dynamic-form">
				<?php if ($forms)
					foreach ($forms as $form) {
						$form->render(['staff' => false]);
				} ?>
				</tbody>
			</table>
		</div>
		<hr>
		<p style="text-align: center;">
			<input type="submit" value="<?php echo __('Update');?>"/>
			<input type="reset" value="<?php echo __('Reset');?>"/>
			<input type="button" value="<?php echo __('Cancel');?>" onclick="javascript:
				window.location.href='index.php';"/>
		</p>
	</form>
</div>
