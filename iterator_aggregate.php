<?php

/* 
 * Implémentation de IteratorAggregate, Countable
 * utilisation d'un attribut static
 * essai de travaille sur une référence de tableau = échec
 */

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

class Personne {

    protected $_nom;
    protected $_prenom;
    protected $_Description;

    public function __construct($nom,$prenom, Description $Description) {
        $this->set_nom($nom);
        $this->set_prenom($prenom);
        
        //Agrégation de Description
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

//implémentation IteratorAggregate
class Vehicule implements IteratorAggregate {
    public static $_n = 0;
    public function __construct() {
        self::$_n++;
    }

    public function nbr2vehicule() {
        return self::$_n;
    }
    
    //sera défini dans le fille
    public function getIterator(){

    }
}

//héritage de Vehicule => redefinition de getIterator
class Voiture extends Vehicule {
    protected $_listePersonnes = array();//agregation de personne
    
   
    public function ajouterPersonne(Personne $P)  {
        $this->_listePersonnes[] = $P;
        return $this;
    }
    
    public function getIterator(){
        $reference = &$this->_listePersonnes;
        return new ArrayIterator($reference);
    }
 
    public function count() {
echo 'aloa';
        $n = 0;
        while ($Objet = current($this->_listePersonnes)){
            if ($Objet->description_age()>=18)
                $n++;
            next($this->_listePersonnes);
        }
        return $n;

    }
    public function & listePersonnes() {
        $reference = $this->_listePersonnes;
        return $reference;
    }
}

$D1= new Description(18, 70);
$D2= new Description(6, 25);

$P1 = new Personne('A','aa',$D1);
$P2 = new Personne('B','bb',$D2);

$Voiture = new Voiture();
$Voiture->ajouterPersonne($P1)
        ->ajouterPersonne($P2);

        
echo '<h1>On peut verifier si un objet est transversable</h1>';
  if(  $Voiture instanceof Traversable )
      echo '<p>Voirture est transversable</p>';
  
  if(  !$P1 instanceof Traversable )
      echo '<p>Personne n\'est pas transversable</p>';
      
//echo $Voiture->nbr2vehicule();
//var_dump($Voiture);
//http://www.sitepoint.com/php-simple-object-iterators/

echo '<h1>Foreach parcour les Personnes dans la voiture</h1>';
foreach ($Voiture as $cle => $Personne){
   echo  $Personne->nom().' age : '.$Personne->description_age().'<br />';
}

echo '<h1>On peut creer un itarateur pour parcourrir voiture</h1>';

$ItAg = $Voiture->getIterator();
var_dump($ItAg->current()->nom());
$ItAg->next();
var_dump($ItAg->current()->nom());
$ItAg->next();
var_dump($ItAg->current());

$ItAg->rewind();
var_dump($ItAg->current());



/*
var_dump($ItAg->count());

var_dump($Voiture->count());

foreach ($ItAg as $Personne){
    echo $Personne->nom().''.$Personne->description_age().'<br />';
}


$listePersonne =& $Voiture->listePersonnes();
var_dump(current($listePersonne)->nom());
next($listePersonne);
var_dump(current($listePersonne)->nom());
*/
