<h1>Array > Iterator </h1>
<?php
/*
 * On ne peut itérer que sur des structures transversables et array ne l'est pas
 */

//$arr = array(0=>1,1=>'b',2=>3,3=>'d');
//$arr = array(1=>0,'b'=>'b',3=>3,'d'=>'d');
$arr = range('a','e');

//$Iterator = new IteratorIterator(new ArrayIterator($arr));
$Iterator = new ArrayIterator($arr);


echo '<h2> rewind avant de pouvoir interer</h2>';
//a l'initialisation de IteratorIterator, le curseur est à la fin. Il faut alors le rewind avant de pouvoir parcourir
//$Iterator->rewind();
var_dump($Iterator->current());

echo '<h2> Iteration avec while</h2>';
$Iterator->rewind();
while ($valeur = $Iterator->current()){
    echo $Iterator->key().' >>'.$valeur.'<br />';
    $Iterator->next();
}

echo '<h2> Iteration avec foreach</h2>';
//foreach gère automatiquement rewind et next
foreach ($Iterator as $valeur) {
    echo $Iterator->key().' >>'.$valeur.'<br />';
}
?>
<h1>Iterer depuis ArrayObjet</h1>
<?php


$Objet = new ArrayObject($arr);
var_dump($Objet[1]);

echo '<h2> Iteration avec foreach</h2>';
//il implement IteratorAggregate, on peut donc utiliser foreach
foreach ($Objet as $ligne){
    var_dump($ligne);
}
//mais pas while (car pas d'accès à next, current ...

echo '<h2> Iteration avec while</h2>';
//il faut d'abord obtenir l'iterator qui lui,  donne accès à next, current ...
$Iterator = $Objet->getIterator();
$Iterator->rewind();
while ($valeur = $Iterator->current()){
    echo $Iterator->key().' >>'.$valeur.'<br />';
    $Iterator->next();
}
