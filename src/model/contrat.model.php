<?php
class Contrat {
    private $db;
  
    /**
     * Constructeur de la classe Prospect.
     *
     * @param mixed $db L'objet de connexion à la base de données.
     */
    public function __construct($db) {
        $this->db = $db;
    }


       /**
     * Sélectionne toutes les données d'une table donnée.
     * 
     * @param string $tablename Le nom de la table à interroger.
     * @return mixed Résultat de la requête SQL.
     */
    public function selectdata($tablename) {
        $sql = "SELECT * FROM $tablename";
        $resql = $this->db->query($sql);       
        return $resql;
    }
   
    /**
     * Récupère les données à partir du résultat de la requête SQL.
     * 
     * @param mixed $resql Le résultat de la requête SQL.
     * @return array Les données récupérées sous forme de tableau.
     */
    public function returndata($resql) {
        $data = [];

        if ($resql) {
            $num = $resql->num_rows;
          

            while ($row = $resql->fetch_assoc()) {
                array_push($data, $row);
            }

            $resql->free_result();
        }

        return $data;
    }


    /**
     * Charge les données d'une table spécifiée.
     * 
     * @param string $tablename Le nom de la table à charger.
     * @return array Les données de la table chargée.
     */
    public function load($tablename) {
        $resql = $this->selectdata($tablename);
        $rgs = $this->returndata($resql);
        return $rgs;
    }

    public function loadchamp($tablename,$champs) {
        $chaine = '';
        $chaine .= $champs[0];
    
        foreach (array_slice($champs, 1) as $champ) {
            $chaine .= ', ' . $champ;
        }
        $sql= "SELECT $chaine FROM $tablename";
        $resql = $this->db->query($sql);
        $rgs = $this->returndata($resql);
        return $rgs;
    }

    public function Formcontrat(){
        $data=$this->loadchamp("llx_societe",['rowid','nom']);
        return $data;
    }

    public function addcontrat($client,$date,$durée,$remarque,$contact){

            $sql="INSERT INTO aaa_contrat(client,date_c,durée,remarque,contact) VALUES( '$client','$date','$durée','$remarque','$contact')";
            if($this->db->query($sql) === TRUE) {
    
                    echo"<script language=\"javascript\">";
                    echo"alert('enregesitrer avec succès !')";
                    echo"</script>";
               
                // redréger vers la même page pour un nouveau Némuro de la demande
            print' <script language="JavaScript">
                        window.location.replace("/custom/location/views/listContrat.php");
                    </script>';
            } else {
            echo "Error: " . $sql . "<br>" . $this->db->db->db->error;
    
          
                echo"<script language=\"javascript\">";
                echo"alert('Erreur !')";
                echo"</script>";
    
            
            }
        }

    

    public function listcontrat(){
        $data=$this->load("aaa_contrat");
        return $data;
    }


    public function editform($id){
        $sql = "SELECT * FROM aaa_contrat where rowid=$id";
        $resql = $this->db->query($sql);   
        $data=$resql->fetch_assoc(); 
        return $data;

    }


    public function updatecontrat($id,$client,$durée,$contact,$remarque){
  
            if (isset($_POST['delete'])) {

                $sql= "DELETE FROM aaa_contrat  WHERE  rowid ='$id'";

  
                $resql=$this->db->query($sql);  
                if($resql){
                    echo"<script language=\"javascript\">";
                    echo"alert('email supprimer avec succès !')";
                    echo"</script>";
                }
                else{
                    echo"<script language=\"javascript\">";
                    echo"alert('Erreur !')";
                    echo"</script>";
    
                }
                print' <script language="JavaScript">
                       window.location.replace("/custom/location/views/listContrat.php"); 
                        </script>';  
                      	 			 		
            }
            

            $sql="UPDATE aaa_contrat SET client = '$client', durée='$durée' , remarque='$remarque', contact='$contact' WHERE rowid ='$id'";
            if (isset($_POST['update'])) {

                if($this->db->query($sql) === TRUE) {
      
 
                        echo"<script language=\"javascript\">";
                        echo"alert('Contrat modifié avec succès !')";
                        echo"</script>";
                    
      
                    // redréger vers la même page pour un nouveau Némuro de la demande
                   print' <script language="JavaScript">
                       window.location.replace("/custom/location/views/editContrat.php?id='.$id.'"); 
                        </script>';            
                  } else {
                    print "Error: " . $sql . "<br>".$this->db->db->db->error;
                  }
   
            
           }

        
    }



    public function addannex($id,$ref,$qte){

        $sql="INSERT INTO aaa_annex(contrat_id,reference,qte) VALUES( $id,'$ref','$qte')";
        if($this->db->query($sql) === TRUE) {

                echo"<script language=\"javascript\">";
                echo"alert('enregesitrer avec succès !')";
                echo"</script>";
           
            // redréger vers la même page pour un nouveau Némuro de la demande
        print' <script language="JavaScript">
                    window.location.replace("/custom/location/views/addannex.php?id='.$id.'");
                </script>';
        } else {
        echo "Error: " . $sql . "<br>" . $this->db->db->db->error;

      
            echo"<script language=\"javascript\">";
            echo"alert('Erreur !')";
            echo"</script>";

        
        }
    }

    public function listannex($id){
        $sql="SELECT * FROM aaa_annex where contrat_id=$id";
        $resql = $this->db->query($sql); 
        return $this->returndata($resql);
    }


    function editannexform($id){
        $sql="SELECT * FROM aaa_annex where rowid=$id";
        $resql = $this->db->query($sql);
  
        $data=$resql->fetch_assoc();  
        return $data;
    }


    function editannex($id,$seriel,$qte,$idc){
        if (isset($_POST['delete'])) {

            $sql= "DELETE FROM aaa_annex  WHERE  rowid ='$id'";


            $resql=$this->db->query($sql);  
            if($resql){
                echo"<script language=\"javascript\">";
                echo"alert('email supprimer avec succès !')";
                echo"</script>";
            }
            else{
                echo"<script language=\"javascript\">";
                echo"alert('Erreur !')";
                echo"</script>";

            }
            print' <script language="JavaScript">
                   window.location.replace("/custom/location/views/editContrat.php?id='.$idc.'"); 
                    </script>';  
                                            
        }
        

        $sql="UPDATE aaa_annex SET reference = '$seriel', qte='$qte'  WHERE rowid ='$id'";
        if (isset($_POST['update'])) {

            if($this->db->query($sql) === TRUE) {
  

                    echo"<script language=\"javascript\">";
                    echo"alert('Contrat modifié avec succès !')";
                    echo"</script>";
                
  
                // redréger vers la même page pour un nouveau Némuro de la demande
               print' <script language="JavaScript">
                   window.location.replace("/custom/location/views/editContrat.php?id='.$idc.'"); 
                    </script>';            
              } else {
                print "Error: " . $sql . "<br>".$this->db->db->db->error;
              }

        
       }



    }


    public function addmachine($id,$ref){

        $sql="INSERT INTO aaa_location(contrat_id,seriel) VALUES( $id,'$ref')";
        $sql1="UPDATE aaa_printer SET etat = 1  WHERE seriel ='$ref'";
        if($this->db->query($sql) === TRUE) {
                $this->db->query($sql1);
                echo"<script language=\"javascript\">";
                echo"alert('enregesitrer avec succès !')";
                echo"</script>";
           
            // redréger vers la même page pour un nouveau Némuro de la demande
        print' <script language="JavaScript">
                    window.location.replace("/custom/location/views/addmachine.php?id='.$id.'");
                </script>';
        } else {
        echo "Error: " . $sql . "<br>" . $this->db->db->db->error;

      
            echo"<script language=\"javascript\">";
            echo"alert('Erreur !')";
            echo"</script>";
        
        }

    }


    public function listmachine($id){
        $sql="SELECT * FROM aaa_location l , aaa_printer p where contrat_id=$id and l.seriel=p.seriel";
        $resql = $this->db->query($sql); 
        return $this->returndata($resql);
    }



    
    public function editmachine($id,$seriel,$idc){
        if (isset($_POST['delete'])) {

            $sql= "DELETE FROM aaa_location  WHERE  seriel ='$seriel'";
            $sql1="UPDATE aaa_printer SET etat = 0  WHERE seriel ='$seriel'";

            $resql=$this->db->query($sql);  
            if($resql){
                $this->db->query($sql1);
                echo"<script language=\"javascript\">";
                echo"alert('email supprimer avec succès !')";
                echo"</script>";
            }
            else{
                echo"<script language=\"javascript\">";
                echo"alert('Erreur !')";
                echo"</script>";

            }
            print' <script language="JavaScript">
                   window.location.replace("/custom/location/views/editContrat.php?id='.$idc.'"); 
                    </script>';  
                                            
        }
        




    }

    public function stock(){
        $data=$this->load("aaa_printer");
        return $data;
    }

    public function formhistory($id){
        $sql="SELECT * FROM aaa_printer where rowid=$id";
        $resql = $this->db->query($sql);
        $data=$resql->fetch_assoc();  
        return $data;
    }

    public function contrathistory($id){
        $sql="SELECT c.* from aaa_contrat c , aaa_location l , aaa_printer p where p.seriel=l.seriel and l.contrat_id=c.rowid and p.rowid=$id";
        $resql = $this->db->query($sql); 
        return $this->returndata($resql);
    }

    public function editprinter($id,$seriel,$etat,$ref){
        if (isset($_POST['delete'])) {

            $sql= "DELETE FROM aaa_printer  WHERE  rowid ='$id'";

            $resql=$this->db->query($sql);  
            if($resql){

                echo"<script language=\"javascript\">";
                echo"alert('email supprimer avec succès !')";
                echo"</script>";
            }
            else{
                echo"<script language=\"javascript\">";
                echo"alert('Erreur !')";
                echo"</script>";

            }
            print' <script language="JavaScript">
                   window.location.replace("/custom/location/views/stock.php"); 
                    </script>';  
                                            
        }
        

        $sql="UPDATE aaa_printer SET seriel = '$seriel',etat=$etat, reference='$ref'  WHERE rowid ='$id'";
        if (isset($_POST['update'])) {

            if($this->db->query($sql) === TRUE) {
  

                    echo"<script language=\"javascript\">";
                    echo"alert('Contrat modifié avec succès !')";
                    echo"</script>";
                
  
                // redréger vers la même page pour un nouveau Némuro de la demande
               print' <script language="JavaScript">
                   window.location.replace("/custom/location/views/stock.php"); 
                    </script>';            
              } else {
                print "Error: " . $sql . "<br>".$this->db->db->db->error;
              }

        
       }
        

    }


    public function addinter($idc,$date,$rmq){

        $sql="INSERT INTO aaa_intervention(contrat_id,date_i,remarque,cout) VALUES( '$idc','$date','$rmq',0)";
        if($this->db->query($sql) === TRUE) {

                echo"<script language=\"javascript\">";
                echo"alert('enregesitrer avec succès !')";
                echo"</script>";
           
            // redréger vers la même page pour un nouveau Némuro de la demande
        print' <script language="JavaScript">
                    window.location.replace("/custom/location/views/listIntervention.php");
                </script>';
        } else {
        echo "Error: " . $sql . "<br>" . $this->db->db->db->error;

      
            echo"<script language=\"javascript\">";
            echo"alert('Erreur !')";
            echo"</script>";

        
        }

    }

    public function forminer($client){

        $sql="SELECT * FROM aaa_contrat where client like '$client'";
        $resql = $this->db->query($sql); 
        return $this->returndata($resql);

    }


    public function listinter(){
        $data=$this->load("aaa_intervention");
        return $data;
    }

    public function editformint($id){
        $sql = "SELECT * FROM aaa_intervention where rowid=$id";
        $resql = $this->db->query($sql);   
        $data=$resql->fetch_assoc(); 
        $sql = "SELECT c.client FROM aaa_contrat c , aaa_intervention i where c.rowid=i.contrat_id and i.rowid=$id";
        $resql = $this->db->query($sql);   
        $data[]=$resql->fetch_assoc(); 
        return $data;

    }

    public function editinter($id,$date,$cout,$rmq){
        if (isset($_POST['delete'])) {

            $sql= "DELETE FROM aaa_intervention  WHERE  rowid ='$id'";

            $resql=$this->db->query($sql);  
            if($resql){

                echo"<script language=\"javascript\">";
                echo"alert('email supprimer avec succès !')";
                echo"</script>";
            }
            else{
                echo"<script language=\"javascript\">";
                echo"alert('Erreur !')";
                echo"</script>";

            }
            print' <script language="JavaScript">
                   window.location.replace("/custom/location/views/listIntervention.php"); 
                    </script>';  
                                            
        }
        
        $sql="UPDATE aaa_intervention SET date_i = '$date',cout=$cout, remarque='$rmq'  WHERE rowid ='$id'";
        if (isset($_POST['update'])) {

            if($this->db->query($sql) === TRUE) {
  

                    echo"<script language=\"javascript\">";
                    echo"alert('Contrat modifié avec succès !')";
                    echo"</script>";
                
  
                // redréger vers la même page pour un nouveau Némuro de la demande
               print' <script language="JavaScript">
                   window.location.replace("/custom/location/views/stock.php"); 
                    </script>';            
              } else {
                print "Error: " . $sql . "<br>".$this->db->db->db->error;
              }

        
       }
        

    }

    public function formadd_m_inter($idc){
        $sql = "SELECT * FROM aaa_location where contrat_id=$idc";
        $resql = $this->db->query($sql);   
        $data=$this->returndata($resql);
        return $data;
    }


    public function add_m_inter($idi,$seriel,$rmq,$cout,$tinter){
        $sql="INSERT INTO aaa_printer_inter(intervention_id,seriel,remarque,cout,type_inter) VALUES( '$idi','$seriel','$rmq',$cout,'$tinter')";
        if($this->db->query($sql) === TRUE) {
                echo"<script language=\"javascript\">";
                echo"alert('enregesitrer avec succès !')";
                echo"</script>";
           
  
        } else {
        echo "Error: " . $sql . "<br>" . $this->db->db->db->error;

      
            echo"<script language=\"javascript\">";
            echo"alert('Erreur !')";
            echo"</script>";

        
        }

    }

    public function listm_inter($idi){
        $sql = "SELECT * FROM aaa_printer_inter where intervention_id=$idi";
        $resql = $this->db->query($sql);   
        $data=$this->returndata($resql);
        return $data;
    }

    public function formannex(){
        $sql = "SELECT ref FROM aaa_reference ";
        $resql = $this->db->query($sql);   
        $data=$this->returndata($resql);
        return $data;
    }

    public function formmachine1($id){
        $sql = "SELECT seriel FROM aaa_printer where rowid=$id";
        $resql = $this->db->query($sql);   
        $data=$this->returndata($resql);
        return $data;
    }


    public function formmachine($ref){
        // Convert the array elements to strings and add single quotes around them
        $quotedReferences = array_map(function($ref) {
            return "'" . $ref . "'";
        }, $ref);

        // Join the elements with commas and enclose them in parentheses
        $resultString = '(' . implode(',', $quotedReferences) . ')';

        var_dump($resultString);
        $sql = "SELECT seriel FROM aaa_printer where reference in $resultString and etat=0";
        var_dump($sql);
        $resql = $this->db->query($sql);   
        $data=$this->returndata($resql);
        return $data;
    }


    public function historyinter($id){
        $sql = "SELECT pi.*, i.contrat_id FROM aaa_printer_inter pi , aaa_printer p ,aaa_intervention i where p.rowid=$id and p.seriel=pi.seriel and i.rowid=pi.intervention_id";
        $resql = $this->db->query($sql);   
        $data=$this->returndata($resql);
        return $data;
    }

    public function datacontrat($id){
        $sql = "SELECT * FROM aaa_contrat where rowid=$id";
        $resql = $this->db->query($sql);   
        $contrat=$resql->fetch_assoc(); 
        $client=$contrat['client'];
        $sql = "SELECT address,town FROM llx_societe where nom='$client'";
        $resql = $this->db->query($sql);  
        $address=$resql->fetch_assoc();
        $contrat['address']=$address['address'];
        $contrat['town']=$address['town'];
        $sql = "SELECT * FROM aaa_annex where contrat_id=$id";
        $resql = $this->db->query($sql);   
        $annex=$this->returndata($resql);
        return ['contrat'=>$contrat,'annex'=>$annex];
    }







}

    ?>