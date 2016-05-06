<?php

class MonFilter extends FilterIterator {

    protected $_iterator;
    protected $_filtre;
    protected $_valeur;
            
    function __construct($Iterator,$filtre = NULL) {
        $this->_iterator  = $Iterator;
        $this->set_filtre($filtre);

        parent::__construct($Iterator);
    }
    
    public function set_filtre ($filtre) {
        $this->_filtre = $filtre;
    }

    public function accept() {
        
        $this->_valeur = $this->current()->getFilename();
        
        if ($this->_iterator->isDot())
            return FALSE;
        
        else if (is_string ($this->_filtre))
            return  strstr($this->_valeur,$this->_filtre);

        else
            return TRUE;
    }
    
    public function valeur() {
        return $this->_valeur;
    }
    
    public function afficher_valeur() {

        echo $this->_valeur.'<br />'.PHP_EOL;
    }
}

$DirectoryIterator = new DirectoryIterator('./rep1');

$Iterator_iterator = new MonFilter($DirectoryIterator);
?>

<style>
    
</style>
<h2>avec while</h2>

<?php
$Iterator_iterator->rewind();
while($Iterator_iterator->valid()){
    $Iterator_iterator->afficher_valeur();
    $Iterator_iterator->next();
}