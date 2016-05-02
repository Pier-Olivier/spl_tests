<?php

/* 
 * Implement Iterator auquel est ajouté 
 * une méthode : seek($index) pour retourner l'élément dont la clé est $index
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
abstract class Vehicule implements SeekableIterator {

    public static $_n = 0;

    protected $_listePersonnes = array();//agregation de personne

    public function __construct() {
        self::$_n++;
    }

    public function nbr2vehicule() {
        return self::$_n;
    }

    public function ajouterPersonne(Personne $P)  {
        $this->_listePersonnes[] = $P;
        return $this;
    }

    public function valid($index=NULL){
        if (NULL !== $index)
            return array_key_exists($index, $this->_listePersonnes);
        else
            return array_key_exists(key($this->_listePersonnes), $this->_listePersonnes);
    }

    public function next(){
        next($this->_listePersonnes);
    }

    public function rewind(){
        reset($this->_listePersonnes);
        return $this;
    }

    public function key(){//la clé de l'élément sur lequel est le curseur
        return key($this->_listePersonnes);
    }

    public function current(){
        if ($this->valid())
            return current($this->_listePersonnes);
        else
            return NULL;
    }
    
    public function seek($index) {//retourne l'élément qui a pour clé index

        if ($this->valid($index))
            return $this->_listePersonnes[$index];
        else
            return NULL;
    }
}

//héritage de Vehicule => redefinition de getIterator
class Voiture extends Vehicule {

    public function count() {//redéfinition de count pour ne compter que les personnes de + de 18 ans
echo '<p>count () ne compte que les personnes qui ont plus de 18 ans</p>';
        $n = 0;
        while ($Objet = current($this->_listePersonnes)){
            if ($Objet->description_age()>=18)
                $n++;
            next($this->_listePersonnes);
        }
        return $n;

    }
    public function listePersonnes() {
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


echo '<h1>Foreach parcour les Personnes dans la voiture</h1>';
foreach ($Voiture as $cle => $Personne){
   echo  $Personne->nom().' age : '.$Personne->description_age().'<br />';
}

echo '<h1>Acces directement a une personne de la voiture par son index</h1>';

$Voiture->rewind();
var_dump($Voiture->current());

var_dump($Voiture->seek(1));

echo '<h1>Le curseur n\'est pas deplace par seek()</h1>';
echo 'key() renvoie : </p>';
var_dump($Voiture->key());