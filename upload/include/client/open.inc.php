<?php
	if(!defined('OSTCLIENTINC')) die('Access Denied!');
	$info=array();
	if($thisclient && $thisclient->isValid()) {
	$info=array('name'=>$thisclient->getName(),
	'email'=>$thisclient->getEmail(),
	'phone'=>$thisclient->getPhoneNumber());
	}
	
	$info=($_POST && $errors)?Format::htmlchars($_POST):$info;
	
	$form = null;
	if (!$info['topicId']) {
	if (array_key_exists('topicId',$_GET) && preg_match('/^\d+$/',$_GET['topicId']) && Topic::lookup($_GET['topicId']))
	$info['topicId'] = intval($_GET['topicId']);
	else
	$info['topicId'] = $cfg->getDefaultTopicId();
	}
	
	$forms = array();
	if ($info['topicId'] && ($topic=Topic::lookup($info['topicId']))) {
	foreach ($topic->getForms() as $F) {
	if (!$F->hasAnyVisibleFields())
	continue;
	if ($_POST) {
	$F = $F->instanciate();
	$F->isValidForClient();
	}
	$forms[] = $F->getForm();
	}
	}
	
	?>
<div id="open-new">
	<h1><?php echo __('Open a New Request');?></h1>
	<p><?php echo __('Please fill in the form below to open a new Request.');?></p>
	<form id="ticketForm" method="post" action="open.php" enctype="multipart/form-data">
		<?php csrf_token(); ?>
		<input type="hidden" name="a" value="open">
		<div>
			<?php
				if (!$thisclient) {
				$uform = UserForm::getUserForm()->getForm($_POST);
				if ($_POST) $uform->isValid();
				$uform->render(array('staff' => false, 'mode' => 'create'));
				}
				else { ?>
			<div class="row">
				<div class="col">
					<hr />
				</div>
			</div>
			<div class="row">
				<div class="col" style="font-weight: 700">
				<span class="_label"><?php echo __('CPF'); ?>:</span>
				<span><?php echo Format::htmlchars($thisclient->getCPF()); ?></span>
				</div>
			</div>
			<div class="row">
				<div class="col" style="font-weight: 700; margin-bottom: 10px">
				<span class="_label"><?php echo __('Requester'); ?>:</span>
				<span style="text-transform: uppercase"><?php echo Format::htmlchars($thisclient->getName()); ?></span>
				</div>
			</div>
			<div class="row">
				<div class="col">
				<span class="_label"><?php echo __('Email'); ?>:</span>
				<span><?php echo $thisclient->getEmail(); ?></span>
				</div>
			</div>
			<?php } ?>
			<div class="row">
				<div class="col">
					<hr />
					<div class="form-header" style="margin-bottom:0.5em">
						<span class="required"><?php echo __('Request Type'); ?>
							<span class="error">*</span>
						</span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<select id="topicId" name="topicId" onchange="javascript:
						var data = $(':input[name]', '#dynamic-form').serialize();
						$.ajax(
						'ajax.php/form/help-topic/' + this.value,
						{
						data: data,
						dataType: 'json',
						success: function(json) {
						$('#dynamic-form').empty().append(json.html);
						$(document.head).append(json.media);
						}
						});">
						<option value="" selected="selected">&mdash; <?php echo __('Select a Request Type');?> &mdash;</option>
						<?php
							if($topics=Topic::getPublicHelpTopics()) {
							foreach($topics as $id =>$name) {
							echo sprintf('<option value="%d" %s>%s</option>',
							$id, ($info['topicId']==$id)?'selected="selected"':'', $name);
							}
							} else { ?>
						<option value="0" ><?php echo __('General Inquiry');?></option>
						<?php
							} ?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="error"><?php echo $errors['topicId']; ?></div>
				</div>
			</div>
			<table>
				<tbody id="dynamic-form">
					<?php
					$options = array('mode' => 'create');
					foreach ($forms as $form) {
						include(CLIENTINC_DIR . 'templates/dynamic-form.tmpl.php');
					} ?>
				</tbody>
			</table>
			<?php
				if($cfg && $cfg->isCaptchaEnabled() && (!$thisclient || !$thisclient->isValid())) {
				if($_POST && $errors && !$errors['captcha'])
				$errors['captcha']=__('Please re-enter the text again');
				?>
			<div class="row">
				<div class="col">teste<?php echo __('CAPTCHA Text');?>:</div>
				<div class="col">
					<span class="captcha"><img src="captcha.php" align="left"></span>
					&nbsp;&nbsp;
					<input id="captcha" type="text" name="captcha" size="6" autocomplete="off">
					<em><?php echo __('Enter the text shown on the image.');?></em>
					<font class="error">*&nbsp;<?php echo $errors['captcha']; ?></font>
				</div>
			</div>
			<?php
				} ?>
		</div>
		<hr/>
		<p class="buttons" style="text-align:center;">
			<input type="submit" value="<?php echo __('Create Request');?>">
			<input type="reset" name="reset" value="<?php echo __('Reset');?>">
			<input type="button" name="cancel" value="<?php echo __('Cancel'); ?>" onclick="javascript:
				$('.richtext').each(function() {
				var redactor = $(this).data('redactor');
				if (redactor && redactor.opts.draftDelete)
				redactor.draft.deleteDraft();
				});
				window.location.href='index.php';">
		</p>
	</form>
</div>