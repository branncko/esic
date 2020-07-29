<div id="profile-new">
	<script>
		function CPF(){"user_strict";function r(r){for(var t=null,n=0;9>n;++n)t+=r.toString().charAt(n)*(10-n);var i=t%11;return i=2>i?0:11-i}function t(r){for(var t=null,n=0;10>n;++n)t+=r.toString().charAt(n)*(11-n);var i=t%11;return i=2>i?0:11-i}var n="CPF Inválido",i="CPF Válido";this.gera=function(){for(var n="",i=0;9>i;++i)n+=Math.floor(9*Math.random())+"";var o=r(n),a=n+"-"+o+t(n+""+o);return a},this.valida=function(o){for(var a=o.replace(/\D/g,""),u=a.substring(0,9),f=a.substring(9,11),v=0;10>v;v++)if(""+u+f==""+v+v+v+v+v+v+v+v+v+v+v)return n;var c=r(u),e=t(u+""+c);return f.toString()===c.toString()+e.toString()?i:n}}
		
		var CPF = new CPF();
		
		$(document).ready(function(){   
		$("#_cpf").keyup(function(){
		var teste = CPF.valida($(this).val());
		$("#resposta").html(teste);
		if(teste == "CPF Válido"){ 
		$("#update").removeAttr("disabled");
		}else {    
		$("#update").attr("disabled",true);
		}
		});
		
		$("#_cpf").blur(function(){
		var teste= CPF.valida($(this).val());
		$("#resposta").html(teste);
		if(teste == "CPF Válido"){ 
		$("#update").removeAttr("disabled");
		} else {
		$("#update").attr("disabled",true);
		} 
		});
		}); 
	</script>
<h1><?php echo __('Manage Your Profile Information'); ?></h1>
<p class="sub"><?php echo __('If necessary, use the fields below to update your Account information.'); ?></p>
<div id="msg_warning">
	<strong>Verificação de CPF: </strong><span id="resposta"></span>
</div>
<form action="profile.php" method="post">
	<?php csrf_token(); ?>
	<div class="padded">
		<?php
			foreach ($user->getForms() as $f) {
			$f->render(['staff' => false]);
			}
			if ($acct = $thisclient->getAccount()) {
			$info=$acct->getInfo();
			$info=Format::htmlchars(($errors && $_POST)?$_POST:$info);
			?>
		<div class="row">
			<div class="col">
				<div>
					<hr>
					<h3><?php echo __('Preferences'); ?></h3>
				</div>
			</div>
		</div>
		<?php if ($cfg->getSecondaryLanguages()) { ?>
		<div class="form-group">
			<label for="language">
			<span class=""><?php echo __('Preferred Language'); ?>:</span>
			<br>
				<?php
					$langs = Internationalization::getConfiguredSystemLanguages(); ?>
				<select name="lang">
					<option value="">&mdash; <?php echo __('Use Browser Preference'); ?> &mdash;</option>
					<?php foreach($langs as $l) {
						$selected = ($info['lang'] == $l['code']) ? 'selected="selected"' : ''; ?>
					<option value="<?php echo $l['code']; ?>" <?php echo $selected;
						?>><?php echo Internationalization::getLanguageDescription($l['code']); ?></option>
					<?php } ?>
				</select>
				<span class="error">&nbsp;<?php echo $errors['lang']; ?></span>
			</label>
		</div>
		<?php }
			if ($acct->isPasswdResetEnabled()) { ?>
		<div class="row">
			<div class="col">
				<div>
					<hr>
					<h3><?php echo __('Access Credentials'); ?></h3>
				</div>
			</div>
		</div>
		<?php if (!isset($_SESSION['_client']['reset-token'])) { ?>
		<div class="form-group">
			<label for="cpasswd">
			<span class=""><?php echo __('Current Password'); ?>:</span>
			<br>
				<input type="password" size="18" name="cpasswd" value="<?php echo $info['cpasswd']; ?>">
				&nbsp;<span class="error">&nbsp;<?php echo $errors['cpasswd']; ?></span>
			</label>
		</div>
		<?php } ?>
		<div class="form-group">
			<label for="passwd1">
			<span class=""><?php echo __('New Password'); ?>:</span>
			<br>
				<input type="password" size="18" name="passwd1" value="<?php echo $info['passwd1']; ?>">
				&nbsp;<span class="error">&nbsp;<?php echo $errors['passwd1']; ?></span>
			</label>
		</div>
		<div class="form-group">
			<label for="passwd2">
			<span class=""><?php echo __('Confirm New Password'); ?>:</span>
			<br>
				<input type="password" size="18" name="passwd2" value="<?php echo $info['passwd2']; ?>">
				&nbsp;<span class="error">&nbsp;<?php echo $errors['passwd2']; ?></span>
			</label>
		</div>
		<?php } ?>
		<?php } ?>
	</div>
	<hr>
	<p style="margin-top: 25px; text-align: center;">
		<input id="update" type="submit" value="<?php echo __('Update'); ?>"/>
		<input id="reset" type="reset" value="<?php echo __('Reset'); ?>"/>
		<input id="cancel" type="button" value="Cancel" onclick="javascript:
			window.location.href='index.php';"/>
	</p>
</form>
</div>
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