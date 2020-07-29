<?php
if(!defined('OSTCLIENTINC')) die('Access Denied');

$email=Format::input($_POST['luser']?:$_GET['e']);
$passwd=Format::input($_POST['lpasswd']?:$_GET['t']);

$content = Page::lookupByType('banner-client');

if ($content) {
    list($title, $body) = $ost->replaceTemplateVariables(
        array($content->getLocalName(), $content->getLocalBody()));
} else {
    $title = __('Sign In');
    $body = __('To better serve you, we encourage our clients to register for an account and verify the email address we have on record.');
}

?>
<div id="login-new">
	<h1><?php echo Format::display($title); ?></h1>
	<p class="sub"><?php echo Format::display($body); ?></p>
	<form action="login.php" method="post" id="clientLogin">
		<?php csrf_token(); ?>
	<div style="display:table-row">
		<div class="login-box">
		<strong><?php echo Format::htmlchars($errors['login']); ?></strong>
		<div class="form-group">
			<label for="username">
			<span class=""><?php echo __('Email or Username'); ?></span>
			<br>
			<input id="username" placeholder="" type="text" name="luser" size="30" value="<?php echo $email; ?>" class="nowarn">
		</div>
		<div class="form-group">
			<label for="passwd">
			<span class=""><?php echo __('Password'); ?></span>
			<br>
			<input id="passwd" placeholder="" type="password" name="lpasswd" size="30" value="<?php echo $passwd; ?>" class="nowarn"></td>
		</div>
		<p class="box-button">
			<input class="btn" type="submit" value="<?php echo __('Sign In'); ?>">
	<?php if ($suggest_pwreset) { ?>
			<a style="padding-top:4px;display:inline-block;" href="pwreset.php"><?php echo __('Forgot My Password'); ?></a>
	<?php } ?>
		</p>
		</div>
	</div>
	</form>
	<p>
		<input class="btn" type="submit" onclick="window.location.href = 'account.php?do=create'" value="<?php echo __('Create an account'); ?>">
	</p>
	<p class="infolink">
	<?php
	if ($cfg->getClientRegistrationMode() != 'disabled'
		|| !$cfg->isClientLoginRequired()) {
		echo __('Please note that you need to access your email and click on the activation link after you register.');
	} ?>
	</p>
</div>