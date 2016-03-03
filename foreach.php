<?php
/* 
 * teste du fonctionnement de foreach
 * sur les Objets
 */

class Objet implements IteratorAggregate {

    public $_att1=1;
    private $_att2=2;
    public $_att3=3;

    private $_att4=4;
    
    public $_attribut_liste;
    
    public function __construct() {
        
    }

    public function getIterator(){//
       return new ArrayIterator($this->attribut_liste());
    }

    private function attribut_liste() {
    
    /*Ne peut pas fonctionné car getIterator influence foreach
             foreach ( $this as $cle => $valeur){
    echo '<p>'.$cle.' = '.$valeur.'</p>';
                if ($cle != '_attribut_liste')
                    $this->_attribut_liste[$cle] = $valeur;
            }

            return $this->_attribut_liste;*/

        $this->_attribut_liste = get_object_vars ($this);
        unset ($this->_attribut_liste['_attribut_liste']);
        return $this->_attribut_liste;

    }

}

$Objet = new Objet();

if (  $Objet instanceof Traversable )
    echo '<p>Objet est transversable</p>';
else 
    echo '<p>Objet n\'est pas transversable</p>';

$Objet->_att5 = 5;

foreach ($Objet as $cle =>$valeur) {
    echo '<p>'.$cle.' = '.$valeur.'</p>';
}

var_dump($Objet);