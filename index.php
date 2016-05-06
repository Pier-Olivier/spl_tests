<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

        <h1>Inner Interator</h1>
        <p> L'intérateur est à l'intérieur de l'objet [Héritage] et décrit la façon de parcourir l'objet</p>
        <p>L'inteface ArrayAccess permet d'accéder aux attribut de l'Objet : $Objet[attribut].<br />
        L'interface Iterator permet de se dépalcer avec : $Objet->next(), $Objet->current() et donc foreach ($Objet as $attribut).<br />

        ArrayObjet est une Class qui aggrège ArrayAccess et une version simplifié de Iterator : IteratorAgregate.<br />
        On a accès à : $Objet[attribut], foreach ($Objet as $attribut), mais pas à $Objet->next(), $Objet->current() ...
        </p>
        
        <h1>Outer Interator</h1>
        <p>L'Objet est mis dans l'intérateur [Association] et c'est lui qui parcourt les attributs de l'Objet </p>
        <p>RecursiveArrayIterator hérite de ArrayIterator et implémente RecursiveIterator<br />
        puis est parcouru autravers de l'objet RecursiveIteratorIterator ou de la methode iterator_apply</p>

        <p> les iterators recusifs permettent de parcourir des structures avec différentes branches.<br />
            On "pose" un itétateur (RecursiveArrayIterator) puis on "l'encapsule" dans un IteratorIterator (RecursiveIteratorIterator).<br />
            $IteratorIterator ($Iterator ($Objet))).<br />
            On peut alors parcourir avec $IteratorIterator->next(), $IteratorIterator->current() et donc foreach ($IteratorIterator as $attribut)
        </p>

        <p> quelques exemples  </p>
        <h2>Inner Iterator</h2>filter_iterator
        <p><a href="iterator.php">Iterator</a> | <a href="seekable_iterator.php">SeekableIterator</a> | <a href="iterator_aggregate.php">IteratorAggregate</a> | <a href="mon_array.php">mon_array</a> | <a href="foreach.php">foreach</a> </p>
        <h2>Outer Iterator</h2>
        <p><a href="filter_iterator.php">FilterIterator</a> | <a href="iterator_iterator.php">iterator_iterator</a> | <a href="recursive_iterator_iterator.php">RecursiveIteratorIterator</a></p>

        <p>| <a href="directory_iterator.php">DirectoryIterator</a>

        <p><img src="Diagrammedeclasses.png" alt="Diagramme des Objets"> </p>
    </body>
</html>
