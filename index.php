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

/* 
** Init database
** settings are loaded from SMF settings file
** (it's in parent directory)
*/
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
$config = Nacional::getConfig();
$config['menu2'] = $_GET['menu2'];
$moderator = Nacional::getModerator();
$year = date('Y');
$vars = compact('moderator', 'year', 'title', 'config');
if (!isset($_GET['ajax'])) {
    Haanga::Load('header.html', $vars);
}

if ((!isset($_GET['ajax']) 
    && !is_numeric($_GET['edita'])) 
    && (!isset($_GET['menu']) 
    || ($_GET['menu'] == ''))
) {
    Haanga::Load('index.html');
}

// If the user is a moderator check if we must do any moderator task
// or if he wants to see admin menu
if ($moderator) {	
    if ($_GET['ajax'] != '') {
        echo Nacional::ajax($_GET['ajax'], $_GET['op']);
        return;
    } else {		
        $msg = Nacional::doModeratorTasks();
        if ($msg !== false) {
            $vars = compact('msg');
            Haanga::Load('error.html', $vars);		
        } elseif ($_GET['menu'] == 'admin') {
            $config = Nacional::getConfig();
            $allInscriptionsArray = Nacional::getAllInscriptions();
            $tShirtStats = Nacional::getTshirtStats();
            $totalPaidTShirts = $tShirtStats['paidTShirts'];
            $totalPaidExtraTShirts = $tShirtStats['paidExtraTShirts'];
            $totalNotPaidTShirts = $tShirtStats['notPaidTShirts'];
            $paidSizes = $tShirtStats['paidSizes'];
            $notPaidSizes = $tShirtStats['notPaidSizes'];
            $paidInscriptions = $tShirtStats['paidInscriptions'];
            $vars = compact('config', 'allInscriptionsArray', 
                            'totalPaidTShirts', 'totalPaidExtraTShirts',
                            'totalNotPaidTShirts', 'paidInscriptions',
                            'paidSizes', 'notPaidSizes');
            Haanga::Load('admin_index.html', $vars);
            $msg = true;
        }
    }
}

if ($_GET['menu'] == 'historia') {
    Haanga::Load('history.html');
} elseif ($_GET['menu'] == 'estadisticas') {
    $allInscriptionsArray = Nacional::getAllInscriptions();
    $statistics = Nacional::getStatistics();
    $vars = compact('config', 'allInscriptionsArray', 'statistics');
    Haanga::Load('stats.html', $vars);
// Are we at the inscriptions menu?
} elseif ($_GET['menu'] == 'apuntarse' || is_numeric($_GET['edita'])) {
    $vars = compact('moderator', 'year', 'title');
    Haanga::Load('inscriptions.html', $vars);

    if ($_POST['nacionalForm'] == 'yes') {
        Nacional::saveInscriptionDataFromPost();
    }

    if (!is_numeric($_GET['edita'])) {
        if (Nacional::getError() !== false) {
            $error = Nacional::getError();
            $vars = compact('error');
            Haanga::Load('error.html', $vars);
        }
    }

    $config = Nacional::getConfig();
    $data = Nacional::getInscriptionData();

    //Last checks before show inscription's form
    if (($config['inscriptionsOpened'] == '1' 
        && (!is_numeric($data['numpago'])) 
        && ($moderator || !isset($error)))
        ||
        ($moderator && is_numeric($_GET['edita']))) {

        $dates = array();		
        for ($cont = 0; $cont < 3; $cont++) {
            $dow = strftime('%A', strtotime($config['firstDay'].' +
                '.$cont.' DAYS'));

            $dates[($cont+1)]['show'] = $dow.' '.date('d/m/Y',
                strtotime($config['firstDay'].' +'.$cont.' DAYS'));
            $dates[($cont+1)]['save']= date('Y-m-d', 
                strtotime($config['firstDay'].' +'.$cont.' DAYS')); 
        }

        if ($result = 
            $db->query("SELECT * FROM vehiculos_marca ORDER BY nombre ASC")) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $vehicleBrands[] = $row;
            }
        }

        if ($result = 
            $db->query("SELECT * FROM kedadas_paises ORDER BY pais ASC")) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $countries[] = $row;
            }
        }

        if ($result = $db->query("SELECT * FROM kedadas_provincias".
              " ORDER BY provincia ASC")) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $counties[] = $row;
            }
        }

        if (is_numeric($_GET['edita'])) {
            $data['edita'] = $_GET['edita'];
        }

        $userInfo = $user_info;
        $tShirtSizes = Nacional::getTShirtsSizes();
        $vars = compact('config', 'data', 'moderator', 'year', 'userInfo',
            'dates', 'vehicleBrands', 'countries', 'counties', 'tShirtSizes');
        Haanga::Load('form.html', $vars);
    }
}

//Fix utf member's nick bug
$db->query("UPDATE fnacional n JOIN smf_members m ".
    "ON n.idmember = m.id_member SET n.nick = m.real_name ");

Haanga::Load('footer.html');



