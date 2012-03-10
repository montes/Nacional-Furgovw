<?php error_reporting(E_ERROR | E_WARNING | E_PARSE); ?>
<?php setlocale(LC_ALL, 'es_ES'); ?>
<?php if (!isset($data['error']) && !isset($data['edita'])): ?>
<div id='formImportantDisclaimer'>
	Se rellena un formulario por cada furgo camper.<br /><br />
	Si planeas venir con otro tipo de vehículo consúltalo en <a href='mailto:furgovw@gmail.com'>furgovw@gmail.com</a>
	<br /><br /><br />
	LA INSCRIPCIÓN CUESTA <?php echo $config['price']; ?>€ POR VEHÍCULO Y DA DERECHO AL ACCESO Y PARTICIPACIÓN EN LA CONCENTRACIÓN<br /><br />
	**EL IMPORTE DE LA INSCRIPCIÓN NO ES REEMBOLSABLE SALVO CANCELACIÓN DEL EVENTO, EN NINGÚN OTRO CASO SE DEVOLVERÁ EL DINERO DE LA INSCRIPCIÓN**<br /><br /><br />
	La fecha tope para la inscripción y pago es el <?php echo strftime('%A %e de %B del %G', strtotime($config['inscriptionLimitDate'])); ?>. No se garantiza la inscripción directa durante  la concentración. En todo caso,  tendrá un precio de <?php echo $config['inSituPrice']; ?> € y no se entregará pack de bienvenida. 
</div>

<div id='formDisclaimer'>
	<span class='blue bold'>Normas de obligado cumplimiento para la participación en la concentración. Al realizar la inscripción aceptas las normas y te comprometes a cumplirlas. <br /><br />
	Si no estás de acuerdo con ellas NO realices la inscripción.</span>
	<br /><br />

<strong>PRIMERA. INSCRIPCIÓN.</strong> Para la  participación en la Concentración es necesario rellenar y enviar el formulario establecido. 
Para inscribirse se requiere ser usuario registrado en el portal www.furgovw.org y asistir con vehículo camper. 
La inscripción es por vehículo participante debiendo reflejarse los datos de todos los ocupantes. 
El máximo de participantes por vehículo es 5 (con un máximo de 4 adultos). 
Recibido el formulario, se remitirá un correo de confirmación con los datos necesarios para el ingreso del importe de la inscripción. 
La fecha tope para la inscripción y pago es el <?php echo strftime('%A %e de %B del %G', strtotime($config['inscriptionLimitDate'])); ?>. 
<br /><br />
<strong>SEGUNDA. PRECIO.</strong>  El importe de la inscripción anticipada es de <?php echo $config['price']; ?>€ por vehículo, 
no siendo reembolsable salvo en el supuesto de anulación de la Concentración. Esta inscripción incluye un pack de bienvenida, 
el acceso y participación en los actos, comida popular el día fijado por la organización, actividades y concursos que se realicen. 
No se garantiza la inscripción directa durante la concentración. En todo caso, tendrá un precio de <?php echo $config['inSituPrice']; ?>€ y no se entregará pack de bienvenida.
<br /><br />
<strong>TERCERA. ACCESO AL RECINTO.</strong> 
La concentración se llevará a cabo desde el 
<?php echo strftime('%A %e de %B del %G', strtotime($config['firstDay'])) ?> a las 15:00 al 
<?php echo strftime('%A %e de %B del %G', strtotime($config['firstDay'] . ' +' . $config['durationDays'] . ' days' )) ?> a las 18:00. 
El acceso al recinto será desde las 09:00 a las 00:00.
<br /><br />
<strong>CUARTA. DERECHO DE ADMISIÓN.</strong>  Se impedirá el acceso a personas no inscritas y a quienes manifiesten comportamientos susceptibles de causar molestias a los participantes, o bien que dificulten el normal desarrollo de la actividad y a aquellos que sean expulsados por incumplimiento de las normas de comportamiento y convivencia que se recogen en el artículo siguiente. Los vehículos deberán tener ITV y seguro vigentes para poder acceder al recinto.
<br /><br />
<strong>QUINTA. NORMAS DE COMPORTAMIENTO Y CONVIVENCIA.</strong><br />
Los participantes deberán: <br />
a. Ocupar las zonas asignadas por los organizadores sin invadir las zonas destinadas a otros fines. No se permite la reserva de sitios a otros participantes. La colocación de vehículos se efectuará por orden estricto de llegada.<br />
b. Abstenerse de acceder al escenario o lugar de actuación dispuesto por la organización, salvo que esté previsto por el desarrollo del propio espectáculo.<br />
c. Cumplir los requisitos de acceso y de admisión establecidos, debiendo estar identificados con los distintivos  proporcionados por la organización.<br />
d. Cumplir las instrucciones y normas particulares establecidas por los organizadores para el desarrollo de la actividad, debiendo cumplir los requisitos y condiciones de seguridad y de respeto a los demás participantes. En particular, los asistentes deberán evitar cualquier acción que pudiera producir peligro o molestias, dificultar el desarrollo de la actividad o deteriorar las instalaciones o espacio abierto.<br />
e. Respetar los horarios de descanso, desde las 00:00 a las 08:00, no pudiendo realizar ninguna actividad molesta ni mover vehículos.<br />
f. No obstaculizar los accesos y vías de circulación que se establezcan para garantizar la movilidad de los vehículos y la rápida evacuación si las circunstancias lo exigen. En caso de ser requerido por la organización se deberán mover los vehículos si las circunstancias asi lo exigiesen.<br />
g. Respetar las actividades que se realicen.<br />
h. Respetar la prohibición de fumar en espacios cerrados y no arrojar colillas al suelo en los espacios abiertos.<br />
i. Mantener una actitud cívica, evitando comportamientos molestos o conductas violentas.<br />
j. Los perros deberán ir atados y provistos de cadena, collar y bozal pera los casos de animales potencialmente peligrosos o agresivos. No podrán acceder a los espacios cerrados de las instalaciones, debiendo recogerse los excrementos que generen.<br />
k. Las basuras deberán depositarse en los contenedores habilitados al efectos, debiendo mantener el espacio limpio de residuos.<br />
l. Se prohibe la utilización de cualquier instrumento musical así como cualquier fuente sonora que pueda producir molestias a los demás participantes.<br />
m. Se prohibe la realización de fuego a excepción de los sitios habilitados al efecto por la organización.<br />
n. Se prohibe la  instalación de tiendas de campaña. Se permitirá el uso de toldos si las circunstancias lo permiten.<br />
<br />
NOTA DE LA ORGANIZACIÓN:<br />
Esta concentración tiene como finalidad el que los foreros de furgovw.org que asistan puedan pasar unos días de conviviencia y dar una buena imagen del colectivo. Esta concentración NO es un festival de música, NO son unas fiestas populares.<br />
La organización de esta concentración no es profesional, ni obtiene ningún beneficio. Por ello os pedimos comprensión y apoyo, reiterando que no un festival con todo organizado al detalle. Absolutamente todo el dinero obtenido de inscripciones y patrocinadores se destina a sufragar los gastos necesarios para llevar a cabo esta concentración.<br />
<br />
Entendemos que al 99% de la gente no hace falta decirle nada porque sabe comportarse y divertirse sin molestar a los demás, pero hay un 1% que puede generar problemas y es a ese 1% al que van dirigidas estas normas.<br />
<br />	
</div>
<?php endif; ?>

<div id='form'>
<strong>Formulario Inscripcion: (rellenalo tranquilamente, sin prisa y comprueba q rellenas todo correctamente)</strong><br /><br />
<b>Para cualquier duda puedes dirigirte a <a href='mailto:furgovw@gmail.com'>furgovw@gmail.com</a></b><br><br>

<?php if ($data['error']): ?>
<div class='formError'>Has rellenado erróneamente los campos<br /> <?=$data['error']?></div>
<?php endif; ?>
		<?php if ($data['edita']): ?>
			<form action='/nacional/edita/<?=$data['edita']?>/' method='post'>
				<input type='hidden' name='editForm' value='<?=$data['edita']?>' />
				<p><label>Nick</label> <input name='nick' type='hidden' value='<?=$data['nick']?>' /><label class='nonWritable'><?=$data['nick']?></label></p><br />
		<?php else: ?>
			<form action='/nacional/apuntarse/' method='post'>
				<p><label>Nick</label> <input name='nick' type='hidden' value='<?=$userInfo['name']?>' /><label class='nonWritable'><?=$userInfo['name']?></label></p><br />
		<?php endif; ?>

		<input type='hidden' name='nacionalForm' value='yes' />
 		<p><label>NIF</label> <input type='text' name='nif' value='<?=$data['nif']?>' /></p>
		<p><label>Nombre</label> <input type='text' name='nombre' value='<?=$data['nombre']?>' /></p>
		<p><label>Apellidos</label> <input type='text' name='apellidos' value='<?=$data['apellidos']?>' /></p>
 		<p><label>E-Mail</label> <input type='text' name='correo' value='<?php if ($data['correo']) echo $data['correo']; else echo $userInfo['email']; ?>' /></p>
 		
 		<p><label>Fecha llegada</label> 		
 			<select name='fllegada'>
 			<option value='999'>Selecciona una fecha aproximada</option>
 			<?php foreach ($dates as $date): ?>
 				<option value='<?=$date['save']?>'<?php if ($date['save'] == $data['fllegada']) echo " selected='selected'"; ?>><?=$date['show']?></option>
 			<?php endforeach; ?>
 			</select>
 		</p>
 		
 		<p><label>Adultos</label> 		
 			<select name='adultos'>
	 			<option value='999'>Máximo 4 adultos por vehículo</option>
	 			<option value='1'<?php if ($data['adultos'] == '1'): ?> selected='selected'<?php endif; ?>>1 adulto</option>
	 			<option value='2'<?php if ($data['adultos'] == '2'): ?> selected='selected'<?php endif; ?>>2 adultos</option>
	 			<option value='3'<?php if ($data['adultos'] == '3'): ?> selected='selected'<?php endif; ?>>3 adultos</option>
	 			<option value='4'<?php if ($data['adultos'] == '4'): ?> selected='selected'<?php endif; ?>>4 adultos</option>
 			</select>
 		</p>
 		
 		<p><label>Niños</label> 		
 			<select name='ninyos'>
	 			<option value='999'>Selecciona cuantos niños vienen</option>
	 			<option value='0'<?php if ($data['ninyos'] == '0'): ?> selected='selected'<?php endif; ?>>ningún niño</option>
	 			<option value='1'<?php if ($data['ninyos'] == '1'): ?> selected='selected'<?php endif; ?>>1 niño</option>
	 			<option value='2'<?php if ($data['ninyos'] == '2'): ?> selected='selected'<?php endif; ?>>2 niños</option>
	 			<option value='3'<?php if ($data['ninyos'] == '3'): ?> selected='selected'<?php endif; ?>>3 niños</option>
	 			<option value='4'<?php if ($data['ninyos'] == '4'): ?> selected='selected'<?php endif; ?>>4 niños</option>
 			</select>
 		</p>

 		<p><label>Animales</label> 		
 			<select name='animales'>
	 			<option value='999'>Selecciona si vienes con alguna mascota</option>
	 			<option value='0'<?php if ($data['animales'] == '0'): ?> selected='selected'<?php endif; ?>>ninguna mascota</option>
	 			<option value='1'<?php if ($data['animales'] == '1'): ?> selected='selected'<?php endif; ?>>1 perro</option>
	 			<option value='2'<?php if ($data['animales'] == '2'): ?> selected='selected'<?php endif; ?>>2 perros</option>
	 			<option value='3'<?php if ($data['animales'] == '3'): ?> selected='selected'<?php endif; ?>>3 perros</option>
	 			<option value='4'<?php if ($data['animales'] == '4'): ?> selected='selected'<?php endif; ?>>1 gato</option>
	 			<option value='5'<?php if ($data['animales'] == '5'): ?> selected='selected'<?php endif; ?>>un poco de todo</option>
 			</select>
 		</p>

 		<p><label>País</label> 		
 			<select name='pais'>
 			<option value='999'>Selecciona de que país vienes</option>
 			<?php foreach ($countries as $country): ?>
 				<?php if ($data['pais']): ?>
 					<option value='<?=$country['id']?>'<?php if ($data['pais'] == $country['id']): ?> selected='selected'<?php endif; ?>><?=$country['pais']?></option>
 				<?php else: ?>
 					<option value='<?=$country['id']?>'<?php if ($country['id'] == '1'): ?> selected='selected'<?php endif; ?>><?=$country['pais']?></option>
 				<?php endif; ?>
 			<?php endforeach; ?>
 			</select>
 		</p>

 		<p><label>Provincia</label> 		
 			<select name='provincia'>
 			<option value='999'>Selecciona de que provincia vienes</option>
 			<?php foreach ($counties as $county): ?>
 				<option value='<?=$county['provincia']?>'<?php if ($data['provincia'] == $county['provincia']): ?> selected='selected'<?php endif; ?>><?=$county['provincia']?></option>
 			<?php endforeach; ?>
 			</select>
 		</p>
 		
 		<p><label>Camiseta incluída en la inscripción (+0€)</label> 		
 			<select name='Cam_Extra_1'>
 			<option value='999'>Elige la talla de tu camiseta</option>
 			<?php foreach ($tShirtSizes as $size): ?>
 				<option value='<?=$size?>'<?php if ($data['Cam_Extra_1'] == $size): ?> selected='selected'<?php endif; ?>><?=$size?></option>
 			<?php endforeach; ?>
 			</select>
 		</p>

 		<p><label>Camiseta extra 1 (+<?=$config['extraTShirtPrice']?>€)</label> 		
 			<select name='Cam_Extra_2'>
 			<option value='999'>No</option>
 			<?php foreach ($tShirtSizes as $size): ?>
 				<option value='<?=$size?>'<?php if ($data['Cam_Extra_2'] == $size): ?> selected='selected'<?php endif; ?>><?=$size?></option>
 			<?php endforeach; ?>
 			</select>
 		</p>

 		<p><label>Camiseta extra 2 (+<?=$config['extraTShirtPrice']?>€)</label> 		
 			<select name='Cam_Extra_3'>
 			<option value='999'>No</option>
 			<?php foreach ($tShirtSizes as $size): ?>
 				<option value='<?=$size?>'<?php if ($data['Cam_Extra_3'] == $size): ?> selected='selected'<?php endif; ?>><?=$size?></option>
 			<?php endforeach; ?>
 			</select>
 		</p>

 		<p><label>Camiseta extra 3 (+<?=$config['extraTShirtPrice']?>€)</label> 		
 			<select name='Cam_Extra_4'>
 			<option value='999'>No</option>
 			<?php foreach ($tShirtSizes as $size): ?>
 				<option value='<?=$size?>'<?php if ($data['Cam_Extra_4'] == $size): ?> selected='selected'<?php endif; ?>><?=$size?></option>
 			<?php endforeach; ?>
 			</select>
 		</p>

 		<p><label>Camiseta extra 4 (+<?=$config['extraTShirtPrice']?>€)</label> 		
 			<select name='Cam_Extra_5'>
 			<option value='999'>No</option>
 			<?php foreach ($tShirtSizes as $size): ?>
 				<option value='<?=$size?>'<?php if ($data['Cam_Extra_5'] == $size): ?> selected='selected'<?php endif; ?>><?=$size?></option>
 			<?php endforeach; ?>
 			</select>
 		</p>

 		<p><label>Camiseta extra 5 (+<?=$config['extraTShirtPrice']?>€)</label> 		
 			<select name='Cam_Extra_6'>
 			<option value='999'>No</option>
 			<?php foreach ($tShirtSizes as $size): ?>
 				<option value='<?=$size?>'<?php if ($data['Cam_Extra_6'] == $size): ?> selected='selected'<?php endif; ?>><?=$size?></option>
 			<?php endforeach; ?>
 			</select>
 		</p>

 		<p><label>Marca de tu furgo</label> 		
 			<select name='marcavehiculo'>
 			<option value='999'>Selecciona la marca de tu furgo</option>
 			<?php foreach ($vehicleBrands as $brand): ?>
 				<option value='<?=$brand['nombre']?>'<?php if ($data['marcavehiculo'] == $brand['nombre']): ?> selected='selected'<?php endif; ?>><?=$brand['nombre']?></option>
 			<?php endforeach; ?>
 			</select>
 		</p>

 		<p><label>Modelo de tu furgo</label> <input type='text' name='modelovehiculo' value='<?=$data['modelovehiculo']?>' /></p>
 		
 		<p><label>Año de tu furgo</label> <input type='text' name='anyovehiculo' value='<?=$data['anyovehiculo']?>' /></p>

 		<p><label>Matrícula de tu furgo</label> <input type='text' name='matriculavehiculo' value='<?=$data['matriculavehiculo']?>' /></p>
 		
 		<p><label>Comentarios</label><textarea name='comentarios'><?=$data['comentarios']?></textarea></p>	
</div>
<input id='formButton' type='submit' value='Enviar' />
</form>

