<?php error_reporting(E_ERROR | E_WARNING | E_PARSE); ?>
<div id='adminIndexContainer'>
	<h3>admin zone</h3>
	<div id='adminIndex'>
		<form action='/nacional/admin/' method='post'>
			<input type='hidden' name='adminForm' value='yes' />
			<p><label>Primer día de la nacional</label> <input name='firstDay' type='text' value='<?=$config['firstDay']?>' /></p>
			<p><label>Días de duración</label> <input name='durationDays' type='text' value='<?=$config['durationDays']?>' /></p>
			<p><label>Fecha límite inscripción</label> <input name='inscriptionLimitDate' type='text' value='<?=$config['inscriptionLimitDate']?>' /></p>
			<p><label>Cuenta del banco</label> <input type='text' name='bankAccount' value='<?=$config['bankAccount']?>' /></p>
			<p><label>Máximas inscripciones</label> <input type='text' name='maxInscriptions' value='<?=$config['maxInscriptions']?>' /></p>
			<p><label>Precio inscripción</label> <input type='text' name='price' value='<?=$config['price']?>' /></p>
			<p><label>Precio inscrip. in situ</label> <input type='text' name='inSituPrice' value='<?=$config['inSituPrice']?>' /></p>
			<p><label>Precio camiseta extra</label> <input type='text' name='extraTShirtPrice' value='<?=$config['extraTShirtPrice']?>' /></p>
			<p><input name='extraTShirts' value='1' type='checkbox' <?php if ($config['extraTShirts'] == "1"): ?>checked='checked' <?php endif; ?>/> Permitida petición de camisetas extras</p>
			<p><input name='inscriptionsOpened' value='1' type='checkbox' <?php if ($config['inscriptionsOpened'] == "1"): ?>checked='checked' <?php endif; ?>/> Inscripciones abiertas</p><br />
			<input type='submit' value='Grabar' />
		</form>
	</div>
</div>

<div style="clear:both;margin:10px;padding:4px;background-color: #EEE;">
    <p>Total camisetas de regalo en inscripción pagada: <?=$config['totalNotPaidTShirts']?></p>
    <p>Total camisetas extra pagadas: <?=$config['totalPaidExtraTShirts']?></p>
    <p>Total camisetas de regalo o extras NO pagadas: <?=$config['totalNotPaidTShirts']?></p>
    <br /><br />
    <?php foreach ($paidSizes as $size => $total): ?>
        Total <?=$size?> pagadas: <?=$total?><br />
    <?php endforeach; ?>
    <br /><br />
    <?php foreach ($notPaidSizes as $size => $total): ?>
        Total <?=$size?> NO pagadas: <?=$total?><br />
    <?php endforeach; ?>
</div>

<div id='inscriptionsContainer'>
	<p><strong>Total Inscritos: <?php echo count($allInscriptionsArray); echo ' ('.$paidInscriptions; ?> pagado)</strong></p>
	
	<?php if ($allInscriptionsArray): ?>
		<?php $cont = 0; ?>
		<?php foreach ($allInscriptionsArray as $inscription): ?>		
			<?php $cont++; ?>
			<div class='inscriptionRow<?php if ($cont % 2 == 0) echo '2'; ?>' id='inscription<?=$inscription['id']?>'>
				<div style='clear:both;float:left;overflow:auto;border:1px solid;margin:2px;'>
					<div class='inscription'><?=$inscription['numpago']?></div>
					<div class='inscription'><?=$inscription['nick']?> <a href='/nacional/edita/<?=$inscription['id']?>'>Editar</a></div>
				</div>
				<div class='inscription' style='clear:left;float:left;'><?=$inscription['nif']?></div>
				<div class='inscription'><?=$inscription['nombre']?></div>
				<div class='inscription'><?=$inscription['apellidos']?></div>		
				<div class='inscription'><?=$inscription['provincia']?></div>
				<div class='inscription'><?=$inscription['pais']?></div>
				<div class='inscription'><?=$inscription['correo']?></div>
				<div class='inscription'><?=$inscription['fllegada']?></div>
				<div style='clear:left;float:left;' class='inscription'>Adultos: <?=$inscription['adultos']?></div>
				<div class='inscription'>Niños: <?=$inscription['ninyos']?></div>
				<div class='inscription'><?=$inscription['animales']?></div>
				<div style='clear:left;float:left;' class='inscription'><?=$inscription['marcavehiculo']?></div>
				<div class='inscription'><?=$inscription['modelovehiculo']?></div>
				<div class='inscription'><?=$inscription['anyovehiculo']?></div>
				<div class='inscription'><?=$inscription['matriculavehiculo']?></div>
				<?php if ($inscription['comentarios']): ?>
					<div style='clear:left;float:left;' class='inscription'><?=$inscription['comentarios']?></div>
				<?php endif; ?>
				<?php if ($inscription['pagado_en_plazo']): ?>
					<div style='background-color:green;color:black;font-weight:bold;' class='inscription'>Pagado <?=$inscription['pagado_en_plazo']?></div>
				<?php endif; ?>
				<div style='clear:left;float:left;' class='inscription'><?=$inscription['Cam_Extra_1']?></div>
				<?php if ($inscription['Cam_Extra_2'] != '999'): ?>
					<div class='inscription'><?=$inscription['Cam_Extra_2']?></div>
				<?php endif; ?>
				<?php if ($inscription['Cam_Extra_3'] != '999'): ?>
					<div class='inscription'><?=$inscription['Cam_Extra_3']?></div>
				<?php endif; ?>
				<?php if ($inscription['Cam_Extra_4'] != '999'): ?>
					<div class='inscription'><?=$inscription['Cam_Extra_4']?></div>
				<?php endif; ?>
				<?php if ($inscription['Cam_Extra_5'] != '999'): ?>
					<div class='inscription'><?=$inscription['Cam_Extra_5']?></div>
				<?php endif; ?>
				<?php if ($inscription['Cam_Extra_6'] != '999'): ?>
					<div class='inscription'><?=$inscription['Cam_Extra_6']?></div>
				<?php endif; ?>
				<div style='clear:left;float:left;<?php if ($inscription['pagado'] == '1'): ?>background-color:green;<?php endif; ?>' class='inscription' id='priceInscription<?=$inscription['id']?>'><?=$inscription['price']?>€ 
					<?php if ($inscription['pagado'] == '0'): ?>
						<a href='#' onclick='return checkPayment(<?=$inscription['id']?>);'>Marcar pagado</a>
					<?php else: ?>
						<a href='#' onclick='return checkPayment(<?=$inscription['id']?>);'>Marcar NO pagado</a>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
