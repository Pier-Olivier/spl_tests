<?php

class MonDI extends DirectoryIterator  {
    
    public function __construct($path) {
        parent::__construct($path);
    }
}

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
        echo '<div class="';
        if ( $this->_iterator->isFile() ){
            echo 'vert"';
        }
        else if ( $this->_iterator->isDir() ){
            echo 'bleu"';
        }

        echo '>'.$this->_valeur.'</div>'.PHP_EOL;
    }
}

?>

<style>
    .vert{ color: green; margin-left: 25px; }
    .bleu{color: blue; }
</style>
<h2>Mon Filtre avec while</h2>

<?php

$DirectoryIterator = new MonDI('./');
//print_r($DirectoryIterator);
$Iterator_iterator = new MonFilter($DirectoryIterator);

$Iterator_iterator->rewind();
while($Iterator_iterator->valid()){
    $Iterator_iterator->afficher_valeur();
    $Iterator_iterator->next();
}

echo '<h2>RegexIterator avec while</h2>';

$RegexIterator = new RegexIterator($DirectoryIterator,'#rep#');

$RegexIterator->rewind();
while ($RegexIterator->valid()){
    echo $RegexIterator->current()->getFilename().'<br />';
    $RegexIterator->next();
}

echo '<h2>RegexIterator avec foreach</h2>';

foreach ($RegexIterator as $Resultat){
    echo $Resultat.'<br />';
}