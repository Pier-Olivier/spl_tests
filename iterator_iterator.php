<?php
$pdo  = new PDO('mysql:host=localhost; dbname=safe_gestion', 'root', '');
$stmt = $pdo->query("SELECT id_article,code_art,nom_art FROM article WHERE id_article<10");
/*
while( $rslt = $stmt->fetch()){
    var_dump($rslt);
}
*/

echo '<hr />';
$it = new IteratorIterator($stmt);
var_dump($it->getInnerIterator());

echo '<hr />';

$it->rewind();
while ($valeur = $it->current()){
    echo $valeur[0].'='.$valeur[1].'<br />';
    $it->next();
}
echo '<hr />';

//$it->rewind();
$it->next();
var_dump($it->current()[1]);

/*
echo '<hr />';
foreach ($it as $val) {
    echo $val[0].'<br />';
//    var_dump($val);
}
*/
echo '<hr />';
 
