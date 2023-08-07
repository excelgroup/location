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

// Load Dolibarr environment

$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) {
	$res = @include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
	require_once DOL_DOCUMENT_ROOT.'/product/class/product.class.php'; //added
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

$ref = GETPOST('ref','string');
$seriel = GETPOST('seriel','string');


$data['ref']=$ref;
$data['seriel']=$seriel;

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
    
$sql="SELECT * from aaa_printer where seriel like '$seriel'";
$resql=$db->query($sql);
if($resql){
	$row=$resql->fetch_assoc();
	$rowid=$row['rowid'];
}



//edit page
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['update'])){
	
	
	$seriel = $_POST['seriel'];
    $ref = $_POST['ref'];

    $sql="UPDATE aaa_printer SET seriel = '$seriel' , reference = '$ref' WHERE `aaa_printer`.`rowid` = $rowid";
    if ( $marque !=='' || $ref !==''){
        if($db->query($sql) === TRUE) {
            // redréger vers la même page pour un nouveau Némuro de la demande
           print' <script language="JavaScript">
		   	window.location.replace("/custom/location/views/newPrinter.php?"); 
                </script>';            
          } else {
            print "Error: " . $sql . "<br>".$db->db->db->error;
          }
		}else{
        print '<div>Merci de bien remplir la référence</div>';
    }     }
	if(isset($_POST['delete'])){
		$sql= "DELETE FROM aaa_printer  WHERE `aaa_printer`.`rowid` = $rowid";
		$db->query($sql);
		print' <script language="JavaScript">
		window.location.replace("/custom/location/views/newPrinter.php?"); 
		 </script>';  
	}
}
$data['form']=$form;
$loader = new \Twig\Loader\FilesystemLoader( '../src/templates');
$twig = new \Twig\Environment($loader, [
	'debug' => true,
	'cache' => false,
]);

$twig->addExtension(new \Twig\Extension\DebugExtension());
echo $twig->render('editprinter.twig', ['DATA'=>$data]);

// add js file
print '<script src="/dolibarr/custom/maintenance/js/main.js?lang=fr_FR"></script>';
//Fin add page
// End of page

llxFooter();
$db->close();