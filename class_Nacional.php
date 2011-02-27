<?php
/*
 * This is an UTF-8 file
 * 
 * This file is part of the furgovw.org meeting inscription system
 * and it's used in conjunction with:
 * 
 * SMF - Simple Machines Forum - http://www.simplemachines.org
 * Haanga Template System - http://www.haanga.org
 * 
 * (C) Javier Montes <javier@mooontes.com>
 * http://mooontes.com - Twitter: @mooontes
 * 
 * Inscription system working at: http://www.furgovw.org/nacional/
 * 
 */

/**
 * class Nacional
 * 
 * @author Javier Montes <javier@mooontes.com>
 */
class Nacional 
{	
	private static $_title;
	private static $_userInfo;
	private static $_year;
	private static $_db;
	private static $_moderator = false;
	private static $_inscriptionData = false;
	private static $_config = false;
	private static $_tShirtSizes = array(
					'Hombre S',
					'Hombre M',
					'Hombre L',
					'Hombre XL',
					'Hombre XXL',
					'Mujer S',
					'Mujer M',
					'Mujer L',
					'Mujer XL'
					);

	/**
	 * We are static, no instances 
	 */
	private function __construct() 
	{
	}

	/**
	 * Init class
	 * 
	 * @param $db PHP Mysqli Instance
	 * @param $userInfo SMF $user_info array
	 */
	public static function init($db, $userInfo)
	{
		$result = $db->query("SELECT * FROM fnacional_config WHERE id = 0");
		
		if ($db->affected_rows > 0 && is_array($userInfo)) {
			
			self::$_config = $result->fetch_array(MYSQLI_ASSOC);
			
			self::$_year = date('Y');
			self::$_db = $db;
			self::setTitle();
			
			self::$_userInfo = $userInfo;
			if (!self::$_userInfo['is_guest']) {
				self::checkIfIsModerator();
				self::loadInscriptionData();
				if (self::$_moderator && $_POST['adminForm'] == 'yes') {
					self::loadConfigFromPost();
					self::saveConfig();
				}
			}
						
			return true;
			
		} else {
			return false;
		}
	}
	
	public static function getTitle()
	{
		if (self::$_title != '')
		{
			return self::$_title;
		}
		else
			return false;
	}
	
	public static function getInscriptionsOpened()
	{
		if (is_array(self::$_config))
			return self::$_config['inscriptionsOpened'];
		else
			return false;
	}
	
	public static function getInscriptionData()
	{
		return self::$_inscriptionData;
	}
	
	public static function getAllInscriptions()
	{
		$result = self::$_db->query('SELECT * FROM fnacional WHERE year = "'.self::$_year.'"');
		
		if (self::$_db->affected_rows > 0)
		{
			$inscriptionsArray = array();
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$inscriptionsArray[] = $row;
			}
			return $inscriptionsArray;
		}
		else
			false;
	}

	public static function getTShirtsSizes()
	{
		return self::$_tShirtSizes;
	}
	
	public static function getConfig()
	{
		return self::$_config;
	}
	
	public static function getModerator()
	{
		return self::$_moderator;
	}
	
	public static function getTshirtStats()
	{
		if (!self::$_moderator) {
			return false;
		}
		
		$paidTShirts = 0;
		for ($cont = 1; $cont < 7; $cont++) {
			self::$_db->query("SELECT COUNT(*) as total FROM fnacional WHERE Cam_Extra_$cont IS NOT NULL AND pagado = 1 AND year = '".self::$_year."'");
			if (self::$_db->affected_rows > 0) {
				$row = $result->fetch_object();
				$paidTShirts += $row->total;
			}
		}
		
		$notPaidTShirts = 0;
		for ($cont = 1; $cont < 7; $cont++) {
			self::$_db->query("SELECT COUNT(*) as total FROM fnacional WHERE Cam_Extra_$cont IS NOT NULL AND pagado = 0 AND year = '".self::$_year."'");
			if (self::$_db->affected_rows > 0) {
				$row = $result->fetch_object();
				$notPaidTShirts += $row->total;
			}
		}

		$paidSizes = array();
		for ($cont = 1; $cont < 7; $cont++) {
			self::$_db->query("SELECT Cam_Extra_$cont as tShirtSize, COUNT(*) as total FROM 
								fnacional WHERE Cam_Extra_$cont IS NOT NULL AND pagado=1 AND year = '".self::$_year."' GROUP BY Cam_Extra_$cont");
			if (self::$_db->affected_rows > 0) {
				$row = $result->fetch_object();
				if (array_key_exists($obj->tShirtSize, $paidSizes)) {
					$paidSizes[$obj->tShirtSize] += $obj->total;
				} else {
					$paidSizes[$obj->tShirtSize] = $obj->total;
				}
			}
		}

		$notPaidSizes = array();
		for ($cont = 1; $cont < 7; $cont++) {
			self::$_db->query("SELECT Cam_Extra_$cont as tShirtSize, COUNT(*) as total FROM 
								fnacional WHERE Cam_Extra_$cont IS NOT NULL AND pagado=1 AND year = '".self::$_year."' GROUP BY Cam_Extra_$cont");
			if (self::$_db->affected_rows > 0) {
				$row = $result->fetch_object();
				if (array_key_exists($obj->tShirtSize, $notPaidSizes)) {
					$notPaidSizes[$obj->tShirtSize] += $obj->total;
				} else {
					$notPaidSizes[$obj->tShirtSize] = $obj->total;
				}
			}
		}
		
		return array('paidTShirts' => $paidTShirts,
					'notPaidTShirts' => $notPaidTShirts,
					'paidSizes' => $paidSizes,
					'notPaidSizes' => $notPaidSizes
					);
	}
	
	public static function getError()
	{
		self::loadInscriptionData();
		
		if (self::$_userInfo['is_guest'] || !is_array(self::$_userInfo))
		{			
			return "Debes estar registrado en el foro para poder apuntarte a la concentración nacional:<br /><br />".
				"<a href='http://www.furgovw.org/index.php?action=register'>Registrarse en el foro</a>";
		}
		elseif (self::$_config['inscriptionsOpened'] == '0')
		{
			return "Lo sentimos, aún no se han abierto las inscripciones para la nacional.";
		}
		elseif ( 
				(strtotime(date("Y-m-d")) > strtotime(self::$_config['inscriptionLimitDate'])) &&
				(self::$_inscriptionData === false)
				)
		{
			return "Lo sentimos, se ha pasado la fecha límite para la inscripción.";
		}
		elseif (self::$_inscriptionData === false)
		{
			$result = self::$_db->query('SELECT COUNT(*) as total FROM fnacional WHERE year = "'.self::$_year.'"');
			$obj = $result->fetch_object();
			if ($obj->total > self::$_config['maxInscriptions'])
			{
				return 'Lo sentimos, se ha sobrepasado el límite de inscripciones, no quedan plazas.';
			}
		}
		elseif (is_array(self::$_inscriptionData) && is_numeric(self::$_inscriptionData['numpago']))
		{
			if (self::$_inscriptionData['pagado'] == '1') {
				return 'Ya has realizado la inscripción, tu número de inscripción es <strong>'.self::$_inscriptionData['numpago'].
					'</strong><br /><br />Tu pago ha sido confirmado.';
			} else {
				return 'Ya has realizado la inscripción, tu número de inscripción es <strong>'.self::$_inscriptionData['numpago'].
					'</strong><br /><br />Debes ingresar '.self::$_inscriptionData['price'].'€ en la cuenta del foro:<br /><br />'.
					'CLUB CAMPER FURGOVW<br />La Caixa<br />'.self::$_config['bankAccount'].'<br /><br />
					Aún no hemos confirmado tu pago, si ya has pagado ten paciencia, tardaremos unos días en confirmarlo.';
			} 
		}
		
		return false;
	}
	
	public static function doModeratorTasks()
	{
		if (!self::$_moderator) return false;
		
		if (is_numeric($_GET['pagado']))
		{
			self::$_db->query('UPDATE fnacional SET pagado=1 WHERE id = '.$_GET['pagado']);
			return 'ID '.$_GET['pagado'].' marcado como pagado.';
		}
		elseif (is_numeric($_GET['reenviar']))
		{
			self::loadInscriptionData($_GET['reenviar']);
			if (self::sendConfirmationEmail())
				return "Mensaje enviado a $emailTo";
			else
				return "Error al enviar mensaje a $emailTo";
		}
		else
			return false;
	}
	
	public static function saveInscriptionDataFromPost()
	{
		$errorMsg = '';
		
		self::$_inscriptionData['nif'] = $_POST['nif'];
		if (self::validateCif($_POST['nif']) < 1) {
			 $errorMsg .= '<br />-NIF';
		}
		
		self::$_inscriptionData['nombre'] = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		if (self::$_inscriptionData['nombre'] == '') {
			$errorMsg .= '<br />-Nombre';
		}
		
		self::$_inscriptionData['apellidos'] = filter_var($_POST['apellidos'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		if (self::$_inscriptionData['apellidos'] == '') {
			$errorMsg .= '<br />-Apellidos';
		}
		
		self::$_inscriptionData['correo'] = $_POST['correo'];
		if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
			 $errorMsg .= '<br />-Email';
		}

		self::$_inscriptionData['fllegada'] = filter_var($_POST['fllegada'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		if ($_POST['fllegada'] == '999') {
			$errorMsg .= '<br />-Fecha llegada';
		}
		
		self::$_inscriptionData['adultos'] = $_POST['adultos'];
		if (!is_numeric($_POST['adultos']) || $_POST['adultos'] == '999') {
			$errorMsg .= '<br />-Adultos';
		}

		self::$_inscriptionData['ninyos'] = $_POST['ninyos'];
		if (!is_numeric($_POST['ninyos']) || $_POST['ninyos'] == '999') {
			$errorMsg .= '<br />-Niños';
		}

		self::$_inscriptionData['animales'] = $_POST['animales'];
		if (!is_numeric($_POST['animales']) || $_POST['animales'] == '999') {
			$errorMsg .= '<br />-Animales';
		}
		
		self::$_inscriptionData['pais'] = filter_var($_POST['pais'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		if ($_POST['pais'] == '' || $_POST['pais'] == '999') {
			$errorMsg .= '<br />-País';
		}
		
		self::$_inscriptionData['provincia'] = filter_var($_POST['provincia'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		if ($_POST['provincia'] == '' || $_POST['provincia'] == '999') {
			$errorMsg .= '<br />-Provincia';
		}
		
		self::$_inscriptionData['Cam_Extra_1'] = filter_var($_POST['Cam_Extra_1'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		if ($_POST['Cam_Extra_1'] == '') {
			$errorMsg .= '<br />-Camiseta';
		}
		
		self::$_inscriptionData['Cam_Extra_2'] = filter_var($_POST['Cam_Extra_2'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		self::$_inscriptionData['Cam_Extra_3'] = filter_var($_POST['Cam_Extra_3'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		self::$_inscriptionData['Cam_Extra_4'] = filter_var($_POST['Cam_Extra_4'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		self::$_inscriptionData['Cam_Extra_5'] = filter_var($_POST['Cam_Extra_5'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		self::$_inscriptionData['Cam_Extra_6'] = filter_var($_POST['Cam_Extra_6'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);

		self::$_inscriptionData['marcavehiculo'] = filter_var($_POST['marcavehiculo'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		if ($_POST['marcavehiculo'] == '999') {
			$errorMsg .= '<br />-Marca Vehículo';
		}
		
		self::$_inscriptionData['modelovehiculo'] = filter_var($_POST['modelovehiculo'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		if ($_POST['modelovehiculo'] == '') {
			$errorMsg .= '<br />-Modelo Vehículo';
		}
		
		self::$_inscriptionData['anyovehiculo'] = $_POST['anyovehiculo'];
		if (!is_numeric($_POST['anyovehiculo']) || $_POST['anyovehiculo'] < 1940 || $_POST['anyovehiculo'] > 2020) {
			$errorMsg .= '<br />-Año Vehículo';
		}
		
		self::$_inscriptionData['matriculavehiculo'] = filter_var($_POST['matriculavehiculo'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		if (strlen($_POST['matriculavehiculo']) < 5) {
			$errorMsg .= '<br />-Matrícula Vehículo';
		}
		
		self::$_inscriptionData['comentarios'] = filter_var($_POST['comentarios'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
		
		self::$_inscriptionData['error'] = $errorMsg;

		if ($errorMsg == '') {
			self::saveInscriptionData();
		}
	}
	
	private static function saveInscriptionData()
	{
		self::$_db->query('SELECT id FROM fnacional WHERE idmember = "'.self::$_userInfo['id'].'" AND year = "'.self::$_year.'"');
		if (self::$_db->affected_rows > 0) {
			return false;
		}
		
		$result = self::$_db->query('SELECT numpago FROM fnacional WHERE year = "'.self::$_year.'" ORDER BY numpago DESC LIMIT 1');
		if (self::$_db->affected_rows > 0) {
			$obj = $result->fetch_object();
			$newId = $obj->numpago + 1;
		}
		else {
			$newId = 1;
		}
		
		self::$_inscriptionData['numpago'] = $newId;
		
		if (self::calcInscriptionPrice() === false) {
			return false;
		}
		
		self::$_db->query('
			INSERT INTO fnacional
			SET
			year = "'.self::$_db->real_escape_string(self::$_year).'",
			numpago = "'.$newId.'",
			nif = "'.self::$_db->real_escape_string(self::$_inscriptionData['nif']).'",
			nombre = "'.self::$_db->real_escape_string(self::$_inscriptionData['nombre']).'",
			apellidos = "'.self::$_db->real_escape_string(self::$_inscriptionData['apellidos']).'",
			nick = "'.self::$_userInfo['username'].'",
			idmember = "'.self::$_userInfo['id'].'",
			price = "'.self::$_inscriptionData['price'].'",
			fllegada = "'.self::$_db->real_escape_string(self::$_inscriptionData['fllegada']).'",
			adultos = "'.self::$_db->real_escape_string(self::$_inscriptionData['adultos']).'",
			ninyos = "'.self::$_db->real_escape_string(self::$_inscriptionData['ninyos']).'",
			animales = "'.self::$_db->real_escape_string(self::$_inscriptionData['animales']).'",
			marcavehiculo = "'.self::$_db->real_escape_string(self::$_inscriptionData['marcavehiculo']).'",
			modelovehiculo = "'.self::$_db->real_escape_string(self::$_inscriptionData['modelovehiculo']).'",
			anyovehiculo = "'.self::$_db->real_escape_string(self::$_inscriptionData['anyovehiculo']).'",
			matriculavehiculo = "'.self::$_db->real_escape_string(self::$_inscriptionData['matriculavehiculo']).'",
			pais = "'.self::$_db->real_escape_string(self::$_inscriptionData['pais']).'",
			provincia = "'.self::$_db->real_escape_string(self::$_inscriptionData['provincia']).'",
			correo = "'.self::$_db->real_escape_string(self::$_inscriptionData['correo']).'",
			comentarios = "'.self::$_db->real_escape_string(self::$_inscriptionData['comentarios']).'",
			localidad = "'.self::$_db->real_escape_string(self::$_inscriptionData['localidad']).'",
			fechainscripcion = NOW(),
			Cam_Extra_1 = "'.self::$_db->real_escape_string(self::$_inscriptionData['Cam_Extra_1']).'",
			Cam_Extra_2 = "'.self::$_db->real_escape_string(self::$_inscriptionData['Cam_Extra_2']).'",
			Cam_Extra_3 = "'.self::$_db->real_escape_string(self::$_inscriptionData['Cam_Extra_3']).'",
			Cam_Extra_4 = "'.self::$_db->real_escape_string(self::$_inscriptionData['Cam_Extra_4']).'",
			Cam_Extra_5 = "'.self::$_db->real_escape_string(self::$_inscriptionData['Cam_Extra_5']).'",
			Cam_Extra_6 = "'.self::$_db->real_escape_string(self::$_inscriptionData['Cam_Extra_6']).'",
			ip = "'.self::$_db->real_escape_string(self::$_userInfo['ip']).'"
			');
		
		self::sendConfirmationEmail();
	}
	
	private static function loadConfigFromPost() 
	{
		if (!self::$_moderator) {
			return false;
		}
		
		self::$_config['firstDay'] = date('Y-m-d', strtotime($_POST['firstDay']));
		self::$_config['inscriptionLimitDate'] = date('Y-m-d', strtotime($_POST['inscriptionLimitDate']));
		self::$_config['maxInscriptions'] = is_numeric($_POST['maxInscriptions']) ? $_POST['maxInscriptions'] : '0';
		self::$_config['extraTShirts'] = is_numeric($_POST['extraTShirts']) ? $_POST['extraTShirts'] : '0';
		self::$_config['inscriptionsOpened'] = $_POST['inscriptionsOpened'] == '1' ? '1' : '0';
		self::$_config['price'] = is_numeric($_POST['price']) ? $_POST['price'] : '0';
		self::$_config['inSituPrice'] = is_numeric($_POST['inSituPrice']) ? $_POST['inSituPrice'] : '0';
		self::$_config['bankAccount'] = $_POST['bankAccount'];
		self::$_config['extraTShirtPrice'] = is_numeric($_POST['extraTShirtPrice']) ? $_POST['extraTShirtPrice'] : '0';;
	}
	
	private static function saveConfig()
	{
		if (!self::$_moderator || !is_array(self::$_config) || self::$_config['bankAccount'] == '') {
			return false;
		}
		
		self::$_db->query('
			UPDATE fnacional_config SET
			firstDay = "'.self::$_config['firstDay'].'",
			inscriptionLimitDate = "'.self::$_config['inscriptionLimitDate'].'",
			maxInscriptions = "'.self::$_config['maxInscriptions'].'",
			extraTShirts = "'.self::$_config['extraTShirts'].'",
			inscriptionsOpened = "'.self::$_config['inscriptionsOpened'].'",
			price = "'.self::$_config['price'].'",
			inSituPrice = "'.self::$_config['inSituPrice'].'",
			bankAccount = "'.self::$_db->real_escape_string(self::$_config['bankAccount']).'",
			extraTShirtPrice = "'.self::$_config['extraTShirtPrice'].'"
			WHERE id = 0
			LIMIT 1
			');		
	}
	
	private static function sendConfirmationEmail()
	{
		if (!is_array(self::$_userInfo) || self::$_userInfo['is_guest'] || !is_array(self::$_inscriptionData)) return false;
		
		$config = self::$_config;
		$data = self::$_inscriptionData;
		$vars = compact('config', 'data');
		
		$emailText = Haanga::Load('confirmation_email.html', $vars, true);		
		$emailTo = $data['correo'];
		$emailSubject = 'Confirmacion inscripcion Concentracion Nacional Furgovw '.self::$_year;
		$header = "Content-type: text/html; charset=utf-8\r\n";
		$header .= "From: Furgovw <furgovw@gmail.com>\r\n";
		
		return mail($emailTo, $emailSubject, $emailText, $header);
	}
	
	private static function setTitle()
	{
		$romanNacional = "";
		$actualNacional = intval(date('Y') - 2006); //2007 was the first nacional

		$lookup = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
			'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
			'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
 
		foreach ($lookup as $roman => $value) 
   		{
			$matches = intval($actualNacional / $value);				
			$romanNacional .= str_repeat($roman, $matches);				
			$actualNacional = $actualNacional % $value;
   		}
     		
     	self::$_title = "Inscripción $romanNacional Concentración Nacional furgovw.org ".date('Y'); 
	}

	private static function checkIfIsModerator()
	{
		if ( 
			(in_array("1", self::$_userInfo['groups'])) || 
			(in_array("9", self::$_userInfo['groups'])) || 
			(in_array("2", self::$_userInfo['groups'])) 
			)
		{
			self::$_moderator = true;
		}	
		else
		{
			self::$_moderator = false;
		}
	}
	
	private static function loadInscriptionData($id = false)
	{
		if (!is_array(self::$_userInfo) || self::$_userInfo['is_guest']) return false;
		
		if (is_numeric($id))
			$result = self::$_db->query('SELECT * FROM fnacional WHERE id = '.$id.' LIMIT 1');
		else
			$result = self::$_db->query('SELECT * FROM fnacional WHERE idmember = '.
										self::$_userInfo['id'].' AND year = "'.self::$_year.'" LIMIT 1');
			
		if (self::$_db->affected_rows > 0)
		{
			self::$_inscriptionData = $result->fetch_array(MYSQLI_ASSOC);
			if (self::$_inscriptionData['price'] == '0') 
				self::calcInscriptionPrice();
		}
		elseif (self::$_inscriptionData['error'] == '' && !is_numeric(self::$_inscriptionData['numpago'])) {
			self::$_inscriptionData = array();
			self::$_inscriptionData['nick']   = self::$_userInfo['username'];
			self::$_inscriptionData['correo'] = self::$_userInfo['email'];
			self::$_inscriptionData['fllegada'] = date('d/m/Y',strtotime(self::$_config['firstDay']));
		}
	}
	
	private static function calcInscriptionPrice()
	{
		if (!is_array(self::$_inscriptionData) || !is_array(self::$_config)) {
			return false;
		} 
		
		self::$_inscriptionData['price'] = self::$_config['price'];
		if (self::$_inscriptionData['Cam_Extra_2'] != '999') { self::$_inscriptionData['price'] += self::$_config['extraTShirtPrice']; }
		if (self::$_inscriptionData['Cam_Extra_3'] != '999') { self::$_inscriptionData['price'] += self::$_config['extraTShirtPrice']; }
		if (self::$_inscriptionData['Cam_Extra_4'] != '999') { self::$_inscriptionData['price'] += self::$_config['extraTShirtPrice']; }
		if (self::$_inscriptionData['Cam_Extra_5'] != '999') { self::$_inscriptionData['price'] += self::$_config['extraTShirtPrice']; }
		if (self::$_inscriptionData['Cam_Extra_6'] != '999') { self::$_inscriptionData['price'] += self::$_config['extraTShirtPrice']; }
	}
	
	private static function validateCif($cif)
	{
		/**
		 *  valida nif cif nie
		 *  Copyright ©2005-2008 David Vidal Serra. Bajo licencia GNU GPL.
		 *  Este software viene SIN NINGUN TIPO DE GARANTIA; para saber mas detalles
		 *  puede consultar la licencia en http://www.gnu.org/licenses/gpl.txt(1)
		 *  Esto es software libre, y puede ser usado y redistribuirdo de acuerdo
		 *  con la condicion de que el autor jamas sera responsable de su uso.
		 *  Returns: 1 = NIF ok, 2 = CIF ok, 3 = NIE ok, -1 = NIF bad, -2 = CIF bad, -3 = NIE bad, 0 = ??? bad 
		 */
		
	   	$cif = strtoupper($cif);
   		for ($i = 0; $i < 9; $i ++)
      		$num[$i] = substr($cif, $i, 1);
		//si no tiene un formato valido devuelve error
   		if (!ereg('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)', $cif))
      		return 0;
		//comprobacion de NIFs estandar
   		if (ereg('(^[0-9]{8}[A-Z]{1}$)', $cif))
      		if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($cif, 0, 8) % 23, 1))
         		return 1;
      		else
         		return -1;
		//algoritmo para comprobacion de codigos tipo CIF
   		$suma = $num[2] + $num[4] + $num[6];
   		for ($i = 1; $i < 8; $i += 2)
      		$suma += substr((2 * $num[$i]),0,1) + substr((2 * $num[$i]),1,1);
   		$n = 10 - substr($suma, strlen($suma) - 1, 1);
		//comprobacion de NIFs especiales (se calculan como CIFs)
   		if (ereg('^[KLM]{1}', $cif))
      		if ($num[8] == chr(64 + $n))
         		return 1;
      		else
         		return -1;
		//comprobacion de CIFs
   		if (ereg('^[ABCDEFGHJNPQRSUVW]{1}', $cif))
      		if ($num[8] == chr(64 + $n) || $num[8] == substr($n, strlen($n) - 1, 1))
         		return 2;
      		else
         		return -2;
		//comprobacion de NIEs
		   //T
   		if (ereg('^[T]{1}', $cif))
      		if ($num[8] == ereg('^[T]{1}[A-Z0-9]{8}$', $cif))
         		return 3;
      		else
         		return -3;
		   //XYZ
		   if (ereg('^[XYZ]{1}', $cif))
      		if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X','Y','Z'), array('0','1','2'), $cif), 0, 8) % 23, 1))
         		return 3;
      		else
         		return -3;
		//si todavia no se ha verificado devuelve error
   		return 0;
	}

}