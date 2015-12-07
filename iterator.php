<?php
/* 
 * Surcharge de next() en implémentant l'interface : Iterator
 * passe de l'array par référence qui permet de reset l'array ou de rewind Mon Array
 * pour remettre le curseur au début
 */

class MonArray implements Iterator {
    private $_tab = array();

    private $_pas;

    public function __construct( &$array, $pas = 1) {
        $this->set_pas($pas);
        $this->set_tab($array);
    }

    public function set_pas ($pas){

        if (is_int($this->_pas) && $pas <=0){
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

    public function valid(){
        return array_key_exists(key($this->_tab), $this->_tab);
    }

    public function next(){

        if (is_int($this->_pas)){
            for ($i=1; $i<=$this->_pas; $i++) {
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
        return current($this->_tab);
    }
}

//----------------------------------------------

//$tablo = range (1, 10);
$tablo = array(1=>1,'b'=>'b',3=>3,'d'=>'d');
//$tablo = array(10=>1,20=>'b',30=>3,40=>'d');

$mon_array = new MonArray($tablo, 1);

foreach($mon_array as $v){ echo $v.'-';}
echo '<hr />';

reset($tablo);
$mon_array->set_pas(2);

while ($valeur = $mon_array->current()){
    echo $mon_array->key().'='.$valeur.'<br />';
    $mon_array->next();
}

//echo $mon_array->next()->current();

echo '<hr />';