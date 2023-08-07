<?php 

class ContratController {

    public $contrat;


    /**
     * Constructeur de la classe con$contacttroller.
     *
     * @param mixed $db L'objet de connexion à la base de données.
     */
    public function __construct($db) {
        $this->contrat = new Contrat($db);
    }


    public function Form_contrat(){
        $data=$this->contrat->Formcontrat();
        return $data;
    }


    public function add_contrat() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $client = $_POST['client'];
            $date = $_POST['date'];
            $durée = $_POST['durée'];
            $remarque = $_POST['remarque'];
            $contact = $_POST['contact'];
            $this->contrat->addcontrat($client, $date, $durée, $remarque, $contact);
            
        }
    }

    public function contratlist(){
        return $this->contrat->listcontrat();
    }

    public function edit_form($id){
        return $this->contrat->editform($id);
    }

    public function update_contrat($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $client = $_POST['client'];
            $date = $_POST['date'];
            $durée = $_POST['durée'];
            $remarque = $_POST['remarque'];
            $contact = $_POST['contact'];
            $this->contrat->updatecontrat($id,$client,$durée,$contact,$remarque);

        }
    }




    public function add_annex($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $ref = $_POST['ref'];
        $qte = $_POST['qte'];
        var_dump($ref);
        $this->contrat->addannex($id,$ref,$qte);

    }
        
    }

    public function list_annex($id){
        return $this->contrat->listannex($id);
    }

    public function refs($id){
        $annex=$this->contrat->listannex($id);
        $refs=[];
        foreach($annex as $item){
            array_push($refs,$item['reference']);     
        }
        return $refs;
    }


    public function editannex_form($id){
        return $this->contrat->editannexform($id);
    }


    public function edit_annex($id,$idc){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
  

            $seriel = $_POST['ref'];
            $qte = $_POST['qte'];

            $this->contrat->editannex($id,$seriel,$qte,$idc);

        }
    }

    
    public function add_machine($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $ref = $_POST['ref'];
        $this->contrat->addmachine($id,$ref);

    }
    }

    public function list_machine($id){
        return $this->contrat->listmachine($id);
    }





    public function edit_machine($id,$idc){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
  

            $seriel = $_POST['ref'];


            $this->contrat->editmachine($id,$seriel,$idc);

        }
    }

    public function stock(){
        $data=$this->contrat->stock();
        $location=[];
        $stock=[];
        foreach($data as $item){
            if($item['etat']){
                array_push($location,$item);
            }
            else {
                array_push($stock,$item);
            }
        }
        return ['stock'=>$stock,'location'=>$location];
    }


    public function form_history($id){
        return $this->contrat->formhistory($id);
    }

    public function contrat_history($id){
        return $this->contrat->contrathistory($id);
    }

    public function edit_printer($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
  

            $seriel = $_POST['seriel'];
            $etat=isset($_POST['etat']) ? 1 : 0;
            $ref=$_POST['ref'];

            $this->contrat->editprinter($id,$seriel,$etat,$ref);

        }
    }

    public function add_inter(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (isset($_POST["contrat"])){
        $date = $_POST['date'];
        $rmq = $_POST['rmq'];
        $idc = $_POST['contrat'];
        $client = $_POST['client'];
        $this->contrat->addinter($idc,$date,$rmq);}
    }
    }

    public function from_inter(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (isset($_POST["client"])){
            $client = $_POST['client'];
            $data=$this->contrat->forminer($client);
            return $data; }
        }

        

    }

    public function list_inter(){
        return $this->contrat->listinter();
    }


    public function edit_formint($id){
        return $this->contrat->editformint($id);
    }

    public function edit_inter($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $date = $_POST['date'];
            $rmq = $_POST['rmq'];
            $cout = $_POST['cout'];
            $this->contrat->editinter($id,$date,$cout,$rmq);}
    }

    public function addform_m_inter($idc){
        return $this->contrat->formadd_m_inter($idc);
    }

    public function addm_inter($idi){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $seriel = $_POST['seriel'];
            $rmq = $_POST['rmq'];
            $cout = $_POST['cout'];
            $tinter= $_POST['tinter'];
            $this->contrat->add_m_inter($idi,$seriel,$rmq,$cout,$tinter);
    }}

    public function listinter_m($idi){
        return $this->contrat->listm_inter($idi);
    }


    public function form_annex(){
        return $this->contrat->formannex();
    }

    public function form_machine($refs){
        return $this->contrat->formmachine($refs);
    }

    public function form_machine1($id){
        return $this->contrat->formmachine1($id);
    }



    public function history_inter($id){
        return $this->contrat->historyinter($id);
    }

    public function data_contrat($id){
        return $this->contrat->datacontrat($id);
    }

}

?>