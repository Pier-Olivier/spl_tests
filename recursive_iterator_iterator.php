<?php

class MonRecursiveIteratorIterator extends RecursiveIteratorIterator {
    
    protected $_numeroNiveau2 = 1;
    protected $_numeroNiveau3 = 'A';


    function beginChildren() {
 
        echo '<div class="niveau'.$this->getDepth().'">';
        if (2===$this->getDepth())
            echo $this->_numeroNiveau2++;
        else if (3===$this->getDepth())
            echo $this->_numeroNiveau3++;
        
            echo '] - ';
    }
    
    function endChildren() {
        echo "</div>\n";
    }
}

?>
<style>
    .niveau1{
        color: green;
        margin-left: 0;
    }

    .niveau2{
        color: blue;
        margin-left: 30;
    }

    .niveau3{
        color: red;
        margin-left: 90;
    }

    .niveau4{
        margin-left: 110;
    }
</style>
<?php

$arr = array(
        array(
            "X SARL"
        ),
        array(
            array("Ressources humaines",array("Alain","Michel","Julie")),
            array("Service comptable",array(" Matthieu","Marc","Luc","Jean")),
            array("Service commercial",array("Anne","Sophie","Boby"))
        )
    );


$iter = new RecursiveArrayIterator($arr);
$iterIter = new MonRecursiveIteratorIterator($iter);


$numeroNiveau1 = 0;

while ($iterIter->current() !== NULL){

    $iterIter->next();
    
    echo $iterIter->current().' ('.$iterIter->getDepth().')'."<br />\n";
}

 

 class Company_Iterator extends RecursiveIteratorIterator {
    function beginChildren() {
        if ($this->getDepth() >= 3) {
        echo str_repeat("\t", $this->getDepth() - 1);
        echo "<ul>" . PHP_EOL;
        }
    }
    function endChildren() {
        if ($this->getDepth() >= 3) {
            echo str_repeat("\t", $this->getDepth() - 1);
            echo "</ul>" . PHP_EOL;
        }
    }
}

class RecursiveArrayObject extends ArrayObject {
    function getIterator() {
        return new RecursiveArrayIterator($this);
    }
}

$company = array(
        array(
            "X SARL"
        ),
        array(
            array("Ressources humaines",array("Alain","Michel","Julie")),
            array("Service comptable",array(" Matthieu","Marc","Luc","Jean")),  
            array("Service commercial",array("Anne","Sophie","Boby"))
        )
    );

$it = new Company_Iterator(new RecursiveArrayObject($company));
$in_list = false;
//RecursiveArrayIterator
foreach ($it as $item) {
    echo str_repeat("\t", $it->getDepth());
    switch ($it->getDepth()) {
    case 1: echo "<h1>Company: $item</h1>" . PHP_EOL;
    break;
    case 2: echo "<h2>Department: $item</h2>" . PHP_EOL;
    break;
    default: echo "<li>$item</li>" . PHP_EOL;
    }
}


 
 