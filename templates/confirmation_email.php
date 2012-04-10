<center>
	<img src="http://www.furgovw.org/Themes/default/images/smflogof.png">
	<br>Hemos recibido tu <span style="text-decoration:underline;">solicitud de inscripción</span> para participar en la "<span style="text-decoration:underline;font-weight:bold;">Concentración Nacional Furgovw <?=$year?></span>"<br><br>
	*******************************
	<br>
	Tu número de inscripción es el: <span style="font-weight:bold;text-decoration:underline;font-size:140%;"><?=$data['numpago']?></span><br><br>

	Para confirmar tu inscripción debes ingresar <span style="font-weight:bold;text-decoration:underline;"><?=$data['price']?>€</span> en la siguiente cuenta:<br><br>

	<strong><?=$config['bankAccount']?></strong><br>
	La Caixa<br />
	CLUB CAMPER FURGOVW<br><br>

	En el <strong>CONCEPTO DEL INGRESO</strong> deberás poner tu nick: <span style="font-weight:bold;text-decoration:underline;"><?=$nick?></span> y tu número de inscripción: <?=$data['numpago']?><br><br>
	*******************************	
</center>

<br>Tus datos personales son:<br>

<ul>
<li>Nick: <?=$data['nick']?></li>
<li>Nombre: <?=$data['nombre']?></li>
<li>Apellidos: <?=$data['apellidos']?></li>
<li>Provincia: <?=$data['provincia']?></li>
<li>Fecha Llegada: <?=$data['fllegada']?></li>
<li>Adultos: <?=$data['adultos']?></li>
<li>Niños: <?=$data['ninyos']?></li>
</ul>

<br>Y tu furgo es:<br>

<ul>
<li>Marca Vehículo: <?=$data['marcavehiculo']?></li>
<li>Modelo: <?=$data['modelovehiculo']?></li>
<li>Año Vehículo: <?=$data['anyovehiculo']?></li>
<li>Matrícula: <?=$data['matriculavehiculo']?></li>
</ul>

<br>Has escogido las siguientes camisetas:<br>

<ul>
<?php if ($data['Cam_Extra_1'] != '999'): ?>
	<li>Incluída en la inscripción <?=$data['Cam_Extra_1']?></li>
<?php endif; ?>

<?php for ($cont = 2; $cont <= 6; $cont++): ?>
	<?php if ($data['Cam_Extra_'.$cont] != '999'): ?>
		<li>Camiseta Extra (<?=$extraTShirtPrice?>€): <?=$data['Cam_Extra_'.$cont]?></li>
	<?php endif; ?>
<?php endfor; ?>

<center>
*******************************
<br>
Tu número de inscripción es el: <span style="font-weight:bold;text-decoration:underline;font-size:140%;"><?=$data['numpago']?></span><br><br>

Para confirmar tu inscripción debes ingresar <span style="font-weight:bold;text-decoration:underline;"><?=$data['price']?>€</span> en la siguiente cuenta:<br><br>

<strong><?=$config['bankAccount']?></strong><br>
La Caixa<br />
CLUB CAMPER FURGOVW<br><br>

En el <strong>CONCEPTO DEL INGRESO</strong> deberás poner tu nick: <span style="font-weight:bold;text-decoration:underline;"><?=$nick?></span> y tu número de inscripción: <?=$data['numpago']?><br><br>
*******************************	
</center>

<br><br><br>¡Muchas gracias por tu participación!<br>

