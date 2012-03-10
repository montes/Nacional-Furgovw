<?php
/*
 * This is an UTF-8 file
 * 
 * This file is part of the furgovw.org meeting inscription system
 * and it's used in conjunction with:
 * 
 * SMF - Simple Machines Forum - http://www.simplemachines.org
 * 
 * Inscription system working at: http://www.furgovw.org/nacional/
 * 
 * (C) Javier Montes <kalimocho@gmail.com> 
 *
 * Twitter: @mooontes
 * Web: http://mooontes.com
 * 
 * "Furgovw Meeting Inscription System" is being written to be used in furgovw.org's 
 * annual photo contest,
 * 
 * Here you can see more info about our contest: http://www.furgovw.org/calendario/
 * 
 * "Furgovw Meeting Inscription System" is licensed under GPL 2.0 
 * http://www.gnu.org/licenses/gpl-2.0.html
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * 
 */

require_once 'class_Nacional.php';
require_once 'Montes/Strings.php';
require_once 'Zend/Pdf.php';

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
if (isset($_GET['menu']) && $_GET['menu'] == 'apuntarse') {
    $title = Nacional::getTitle();
} else {
    $title = 'Concentración Nacional Furgovw';
}

// Show page header
$config = Nacional::getConfig();

if (isset($_GET['menu2']))
    $config['menu2'] = $_GET['menu2'];
else 
    $config['menu2'] = '';

$moderator = Nacional::getModerator();
$year = date('Y');

if (!isset($_GET['ajax'])) {
    include 'templates/header.php';
}

if ((!isset($_GET['ajax']) 
    && !isset($_GET['edita'])) 
    && (!isset($_GET['menu']) 
    || ($_GET['menu'] == ''))
) {
    include 'templates/index.php';
}

// If the user is a moderator check if we must do any moderator task
// or if he wants to see admin menu
if ($moderator) {	
    if (isset($_GET['ajax']) && $_GET['ajax'] != '') {
        echo Nacional::ajax($_GET['ajax'], $_GET['op']);
        return;
    } else {		
        $msg = Nacional::doModeratorTasks();
        if ($msg !== false) {
            $error = $msg;
            include 'templates/error.php';
        } elseif (isset($_GET['menu']) && $_GET['menu'] == 'admin') {
            $config = Nacional::getConfig();
            $allInscriptionsArray = Nacional::getAllInscriptions();
            $tShirtStats = Nacional::getTshirtStats();
            $totalPaidTShirts = $tShirtStats['paidTShirts'];
            $totalPaidExtraTShirts = $tShirtStats['paidExtraTShirts'];
            $totalNotPaidTShirts = $tShirtStats['notPaidTShirts'];
            $paidSizes = $tShirtStats['paidSizes'];
            $notPaidSizes = $tShirtStats['notPaidSizes'];
            $paidInscriptions = $tShirtStats['paidInscriptions'];

            include('templates/admin_index.php');
            $msg = true;
        }
    }
}

if (isset($_GET['menu']) && $_GET['menu'] == 'historia') {
    include 'templates/history.php';
} elseif (isset($_GET['menu']) && $_GET['menu'] == 'estadisticas') {
    $allInscriptionsArray = Nacional::getAllInscriptions();
    $statistics = Nacional::getStatistics();

    if ($allInscriptionsArray && $statistics) {
        include('templates/stats.php');
    } 
// Are we at the inscriptions menu?
} elseif ((isset($_GET['menu']) && $_GET['menu'] == 'apuntarse') || (isset($_GET['edita']) && is_numeric($_GET['edita']))) {

    include('templates/inscriptions.php');

    if (isset($_POST['nacionalForm']) && $_POST['nacionalForm'] == 'yes') {
        Nacional::saveInscriptionDataFromPost();
    }

    if (!isset($_GET['edita']) || !is_numeric($_GET['edita'])) {
        if (Nacional::getError() !== false) {
            $error = Nacional::getError();
            
            include 'templates/error.php';
        }
    }

    $config = Nacional::getConfig();
    $data = Nacional::getInscriptionData();

    //Last checks before show inscription's form
    if (($config['inscriptionsOpened'] == '1' 
        && (!isset($data['numpago']) || !is_numeric($data['numpago']))
        && ($moderator || !isset($error)))
        ||
        ($moderator && isset($_GET['edita']) && is_numeric($_GET['edita']))) {

        $dates = array();		
        for ($cont = 0; $cont < 3; $cont++) {
            $dow = strftime('%A', strtotime($config['firstDay'].' +
                '.$cont.' DAYS'));

            $dates[($cont+1)]['show'] = strftime('%A %e de %B del %G', strtotime($config['firstDay'].' +'.$cont.' DAYS'));

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

        if (isset($_GET['edita']) && is_numeric($_GET['edita'])) {
            $data['edita'] = $_GET['edita'];
        }

        $userInfo = $user_info;
        $tShirtSizes = Nacional::getTShirtsSizes();

        include('templates/form.php');
    }
}

//Fix utf member's nick bug
$db->query("UPDATE fnacional n JOIN smf_members m ".
    "ON n.idmember = m.id_member SET n.nick = m.real_name ");

include 'templates/footer.php';



