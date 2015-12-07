<?php
$pdo  = new PDO('mysql:host=localhost; dbname=safe_gestion', 'root', '');
$stmt = $pdo->query("SELECT id_article,code_art,nom_art FROM article WHERE id_article<10");

while( $rslt = $stmt->fetch()){
    var_dump($rslt);
}
echo '<hr />';
$it = new IteratorIterator($stmt);

/*
while ($valeur = $it->current()){
    echo $valeur[0].'<br />';
    $it->next();
 $it->rewind();
}
*/
$it->rewind();
$it->next();
var_dump($it->current());
echo '<hr />';
foreach ($it as $val) {
//    echo $val[0].'<hr />';
    var_dump($val);
}
echo '<hr />';

