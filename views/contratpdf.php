<?php
require_once '../vendor/autoload.php'; // Inclure l'autoloader de Twig

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
require "../src/controller/contrat.controller.php";
require "../src/model/contrat.model.php";


$form = new Form($db);
$formfile = new FormFile($db);

$idc = GETPOST('idc', 'int');





$contrat=new ContratController($db);

$data=$contrat->data_contrat($idc);












use Dompdf\Dompdf;
use Dompdf\Options;

$loader = new \Twig\Loader\FilesystemLoader('../src/pdftemplate');
$twig = new \Twig\Environment($loader, ['cache' => false]);

$template = $twig->load('contrat.twig'); // Charger votre fichier Twig

$html = $template->render(['data'=>$data]); // Générer le contenu HTML à partir du modèle Twig



// Créer une instance Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true); // Autoriser le chargement des ressources distantes (images, CSS, etc.)
$dompdf = new Dompdf($options);

// Charger le contenu HTML dans Dompdf
$dompdf->loadHtml($html);
// Charger le contenu HTML dans Dompdf
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');


$dompdf->getOptions()->setIsRemoteEnabled(true);
$dompdf->getOptions()->setChroot('');

// Rendre le contenu HTML en PDF
$dompdf->render();

// Envoyer le PDF généré au navigateur
$dompdf->stream('output.pdf', ['Attachment' => false]);
?>