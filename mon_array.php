<?php
/* 
 * Création d'un Objet qui modifie le comportement de l'array qui lui est transmis
 * Passage de l'array par référence ce qui permet d'indifférement reset() l'array ou rewind() Mon Array
 * pour remettre le curseur au début. Il y a un seul curseur pour MonArray et pour l'array.
 * Surcharge de next() en implémentant l'interface : Iterator
 * keyString() n'affiche que les clés qui sont des strings
 * 
 * Implémentation de ArrayAccess pour accéder à l'objet[1]
 */

class MonArray implements Iterator, ArrayAccess {
    
    private $_tab = array();

    private $_pas;

    public function __construct( &$array, $pas = 1) {
        $this->set_pas($pas);
        $this->set_tab($array);
    }

    public function set_pas ($pas){

        if (is_int($pas) && $pas <=0){
            trigger_error('le pas est obligatoirement > 0 ?');
            EXIT;
        }
        else
            $this->_pas = $pas;
    }

    public function set_tab (&$array){
        if (!is_array($array)){
            trigger_error('le 1er attribut est un array ');
            EXIT;
        }
        else
            $this->_tab = &$array;
    }
//------ArrayAcces------------------
    public function offsetExists ($offset){
        return isset($this->_tab[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->_tab[$offset]) ? $this->_tab[$offset] : null;
    }
    
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->_tab[] = $value;
        } else {
            $this->_tab[$offset] = $value;
        }
    }
    
    public function offsetUnset($offset) {
        unset($this->_tab[$offset]);
    }
//------ArrayAcces------------------
    
//------Iterator------------------
    public function valid(){
        return array_key_exists(key($this->_tab), $this->_tab);
    }

    public function next(){

        if (is_int($this->_pas)){
            for ($i=1; $i<=$this->_pas; $i++) {
                    next($this->_tab);
                }
        }

        else if ($this->_pas ==='keyString'){

            next($this->_tab);

            while (!is_string(key($this->_tab)) && $this->valid()){
                next($this->_tab);
            }
        }

        return $this;
    }

    public function rewind(){
        reset($this->_tab);
        return $this;
    }

    public function key(){
        return key($this->_tab);
    }

    public function current(){
    
        if ($this->valid()){
            
            if ($this->_pas ==='keyString'){
                if (!is_string(key($this->_tab))){
                    next($this->_tab);
                    return current($this->_tab);
                }
                else
                    return current($this->_tab);
            }
            else
                return current($this->_tab);
        }

        else return NULL;
    }
    
//------Iterator------------------
}

//----------------------------------------------

//$tablo = range (1, 10);
$tablo = array(1=>1,'b'=>'b','c'=>'c',3=>3,'d'=>'d');
//$tablo = array(10=>1,20=>'b',30=>3,40=>'d');

$mon_array = new MonArray($tablo,2);

echo '<p>Accès par [indice]</p>';
echo $mon_array[0];
echo '<hr />';


echo '<p>Parcours array : tous les 2 indice</p>';
foreach($mon_array as $v){
    echo $v.'-';}
echo '<hr />';

echo '<p>on remet le curseur au debut de l\'array</p>';
reset($tablo);

echo '<p>on change le pas et ne parcour que les indices qui sont des string</p>';
$mon_array->set_pas('keyString');

while ($valeur = $mon_array->current()){
    echo $mon_array->key().'='.$valeur.'<br />';
    $mon_array->next();
}

echo '<hr />';

$mon_array->rewind();

echo '<p>On accede par next</p>';
echo $mon_array->next()->current();

echo '<p>On accede par [indice]</p>';

echo $mon_array[3];