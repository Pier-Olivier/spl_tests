<?php

/* 
 * Implémentation de IteratorAggregate, Countable
 * utilisation d'un attribut static
 * essai de travaille sur une référence de tableau = échec
 */

class Personne {

    protected $_nom;
    protected $_prenom;
    protected $_Description;

    public function __construct($nom,$prenom, Description $Description) {
        $this->set_nom($nom);
        $this->set_prenom($prenom);
        $this->set_Description($Description);
    }

    public function set_Description(Description $Description)  {
        $this->_Description = $Description;
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
    
    public function description_age() {
        return $this->_Description->age();
    }
}

class Description {
    
    protected $_age;
    protected $_poids;

    public function __construct($age, $poids) {
        $this->set_age($age);
        $this->set_poids($poids);
    }
    
    public function set_age($age) {
        $this->_age = $age;
    }

    public function age() {
        return $this->_age;
    }
    
    public function set_poids($poids) {
        $this->_poids = $poids;
    }
}

class Vehicule {
    public static $_n = 0;
    public function __construct() {
        self::$_n++;
    }

    public function nbr2vehicule() {
        return self::$_n;
    }
}

class Voiture extends Vehicule implements IteratorAggregate, Countable {
    protected $_personnes = array();
    
    public function ajouter(Personne $p)  {
        $this->_personnes[] = $p;
        return $this;
    }
    
    public function getIterator(){
        $reference = &$this->_personnes;
        return new ArrayIterator($reference);
    }
 
    public function count() {
        $n = 0;
        while ($Objet = current($this->_personnes)){
            if ($Objet->description_age()>=18)
                $n++;
            next($this->_personnes);
        }
        return $n;

    }
    public function & personne() {
        $reference = &$this->_personnes;
        return $reference;
    }
}

$D1= new Description(18, 70);
$D2= new Description(6, 25);

$P1 = new Personne('A','aa',$D1);
$P2 = new Personne('B','bb',$D2);

$Voiture = new Voiture();
$Voiture->ajouter($P1)
        ->ajouter($P2);

//echo $Voiture->nbr2vehicule();
//var_dump($Voiture->getIterator());

$ItAg = $Voiture->getIterator();
var_dump($ItAg->current()->nom());
$ItAg->next();
var_dump($ItAg->current()->nom());
$ItAg->next();
var_dump($ItAg->current());

var_dump($ItAg->count());

var_dump($Voiture->count());


foreach ($ItAg as $Personne){
    echo $Personne->nom().''.$Personne->description_age().'<br />';
}

$listePersonne = $Voiture->personne();
var_dump(current($listePersonne)->nom());
next($listePersonne);
var_dump(current($listePersonne)->nom());

