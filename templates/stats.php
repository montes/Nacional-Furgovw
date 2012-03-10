<div style='width:600px;clear:both;margin:0px auto;margin-top:20px;'>
	<h1 style='font-weight:bold;font-size:20px;display:block;clear:both;float:left;'>Total Vehículos Inscritos: <?php echo count($allInscriptionsArray); ?></h1>

	<?php if ($statistics): ?>
		<div style='width:500px;margin:10px;padding:5px;clear:both;float:left;'>
			<p><strong>Adultos:</strong> <?php echo $statistics['adults'] ?></p><br />

			<p><strong>Niños:</strong> <?php echo $statistics['childs'] ?></p><br />

			<p><strong>Países:</strong> 
				<?php foreach ($statistics['countries'] as $country): ?>
					<?php echo $country; ?>
				<?php endforeach; ?>
			</p><br />

			<p><strong>Vehículos por comunidad:</strong> 
			<ul>
			<?php foreach ($statistics['communities'] as $community => $total): ?>
				<li><?php echo $community . '-' . $total; ?></li>
			<?php endforeach; ?>
			</ul>
			</p><br />

			<p><strong>Vehículos por provincia:</strong> 
			<ul>
			<?php foreach ($statistics['provinces'] as $province => $total): ?>
				<li><?php echo $province . '-' . $total; ?></li>
			<?php endforeach; ?>
			</ul>
			</p><br />

			<p><strong>Vehículos por año de fabricación:</strong> 
			<ul>
			<?php foreach ($statistics['vehicleYears'] as $vehicle => $total): ?>
				<li><?php echo $vehicle . '-' . $total; ?></li>
			<?php endforeach; ?>
			</ul>
			</p><br />

			<p><strong>Vehículos por marca:</strong> 
			<ul>
			<?php foreach ($statistics['vehicleBrands'] as $vehicle => $total): ?>
				<li><?php echo $vehicle . '-' . $total; ?></li>
			<?php endforeach; ?>
			</ul>
			</p><br />		
		</div>
	<?php endif; ?>
		
	<?php if ($allInscriptionsArray): ?>
		<?php foreach ($allInscriptionsArray as $inscription): ?>
			<div style='width:300px;margin:3px;clear:left;float:left;<?php if ($inscription['pagado'] == '1'): ?>background-color:green;<?php else: ?>background-color:#FCC;<?php endif; ?>' class='inscription' id='priceInscription<?php echo $inscription['id']; ?>'>
				<div class='inscription'><?php echo $inscription['numpago']; ?></div>
				<div style='margin:2px;padding:3px 3px 3px 8px;float:left;overflow:hidden;'><strong><?php echo $inscription['nick']; ?></strong><?php if ($inscription['pagado'] == '1'): ?> -pagado-<?php endif; ?></div>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>