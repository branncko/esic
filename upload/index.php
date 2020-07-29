<?php
	/*********************************************************************
	index.php
	
	Helpdesk landing page. Please customize it to fit your needs.
	
	Peter Rotich <peter@osticket.com>
	Copyright (c)  2006-2013 osTicket
	http://www.osticket.com
	
	Released under the GNU General Public License WITHOUT ANY WARRANTY.
	See LICENSE.TXT for details.
	
	vim: expandtab sw=4 ts=4 sts=4:
	**********************************************************************/
	
	require ('conecta.inc.php');
	
	require('client.inc.php');
	
	require_once INCLUDE_DIR . 'class.page.php';
	
	$section = 'home';
	require(CLIENTINC_DIR.'header.inc.php');
	?>
<div id="index-new">
	<div id="landing_page">
		<?php
			if ($cfg && $cfg->isKnowledgebaseEnabled()) { ?>
		<div class="search-form">
			<form method="get" action="kb/faq.php">
				<input type="hidden" name="a" value="search"/>
				<input type="text" name="q" class="search" placeholder="<?php echo __('Search our knowledge base'); ?>"/>
				<button type="submit" class="green button"><?php echo __('Search'); ?></button>
			</form>
		</div>
		<div>
			<?php
				if ($cfg->getClientRegistrationMode() != 'disabled'
				|| !$cfg->isClientLoginRequired()) { ?>
			<a href="open.php" style="display:block" class="blue button"><?php
				echo __('Open a New Request');?></a>
			</p>
			<?php } ?>
		</div>
		<div class="thread-body">
			<?php
				}
				if($cfg && ($page = $cfg->getLandingPage()))
				echo $page->getBodyWithImages();
				else
				echo  '<h1>'.__('Welcome to the E-SIC').'</h1>';
				?>
		</div>
		<div style="display:flex">
			<div class="citizen-services form-group">
				<h3><?php echo __('Citizen Service'); ?></h3>
				<div id="presential">
					<div class="p bottom"><strong><?php echo __('FACE-TO-FACE SERVICE'); ?></strong></br>Controladoria e Ouvidoria Geral - Palácio Municipal</br>Praça dos 03 Poderes, SN - Aningas - Cruz/CE</div>
					<div class="p"><strong><?php echo __('OMBUDSMAN'); ?></strong></br>Alesson Arantes Silveira</div>
				</div>
				<div id="contacts">
					<div class="p phone bottom"><strong><?php echo __('TELEPHONE'); ?></strong></br>88 3660.1277 - (<?php echo __('Ext'); ?> 206)</div>
					<div class="p mail bottom"><strong><?php echo __('E-MAIL'); ?></strong></br>ouvidoria@cruz.ce.gov.br</div>
					<div class="p time"><strong><?php echo __('OPENING HOURS'); ?></strong></br><?php echo __('Monday to Friday - 08:00 to 12:00 - 13:30 to 17:30'); ?></div>
				</div>
				<h3><?php echo __('Manuals'); ?></h3>
				<div id="manuals">
					<div class="how-to-register">
						<a href="/esic/upload/pages/como-efetuar-seu-cadastro">1. <?php echo __('How to Register?'); ?></a>
					</div>
					<div class="how-to-open">
						<a href="/esic/upload/pages/como-abrir-uma-solicitacao">2. <?php echo __('How to open a Request?'); ?></a>
					</div>
					<div class="how-to-track">
						<a href="/esic/upload/pages/como-acompanhar-sua-solicitacao">3. <?php echo __('How to track your Request?'); ?></a>
					</div>
				</div>
			</div>
			<div class="statistics form-group">
				<h3><?php echo __('System Statistics'); ?></h3>
				<div id="request-graph">
					<div class="requestGraph">
						<h4><?php echo __('By Requests'); ?></h4>
						<canvas id="requestGraphCanvas"></canvas>
					</div>
				</div>
				<div id="numbers">
					<div id="received">
						<div class="title"><?php echo __('Received Requests'); ?></div>
						<div class="results">
							<?php
							if ($result = $mysqli->query("SELECT ticket_id FROM ost_ticket ORDER BY ticket_id")) {
							
							/* determine number of rows result set */
							$row_cnt = $result->num_rows;
							printf("%d \n", $row_cnt);
							
							/* close result set */
							$result->close();
							}
							?>
						</div>
					</div>			
					<div id="solved">
						<div class="title"><?php echo __('Requests Answered'); ?></div>
						<div class="results">
							<?php
								if ($result = $mysqli->query("SELECT closed FROM ost_ticket WHERE closed IS NOT NULL ORDER BY ticket_id")) {
								
								/* determine number of rows result set */
								$row_cnt = $result->num_rows;
								printf("%d \n", $row_cnt);
								
								/* close result set */
								$result->close();
								}
								?>
						</div>
					</div>
					<div id="usersq">
						<div class="title"><?php echo __('Registered Users'); ?></div>
						<div class="results">
							<?php
								if ($result = $mysqli->query("SELECT id FROM ost_user ORDER BY id")) {
								
								/* determine number of rows result set */
								$row_cnt = $result->num_rows;
								printf("%d \n", $row_cnt);
								
								/* close result set */
								$result->close();
								}
								?>
						</div>
					</div>
				</div>
				<div id="warning-text"><?php echo __('Para visualizar os dados deste e de outros Gráfico, contidos no E-SIC da Prefeitura de Cruz/CE, deslize o mouse sobre as fatias!'); ?></div>
			</div>			
		</div>
		<div class="graphs">
			<h3><?php echo __('Generic Information'); ?></h3>
			<div class="graphsContainer" style="display: flex">
				<div class="sexGraphContainer">
					<h4><?php echo __('By Sex'); ?></h4>
				<div class="sexGraph">
					<canvas id="sexGraphCanvas"></canvas>
				</div>
				</div>
				<div class="ageGraphContainer">
					<h4><?php echo __('By Age Group'); ?></h4>
				<div class="ageGraph">
					<canvas id="ageGraphCanvas"></canvas>
				</div>
				</div>
				<div class="schoolingGraphContainer">
					<h4><?php echo __('By Education'); ?></h4>
				<div class="schoolingGraph">
					<canvas id="schoolingGraphCanvas"></canvas>
				</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<div>
			<?php
				if($cfg && $cfg->isKnowledgebaseEnabled()){
				//FIXME: provide ability to feature or select random FAQs ??
				?>
			<br/><br/>
			<?php
				$cats = Category::getFeatured();
				if ($cats->all()) { ?>
			<h1><?php echo __('Featured Knowledge Base Articles'); ?></h1>
			<?php
				}
				
				foreach ($cats as $C) { ?>
			<div class="featured-category front-page">
				<i class="icon-folder-open icon-2x"></i>
				<div class="category-name">
					<?php echo $C->getName(); ?>
				</div>
				<?php foreach ($C->getTopArticles() as $F) { ?>
				<div class="article-headline">
					<div class="article-title"><a href="<?php echo ROOT_PATH;
						?>kb/faq.php?id=<?php echo $F->getId(); ?>"><?php
						echo $F->getQuestion(); ?></a></div>
					<div class="article-teaser"><?php echo $F->getTeaser(); ?></div>
				</div>
				<?php } ?>
			</div>
			<?php
				}
				}
				?>
		</div>
	</div>
</div>
<script>
	$('document').ready(function () {

		$.ajax({
			type: "POST",
			url: "https://www.cruz.ce.gov.br/esic/upload/chartGlobal.php",
			dataType: "json",
			success: function (data) {

				var requestarray = [];
				for (var i = 0; i < data.length; i++) {

					requestarray.push(data[i].totalg);
					
				}

				graficog(requestarray);

			}
		});

	})

	function graficog(solicitacoes) {

		new Chart(document.getElementById("requestGraphCanvas"), {
			type: 'doughnut',
			data: {
			  labels: ["Recebidas", "Atendidas"],
			  datasets: [
				{
				  label: "Gráfico por Solicitações",
				  backgroundColor: ["#FCEE21", "#B6D134"],
				  data: solicitacoes,
				  borderWidth: 0,
				}
			  ]
			},
			options: {
				responsive: true,
				legend: {
					position: 'none',
				},
				title: {
					display: false,
					text: 'SOLICITACOES'
				},
				animation: {
					animateScale: false,
					animateRotate: false
				}
			}
		});

	}


	$('document').ready(function () {

		$.ajax({
			type: "POST",
			url: "https://www.cruz.ce.gov.br/esic/upload/chartSex.php",
			dataType: "json",
			success: function (data) {

				var sexoarray = [];
				for (var i = 0; i < data.length; i++) {

					sexoarray.push(data[i].total);
					
				}

				grafico(sexoarray);

			}
		});

	})

	function grafico(sexo) {

		new Chart(document.getElementById("sexGraphCanvas"), {
			type: 'doughnut',
			data: {
			  labels: ["Não Informado", "Masculino", "Feminino"],
			  datasets: [
				{
				  label: "Gráfico por Sexo",
				  backgroundColor: ["#FCEE21", "#B6D134","#35A849"],
				  data: sexo,
				  borderWidth: 0,
				}
			  ]
			},
			options: {
				responsive: true,
				legend: {
					position: 'none',
				},
				title: {
					display: false,
					text: 'POR SEXO'
				},
				animation: {
					animateScale: false,
					animateRotate: false
				}
			}
		});

	}
	
	$('document').ready(function () {

		$.ajax({
			type: "POST",
			url: "https://www.cruz.ce.gov.br/esic/upload/chartAge.php",
			dataType: "json",
			success: function (data) {

				var agearray = [];
				for (var i = 0; i < data.length; i++) {

					agearray.push(data[i].total2);
					
				}

				grafico2(agearray);

			}
		});

	})

	function grafico2(faixa) {

		new Chart(document.getElementById("ageGraphCanvas"), {
			type: 'doughnut',
			data: {
			  labels: ["Não Informado", "12 a 20 anos", "21 a 40 anos", "41 a 60 anos", "Maior de 60 anos"],
			  datasets: [
				{
				  label: "Gráfico por Faixa Etária",
				  backgroundColor: ["#FCEE21", "#B6D134","#35A849", "#069D7E", "#085BA7"],
				  data: faixa,
				  borderWidth: 0,
				}
			  ]
			},
			options: {
				responsive: true,
				legend: {
					position: 'none',
				},
				title: {
					display: false,
					text: 'POR FAIXA ETÁRIA'
				},
				animation: {
					animateScale: false,
					animateRotate: false
				}
			}
		});

	}
	
	$('document').ready(function () {

		$.ajax({
			type: "POST",
			url: "https://www.cruz.ce.gov.br/esic/upload/chartSchooling.php",
			dataType: "json",
			success: function (data) {

				var scoarray = [];
				for (var i = 0; i < data.length; i++) {

					scoarray.push(data[i].total3);
					
				}

				grafico3(scoarray);

			}
		});

	})

	function grafico3(escolaridade) {

		new Chart(document.getElementById("schoolingGraphCanvas"), {
			type: 'doughnut',
			data: {
			  labels: ["Não Informado", "Sem Instrução Formal", "Alfabetizado", "Ensino Fundamental", "Ensino Médio", "Ensino Superior", "Pós-graduação", "Mestrado/Doutorado"],
			  datasets: [
				{
				  label: "Gráfico por Escolaridade",
				  backgroundColor: ["#FCEE21", "#B6D134","#35A849", "#069D7E", "#085BA7", "#3F2F84", "#7E2982", "#CB202D"],
				  data: escolaridade,
				  borderWidth: 0,
				}
			  ]
			},
			options: {
				responsive: true,
				showAllTooltips: true,
				legend: {
					position: 'none',
				},
				title: {
					display: false,
					text: 'POR ESCOLARIDADE'
				},
				animation: {
					animateScale: false,
					animateRotate: false
				}
			}
		});

	}
</script>
<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>