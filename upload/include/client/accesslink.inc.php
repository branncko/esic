<?php
if(!defined('OSTCLIENTINC')) die('Access Denied');

$email=Format::input($_POST['lemail']?$_POST['lemail']:$_GET['e']);
$ticketid=Format::input($_POST['lticket']?$_POST['lticket']:$_GET['t']);

if ($cfg->isClientEmailVerificationRequired())
    $button = __("Email Access Link");
else
    $button = __("View Ticket");
?>
<div id="ticket-status-new">
<h1><?php echo __('Check Request Status'); ?></h1>
<p class="sub"><?php
echo __('Please provide your email address and a Request number.');
if ($cfg->isClientEmailVerificationRequired())
    echo ' '.__('An access link will be emailed to you.');
else
    echo ' '.__('This will sign you in to view your request.');
?></p>
<form action="login.php" method="post" id="clientLogin">
    <?php csrf_token(); ?>
<div style="display:table-row">
    <div class="login-box">
    <div><strong><?php echo Format::htmlchars($errors['login']); ?></strong></div>
    <div class="form-group">
		<label for="email">
		<span class=""><?php echo __('Email Address'); ?></span>
		<br>
        <input id="email" placeholder="<?php echo __('e.g. user@email.com'); ?>" type="text"
            name="lemail" size="30" value="<?php echo $email; ?>" class="nowarn"></label>
    </div>
    <div class="form-group">
        <label for="ticketno">
		<span class=""><?php echo __('Request Number'); ?></span>
		<br>
        <input id="ticketno" type="text" name="lticket" placeholder="<?php echo __('e.g. 051243'); ?>"
            size="30" value="<?php echo $ticketid; ?>" class="nowarn"></label>
    </div>
    <p style="margin-top: 0">
        <input class="btn" type="submit" value="<?php echo $button; ?>">
    </p>
    </div>
</div>
</form>
<p class="infolink">
<?php
if ($cfg->getClientRegistrationMode() != 'disabled'
    || !$cfg->isClientLoginRequired()) {
    echo sprintf(
    __("If this is your first time contacting us or you've lost the Request number, please %s open a new Request. %s"),
        '<a href="open.php">','</a>');
} ?>
</p>
</div>