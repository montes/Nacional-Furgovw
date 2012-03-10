
<br>Hemos recibido tu inscripción en la Concentración Nacional Furgovw <?=$data['year']?>.<br><br><br>


<h1 style='font-size:18px;font-weight:bold;'>TU NÚMERO DE INSCRIPCIÓN ES: <?=$data['numpago']?><br><br>

Para que tu inscripción sea válida debes ingresar <?=$data['price']?> euros en la siguiente cuenta:<br><br>

<strong><?=$config['bankAccount']?></strong><br>
La Caixa<br />
CLUB CAMPER FURGOVW<br><br>

<strong>** EN EL CONCEPTO DEL INGRESO DEBES INDICAR TU NICK Y TU NÚMERO DE INSCRIPCIÓN: <?=$data['numpago']?> **</strong><br><br><br>
</h1>


<br>Has indicado los siguientes datos:<br>

<br>Nick: <?=$data['nick']?>
<br>Nombre: <?=$data['nombre']?>
<br>Apellidos: <?=$data['apellidos']?>
<br>Fecha Llegada: <?=$data['fllegada']?>
<br>Adultos: <?=$data['adultos']?>
<br>Niños: <?=$data['ninyos']?>
<br>Marca Vehículo: <?=$data['matriculavehiculo']?>
<br>Modelo: <?=$data['modelovehiculo']?>
<br>Año Vehículo: <?=$data['anyovehiculo']?>
<br>Matrícula: <?=$data['matriculavehiculo']?>
<br>País: <?=$data['pais']?>
<br>Provincia: <?=$data['provincia']?>

<?php if ($data['Cam_Extra_1' != '999']): ?>
	<br><br>Has escogido la talla <?=$data['Cam_Extra_1']?> para la camiseta gratuita que te corresponde con la inscripción. 
<?php endif; ?>

<?php if ($data['Cam_Extra_2'] != "999" && $data['Cam_Extra_3'] != "999" && $data['Cam_Extra_4'] != "999" && $data['Cam_Extra_5'] != "999" && $data['Cam_Extra_6'] != "999"): ?>
	<br>Y para camisetas extras has escogido <?=$data['Cam_Extra_2']?>, <?=$data['Cam_Extra_3']?>, <?=$data['Cam_Extra_4']?>, <?=$data['Cam_Extra_5']?> y <?=$data['Cam_Extra_6']?>.
<?php elseif ($data['Cam_Extra_2'] != "999" && $data['Cam_Extra_3'] != "999" && $data['Cam_Extra_4'] != "999" && $data['Cam_Extra_5'] != "999"): ?>
	<br>Y para camisetas extras has escogido <?=$data['Cam_Extra_2']?>, <?=$data['Cam_Extra_3']?>, <?=$data['Cam_Extra_4']?> y <?=$data['Cam_Extra_5']?>.
<?php elseif ($data['Cam_Extra_2'] != "999" && $data['Cam_Extra_3'] != "999" && $data['Cam_Extra_4'] != "999"): ?>
	<br>Y para camisetas extras has escogido <?=$data['Cam_Extra_2']?>, <?=$data['Cam_Extra_3']?> y <?=$data['Cam_Extra_4']?>.
<?php elseif ($data['Cam_Extra_2'] != "999" && $data['Cam_Extra_3'] != "999"): ?>
	<br>Y para camisetas extras has escogido <?=$data['Cam_Extra_2']?> y <?=$data['Cam_Extra_3']?>.
<?php elseif ($data['Cam_Extra_2'] != "999"): ?>
	<br>Y como camiseta extra la talla <?=$data['Cam_Extra_2']?>.
<?php endif; ?>



<br><br><br>¡Muchas gracias por tu participación!<br>

