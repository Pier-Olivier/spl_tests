<?php
/*
 * a l'initialisation de IteratorIterator, le curseur est à la fin. Il faut alors le rewind avant de pouvoir parcourir
 * quand on redefinit rewind() dans FilterIterator, cela empèche de fonctionner accept()
 * D'où la création de la calss PDOIterator qui permet de modifier la façon dont le tableau est parcouru grace à current()
 * 
 * 
 * SQL pour l'exemple :
* ***************************************** 
CREATE TABLE IF NOT EXISTS `liste2teste` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `valeur` int(11) NOT NULL,
  `nom` varchar(10) NOT NULL,
  `description` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `liste2teste`
--

INSERT INTO `liste2teste` (`id`, `valeur`, `nom`, `description`) VALUES
(1, 11, 'A', 'a'),
(2, 22, 'B', 'bb'),
(3, 33, 'C', 'ccc'),
(4, 44, 'D', 'dddd'),
(5, 55, 'E', 'eeeee');
 * *****************************************
 * 
 */


class PDOIterator extends ArrayIterator {
    
    protected $_array;
    protected $_champ;

    
    public function __construct($array,$champ) {
        $this->_array = $array;
        $this->set_champs($champ);
    }
    
    public function current() {
        return current($this->_array)[$this->_champ];
    }
    
    public function set_champs($champ) {
        $this->_champ = $champ;
    }
    
    public function next() {
        next($this->_array);
    }
    
    public function key () {
        return key($this->_array);
    }
 
    public function valid () {
        //return in_array($this->key(), $this->_iterator);
        return isset (current($this->_array)[$this->_champ]);
    }

    public function rewind() {
        reset($this->_array);
    }

}

class PDOFilter extends FilterIterator {
    const PAIR = 1;
    const IMPAIR = 2;

    protected $_iterator;
    protected $_filtre;

    function __construct($Iterator,$filtre = self::PAIR) {
        $this->_iterator  = $Iterator;
        $this->set_filtre($filtre);
        parent::__construct($Iterator);
    }
    
    public function set_filtre ($filtre) {
        $this->_filtre = $filtre;
    }

    public function accept() {

        if ($this->_filtre === self::PAIR) {
            return ($this->current() % 2 === 0);
        }
        else if ($this->_filtre === self::IMPAIR){
            return ($this->current() % 2 === 1);
        }
        else if ($this->_filtre === NULL){
            return TRUE;
        }
        else if (is_string ($this->_filtre)){
            return  strstr($this->current(),$this->_filtre);
        }        
    }
}

echo '<h1>Importation des infos de la base</h1>';
$Pdo  = new PDO('mysql:host=localhost; dbname=test', 'root', '');
$Resultat = $Pdo->query('SELECT * FROM liste2teste ');
$liste = $Resultat->fetchAll(PDO::FETCH_ASSOC);
var_dump($liste);

echo '<h1>Filtre des infos dont valeur est impair</h1>';

$Iterator = new PDOIterator($liste,'valeur');
$Iterator_iterator = new PDOFilter($Iterator,PDOFilter::IMPAIR);

echo '<h2>avec foreach</h2>';
foreach ($Iterator_iterator as $number) {
var_dump($number);
}

echo '<h2>avec while</h2>';
$Iterator_iterator->rewind();
while ($entre = $Iterator_iterator->current()){
    var_dump($entre);
    $Iterator_iterator->next();
}

echo '<h1>Filtre des infos dont description comporte c</h1>';
$Iterator->set_champs('description');
$Iterator_iterator->set_filtre('c');

echo '<h2>avec while</h2>';
$Iterator_iterator->rewind();
while ($entre = $Iterator_iterator->current()){
    var_dump($entre);
    $Iterator_iterator->next();
}