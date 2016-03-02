<?php
/* 
 * teste du fonctionnement de foreach
 * sur les Objets
 */

class Objet implements IteratorAggregate {

    public $_att1=1;
    private $_att2=2;
    public $_att3=3;

    public $_attribut_liste;
    
    public function __construct() {
        $this->attribut_liste();
    }

    public function getIterator(){//

       //$reference = &$this->_listePersonnes;
       //return new ArrayIterator($reference);
        //return new ArrayIterator($this->_attribut_liste);
        return new ArrayIterator(array('a','b','c'));
    }

    public function attribut_liste() {
        foreach ( $this as $cle => $valeur){
echo '<p>'.$cle.' = '.$valeur.'</p>';
            if ($cle != '_attribut_liste')
                $this->_attribut_liste[$cle] = $valeur;
        }

        return $this->_attribut_liste;
    }
}
$Objet = new Objet();


foreach ($Objet as $cle =>$valeur) {
    echo '<p>'.$cle.' = '.$valeur.'</p>';
}

//var_dump($Objet->attribut_liste()->_attribut_liste);
foreach ($Objet->attribut_liste() as $cle => $valeur){
    echo '<p>'.$cle.' = '.$valeur.'</p>';
}