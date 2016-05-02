<?php
/* 
 * On accède aux attributs de l'Objet grace à un foreach ($Objet as $attribut)
 * attribut_liste() compose un array avec les différents attributs de l'objet
 * !! on ajoute un attribut (att5 après le new)
 */

class Objet implements IteratorAggregate {

    public $_att1=1;
    private $_att2=2;
    public $_att3=3;

    private $_att4=4;
    
    public $_attribut_liste;

    public function getIterator(){
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
//        array_pop($this->_attribut_liste); On ne peut pas l'utiliser
// parce qu'on ajouter un attribut _att5 après le new Objet();

        unset ($this->_attribut_liste['_attribut_liste']);//pour éviter que _attribut_liste
        //soit repris dans lui-même

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

//var_dump($Objet);