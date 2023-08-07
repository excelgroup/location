<?php
// (A) LOAD LIBRARY

require "connect.php";



// (B) GET Référence

$id = $_POST["id"];

if($_GET['column']=='category'){

    $cat = $_CAT->getoption($id,"soucateg","aaa_soucateg","category_id");

}elseif($_GET['column']=='region'){
   
    $cat = $_CAT->getoption($id,"ville","aaa_ville","region_id");    
}

// (C) OUTPUT
echo json_encode($cat);
?>