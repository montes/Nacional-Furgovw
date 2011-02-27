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

require_once 'class_Nacional.php';
	
// Load Haanga template system
require_once 'Haanga.php';
Haanga::configure(array(
	'template_dir' => 'templates/',
	'cache_dir' => 'templates_compiled/',
));
	
// Init database
// settings are loaded from SMF settings file
// (it's in parent's directory)
require_once '../Settings.php';
$db = new mysqli($db_server, $db_user, $db_passwd, $db_name);
$db->query("SET NAMES utf8");

// Init SMF's SSI
require_once('../SSI.php');

// Init Nacional
if (!Nacional::init($db, $user_info)) {
	throw new Exception('Error initializing Nacional');
}
	
// Set page title
if ($_GET['menu'] == 'apuntarse') {
	$title = Nacional::getTitle();
} else {
	$title = 'Concentración Nacional Furgovw';
}
	
// Show page header
$moderator = Nacional::getModerator();
$year = date('Y');	
$vars = compact('moderator', 'year', 'title');
Haanga::Load('header.html', $vars);

if (!isset($_GET['menu']) || ($_GET['menu'] == '')) {
	Haanga::Load('index.html');
} 
	
// If the user is a moderator check if we must do any moderator task
if (Nacional::getModerator()) {
	$msg = Nacional::doModeratorTasks();
	if ($msg !== false) {
		$vars = compact('msg');
		Haanga::Load('error.html', $vars);
		return;
	}
	elseif ($_GET['menu'] == 'admin') {
	$config = Nacional::getConfig();
		$allInscriptionsArray = Nacional::getAllInscriptions();
		$vars = compact('config', 'allInscriptionsArray');
		Haanga::Load('admin_index.html', $vars);
		$msg = true;
	}
}
	
// Are we at the inscriptions menu?
if ($_GET['menu'] == 'apuntarse') {

	$vars = compact('moderator', 'year', 'title');
	Haanga::Load('inscriptions.html', $vars);
	
	if ($_POST['nacionalForm'] == 'yes') {
		Nacional::saveInscriptionDataFromPost();
	}

	if (Nacional::getError() !== false) {
		$error = Nacional::getError();
		$vars = compact('error');
		Haanga::Load('error.html', $vars);
		if (!Nacional::getModerator()) {
			return;
		}
	}
	
	$config = Nacional::getConfig();
	$data = Nacional::getInscriptionData();
	if ($config['inscriptionsOpened'] == '1' 
		&& !is_numeric($data['numpago']) 
		&& $_GET['menu'] != 'admin'
		&& (!Nacional::getModerator() && Nacional::getError() === false)) {
	
		$dates = array();		
		for ($cont = 0; $cont < 3; $cont++) {
			$dow = strftime('%A', strtotime($config['firstDay'].' +'.$cont.' DAYS'));
				
			$dates[($cont+1)]['show'] = $dow.' '.date('d/m/Y', 
				strtotime($config['firstDay'].' +'.$cont.' DAYS'));
			$dates[($cont+1)]['save']= date('Y-m-d', 
				strtotime($config['firstDay'].' +'.$cont.' DAYS')); 
		}
		
		if ($result = $db->query("SELECT * FROM vehiculos_marca ORDER BY nombre ASC")) {
			while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$vehicleBrands[] = $row;
			}
		}

		if ($result = $db->query("SELECT * FROM kedadas_paises ORDER BY pais ASC")) {
			while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$countries[] = $row;
			}
		}

		if ($result = $db->query("SELECT * FROM kedadas_provincias ORDER BY provincia ASC")) {
			while($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$counties[] = $row;
			}
		}

		$userInfo = $user_info;
		$tShirtSizes = Nacional::getTShirtsSizes();
		$vars = compact('config', 'data', 'moderator', 'year', 'userInfo',
			'dates', 'vehicleBrands', 'countries', 'counties', 'tShirtSizes');
		Haanga::Load('form.html', $vars);
	}
}	
	
Haanga::Load('footer.html');



