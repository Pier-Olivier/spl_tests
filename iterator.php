<?php
/* 
 * Surcharge de next() en implémentant l'interface : Iterator
 * passe de l'array par référence qui permet de reset l'array ou de rewind Mon Array
 * pour remettre le curseur au début
 * keyString n'affique que les clés qui sont des strings
 */

class MonArray implements Iterator {
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
}

//----------------------------------------------

//$tablo = range (1, 10);
$tablo = array(1=>1,'b'=>'b','c'=>'c',3=>3,'d'=>'d');
//$tablo = array(10=>1,20=>'b',30=>3,40=>'d');

$mon_array = new MonArray($tablo,2);

foreach($mon_array as $v){ echo $v.'-';}
echo '<hr />';

reset($tablo);

$mon_array->set_pas('keyString');

while ($valeur = $mon_array->current()){
    echo $mon_array->key().'='.$valeur.'<br />';
    $mon_array->next();
}

echo '<hr />';

$mon_array->rewind();
echo $mon_array->next()->current();