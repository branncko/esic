<?php
	$info = $_POST;
	if (!isset($info['timezone']))
	$info += array(
	'backend' => null,
	);
	if (isset($user) && $user instanceof ClientCreateRequest) {
	$bk = $user->getBackend();
	$info = array_merge($info, array(
	'backend' => $bk::$id,
	'username' => $user->getUsername(),
	));
	}
	$info = Format::htmlchars(($errors && $_POST)?$_POST:$info);
	?>
<div id="register-new">
	<script>
		function CPF(){"user_strict";function r(r){for(var t=null,n=0;9>n;++n)t+=r.toString().charAt(n)*(10-n);var i=t%11;return i=2>i?0:11-i}function t(r){for(var t=null,n=0;10>n;++n)t+=r.toString().charAt(n)*(11-n);var i=t%11;return i=2>i?0:11-i}var n="CPF Inválido",i="CPF Válido";this.gera=function(){for(var n="",i=0;9>i;++i)n+=Math.floor(9*Math.random())+"";var o=r(n),a=n+"-"+o+t(n+""+o);return a},this.valida=function(o){for(var a=o.replace(/\D/g,""),u=a.substring(0,9),f=a.substring(9,11),v=0;10>v;v++)if(""+u+f==""+v+v+v+v+v+v+v+v+v+v+v)return n;var c=r(u),e=t(u+""+c);return f.toString()===c.toString()+e.toString()?i:n}}
		
		var CPF = new CPF();
		
		$(document).ready(function(){   
		$("#_cpf").keyup(function(){
		var teste = CPF.valida($(this).val());
		$("#resposta").html(teste);
		if(teste == "CPF Válido"){ 
		$("#register").removeAttr("disabled");
		}else {    
		$("#register").attr("disabled",true);
		}
		});
		
		$("#_cpf").blur(function(){
		var teste= CPF.valida($(this).val());
		$("#resposta").html(teste);
		if(teste == "CPF Válido"){ 
		$("#register").removeAttr("disabled");
		} else {
		$("#register").attr("disabled",true);
		} 
		});
		}); 
		
		$(document).ready(function(){ $('input[id="_cargo"], select').val('') }); 
		$(document).ready(function(){ $('input[type="password"], select').val('') }); 
	</script>
	<h1><?php echo __('Account Registration'); ?></h1>
	<p class="sub"><?php echo __('Use the forms below to create or update the information we have on file for your account'); ?></p>
	<div id="msg_warning">
		<strong>Verificação de CPF: </strong><span id="resposta"></span>
	</div>
	<form id="clientRegister" action="account.php" method="post">
		<?php csrf_token(); ?>
		<input type="hidden" name="do" value="<?php echo Format::htmlchars($_REQUEST['do']
			?: ($info['backend'] ? 'import' :'create')); ?>" />
		<div class="padded">
			<?php
				$cf = $user_form ?: UserForm::getInstance();
				$cf->render(array('staff' => false, 'mode' => 'create'));
				?>
			<div class="row">
				<div class="col">
					<div>
						<hr>
						<h3><?php echo __('Access Credentials'); ?></h3>
					</div>
				</div>
			</div>
			<?php if ($info['backend']) { ?>
			<div class="row">
				<div class="col">
					<?php echo __('Login With'); ?>:
				</div>
				<div class="col">
					<input type="hidden" name="backend" value="<?php echo $info['backend']; ?>"/>
					<input type="hidden" name="username" value="<?php echo $info['username']; ?>"/>
					<?php foreach (UserAuthenticationBackend::allRegistered() as $bk) {
						if ($bk::$id == $info['backend']) {
						echo $bk->getName();
						break;
						}
						} ?>
				</div>
			</div>
			<?php } else { ?>
			<div class="form-group">
				<label for="passwd1">
				<span class=""><?php echo __('Create a Password'); ?></span>
				<br>
				<input type="password" size="18" name="passwd1" value="<?php echo $info['passwd1']; ?>">
				&nbsp;<span class="error">&nbsp;<?php echo $errors['passwd1']; ?></span>
				</label>
			</div>
			<div class="form-group">
				<label for="passwd2">
				<span class=""><?php echo __('Confirm New Password'); ?></span>
				<br>
				<input type="password" size="18" name="passwd2" value="<?php echo $info['passwd2']; ?>">
				&nbsp;<span class="error">&nbsp;<?php echo $errors['passwd2']; ?></span>
				</label>
			</div>
			<?php } ?>
		</div>
		<hr>
		<p style="margin-top: 25px; text-align: center;">
			<input id="register" type="submit" value="<?php echo __('Register'); ?>"/>
			<input id="cancel" type="button" value="<?php echo __('Cancel'); ?>" onclick="javascript: window.location.href='index.php';"/>
		</p>
	</form>
</div>
<?php if (!isset($info['timezone'])) { ?>
<!-- Auto detect client's timezone where possible -->
<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jstz.min.js?a076918"></script>
<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery.maskedinput-1.1.4.pack.js"/></script>
<script type="text/javascript">
	$(function() {
	var zone = jstz.determine();
	$('#timezone-dropdown').val(zone.name()).trigger('change');
	});
	
	$(document).ready(function(){
	$("#_cpf").mask("999.999.999-99");
	$("#_phone1").mask("(99) 99999-9999");
	$("#_phone2").mask("(99) 9999-9999");
	$("#_cnpj").mask("99.999.999/9999-99");
	});
</script>
<?php }