
	<?php if (file_exists('/nacional/img/logo' . $year . '.png')): ?>
		<a href='/nacional/apuntarse/'><img id='actualNacionalLogo' alt='<?php echo $title; ?>' title='<?php echo $title; ?>' src='/nacional/img/logo<?php echo $year; ?>.png'></a>
	<?php else: ?>
		<br><br>
	<?php endif; ?>
	
	<h1 style='width:auto;text-align:center;' class='centered'><?php echo $title; ?></h1>
