<?php
/* Copyright (C) 2001-2005 Rodolphe Quiedeville <rodolphe@quiedeville.org>
 * Copyright (C) 2004-2015 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) 2005-2012 Regis Houssin        <regis.houssin@inodbox.com>
 * Copyright (C) 2015      Jean-François Ferry	<jfefe@aternatik.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 *	\file       maintenance/maintenanceindex.php
 *	\ingroup    maintenance
 *	\brief      Home page of maintenance top menu
 */

use Luracast\Restler\Data\Arr;

// Load Dolibarr environment

$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) {
	$res = @include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
}

// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp = empty($_SERVER['SCRIPT_FILENAME']) ? '' : $_SERVER['SCRIPT_FILENAME']; $tmp2 = realpath(__FILE__); $i = strlen($tmp) - 1; $j = strlen($tmp2) - 1;
while ($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i] == $tmp2[$j]) {
	$i--; $j--;
}
if (!$res && $i > 0 && file_exists(substr($tmp, 0, ($i + 1))."/main.inc.php")) {
	$res = @include substr($tmp, 0, ($i + 1))."/main.inc.php";
}
if (!$res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php")) {
	$res = @include dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php";
}
// Try main.inc.php using relative path
if (!$res && file_exists("../main.inc.php")) {
	$res = @include "../main.inc.php";
}
if (!$res && file_exists("../../main.inc.php")) {
	$res = @include "../../main.inc.php";
}
if (!$res && file_exists("../../../main.inc.php")) {
	$res = @include "../../../main.inc.php";
}
if (!$res) {
	die("Include of main fails");
}

require_once DOL_DOCUMENT_ROOT.'/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT.'/core/class/html.formcategory.class.php';
require '../vendor/autoload.php';
use Twig\Environment;
// Load translation files required by the page
$langs->loadLangs(array("maintenance@maintenance"));

$action = GETPOST('action', 'aZ09');


// Security check
// if (! $user->rights->maintenance->myobject->read) {
// 	accessforbidden();
// }
$socid = GETPOST('socid', 'int');
if (isset($user->socid) && $user->socid > 0) {
	$action = '';
	$socid = $user->socid;
}

$max = 5;
$now = dol_now();


/*
 * Actions
 */

// None


/*
 * View
 */

$form = new Form($db);
$formfile = new FormFile($db);

llxHeader("", $langs->trans("MaintenanceArea"));



print load_fiche_titre($langs->trans("Référence"), '', 'maintenance.png@maintenance');
$form=[];
$sql= "SELECT ref FROM aaa_reference";
$resql = $db->query($sql);
$num = $db->num_rows($resql);
if ($resql)
	{
		$num = $db->num_rows($resql);
        var_dump($num);
		$i = 0;		
		if ($num)
		{
            
			while ($i < $num)
			{
				$row = $resql->fetch_assoc();               
                array_push($form,$row);
				$i++;
			}

			$db->free($resql);
		} else {
			print '<tr class="oddeven"><td colspan="3" class="opacitymedium">'.$langs->trans("None").'</td></tr>';
		}
	}
    







if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['update'])){
        $seriel = $_POST['seriel'];
        $ref = $_POST['ref'];
        $sql="INSERT INTO aaa_printer(seriel, reference,etat) VALUES('$seriel', '$ref',0) ";
		$db->query($sql);
		print' <script language="JavaScript">
		window.location.replace("/custom/location/views/newPrinter.php?"); 
		 </script>'; }	


}
// list marque
$list=[];
$sql= "SELECT * FROM aaa_printer ";
$resql = $db->query($sql);
$num = $db->num_rows($resql);
if ($resql)
	{
		$num = $db->num_rows($resql);
		$i = 0;

		if ($num)
		{
			while ($i < $num)
			{
				$row = $resql->fetch_assoc();
				array_push($list,$row);

				$i++;
			}

			$db->free($resql);
		} else {
			print '<tr class="oddeven"><td colspan="3" class="opacitymedium">'.$langs->trans("None").'</td></tr>';
		}
	        
	}

$data=['list'=>$list,'form'=>$form];
// add js file
print '<script src="/dolibarr/custom/maintenance/js/main.js?lang=fr_FR"></script>';

// End of page
$loader = new \Twig\Loader\FilesystemLoader( '../src/templates');
$twig = new \Twig\Environment($loader, [
	'debug' => true,
	'cache' => false,
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
echo $twig->render('newPrinter.twig', ['DATA'=>$data]);

llxFooter();
$db->close();
