<h1>TEST d'array</h1>
<?php
/*
 * a l'initialisation de IteratorIterator, le curseur est à la fin. Il faut alors le rewind avant de pouvoir parcourir
 * Cependant il semble que le rewind ne fonctionne qu'une fois ...
 */



$tablo = array(
            1=>'a',
            2=>2,
            3=>array('I','II','III'),
            4=>array('XI','XII','XIII')
        );


  if(  $tablo instanceof Traversable )
      echo '<p>tablo est transversable</p>';
  else 
    echo '<p>tablo pas transversable</p>';

class Tablo extends {
    
    public function current() {
        return ;
    }
     
    public function __construct($tablo) {
        parent::__construct($iterator);
    }
   public function __construct() {
        
    }
   
}

  
  /*
///$tablo->rewind();
$tablo = array(
            1=>'a',
            2=>2,
            3=>array('I','II','III'),
            4=>array('XI','XII','XIII')
        );

$Tablo = new Tablo($tablo);
$Tablo->rewind();

var_dump($Tablo);


*/