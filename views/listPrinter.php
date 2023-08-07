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


// Form 
print '<form id="sample_form" action="" method="POST">';
print '<table class="centpercent notopnoleftnoright table-fiche-title>';
print '<tbody>';
print '<tr class="titre">';
print '<td class="nobordernopadding widthpictotitle valignmiddle col-picto">';
print '<span class="fas fa-cube valignmiddle widthpictotitle pictotitle" style=" color: #a69944;"></span>';
print '</td>';
print '<td class="nobordernopadding valignmiddle col-title">';
print load_fiche_titre($langs->trans("Référence"), '', 'maintenance.png@maintenance');
print '</td>';
print '</tr>';
print '<tbody>';
print '</table>';
print '<div class="tabBar tabBarWithBottom">';
print '<table class="border centpercent">';
print '<tbody>';
//// Marque feild
print '<tr>';
print '<td class="titlefieldcreate fieldrequired">Marque</td>';
print '<td>';
print '<span class="fas fa-building" style=" color: #6c6aa8;"></span>';
print '<select name="marque" id="marque" class="flat statut form_data">';
$sql= "SELECT * FROM `aaa_marque`";
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
                print '<option value="'.$row['rowid'].'">'.$row['marque'].'</option>';
				$i++;
			}

			$db->free($resql);
		} else {
			print '<tr class="oddeven"><td colspan="3" class="opacitymedium">'.$langs->trans("None").'</td></tr>';
		}
	}
    
print "</select>"; 
print '</td>';
print '</tr>';
//// USB feild
    
//// reference printer feild

print '<tr>';
print '<td class="titlefieldcreate fieldrequired">Référence</td>';
print '<td>';
print '<input id="ref" name="ref" class="maxwidth200 form_data" maxlength="128" value="">';
print '</td>';
print '</tr>';
///////
// save buttuns

print '<tbody>';
print '</table>';
print '</div>';

print '<div class="center">';
print '<input type="submit" id="submit" class="button button-save"  value="'.$langs->trans("Save").'"onclick="save_data(); return false;">';
print '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
print '<input type="submit" class="button button-cancel" name="cancel" value="'.$langs->trans("Cancel").'"">';
print '</div>';

// Fin form

print '</form>';

//add page

$dsn ="mysql:host=localhost;dbname=dolibarr";
$user = "abdessamad";
$pass = "s112233";
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try {
        $con = new PDO($dsn,$user,$pass,$option);
        $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $marque = $_POST['marque'];
        $ref = $_POST['ref'];
        $sql="INSERT INTO aaa_reference(marque_id, ref) VALUES(?, ?) ";
        $stmt= $con->prepare($sql);
        $stmt->execute([$marque ,$ref]);  
    }
    catch(PDOException $e){
        echo '<div style="background:red;color:white">FAILD TO Connect :'.$e->getMessage().'</div>';
    }
}
// list marque

$sql= "SELECT ref,marque FROM aaa_reference INNER JOIN aaa_marque ON aaa_reference.marque_id=aaa_marque.rowid";
$resql = $db->query($sql);
$num = $db->num_rows($resql);
if ($resql)
	{
		$num = $db->num_rows($resql);
		$i = 0;
		print '<table class="noborder centpercent">';
		print '<tr class="liste_titre">';		
		print '<th>Marque</th>';
        print '<th>Référence</th>';
		print '</tr>';
		if ($num)
		{
			while ($i < $num)
			{
				$row = $resql->fetch_assoc();

				print '<tr class="oddeven">';
				print '<td class="nowrap">'.$row['marque'].'</td>';
                print '<td class="nowrap"><a href="/dolibarr/custom/maintenance/views/editRef.php?ref='.$row["ref"].'&marque='.$row["marque"].'">'.$row["ref"].'</a></td>';			
				print '</tr>';
				$i++;
			}

			$db->free($resql);
		} else {
			print '<tr class="oddeven"><td colspan="3" class="opacitymedium">'.$langs->trans("None").'</td></tr>';
		}
		print "</table><br>";        
	}


// add js file
print '<script src="/dolibarr/custom/maintenance/js/main.js?lang=fr_FR"></script>';

// End of page


llxFooter();
$db->close();
