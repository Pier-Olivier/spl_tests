<?php

/* 
 * 
 */

class Personne {

    protected $_nom;
    protected $_prenom;

    public function __construct($nom,$prenom) {
        $this->set_nom($nom);
        $this->set_prenom($prenom);

    }

    public function set_nom($nom)  {
        $this->_nom = $nom;
    }

    public function set_prenom($prenom)  {
        $this->_prenom = $prenom;
    }
    
    public function nom(){
        return $this->_nom;
    }
    
    public function prenom(){
        return $this->_prenom;
    }
}

class Vehicule {
    public static $_n;
    public function __construct() {
        self::$_n = 0;
        self::$_n++;
        echo '<h2>'.self::$_n.'</h2>';
    }
    
}

class Voiture extends Vehicule implements IteratorAggregate {
    protected $_personnes = array();
    
    public function ajouter(Personne $p)  {
        $this->_personnes[] = $p;
    }
    
    public function getIterator()
    {
        return new ArrayIterator($this->_personnes);
    }
}

$P1 = new Personne('A','aa');
$P2 = new Personne('B','bb');

$Voiture = new Voiture();
$Voiture->ajouter($P1);
$Voiture->ajouter($P2);

//var_dump($Voiture->getIterator());

foreach ($Voiture->getIterator() as $Objet){
    echo $Objet->nom().'<br />';
}

 