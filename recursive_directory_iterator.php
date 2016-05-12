<?php
/*
 * encours de développement
 * | <a href="recursive_directory_iterator.php">RecursiveDirectoryIterator</a>
 */

class Dir2Array extends ArrayObject{
    
    public $_liste2Dir;
    public $_liste2DirBrute;
    protected $_liste2File;

    protected $_chemin;
    
    protected $_stop = 0;



    public function __construct($chemin='./'){
        
        
        $this->_chemin = $chemin;
        $this->_liste2Dir = array();

        $this->_liste2Dir[] = $this->set_liste2File($chemin);
        $this->set_liste2DirBrute($chemin);

        $this->add_liste2Dir($chemin);
    }

    protected function add_liste2Dir(){

        foreach ($this->_liste2DirBrute as $dir){
            $this->_liste2Dir[] = $this->set_liste2File($dir);
        }
    }

    protected function set_liste2DirBrute($chemin){
        
        $this->_liste2DirBrute = array();
        $listeTempo = array();
        $listeTempo = scandir($chemin,0);

        reset($listeTempo);
        next($listeTempo);//on passe ..
        while(next($listeTempo)){//on passe .
            $File = new SplFileInfo (current($listeTempo));

            if ($File->isDir()){
                $this->_liste2DirBrute[] = $File->getFilename();
            }
        }

        return array ($chemin,$this->_liste2File);
    }

    protected function set_liste2File($chemin){
        
        $liste2File = array();
        $listeTempo = array();
        $listeTempo = scandir($chemin,0);
        


        reset($listeTempo);
        next($listeTempo);//on passe ..
        while(next($listeTempo) || $this->_stop<4){//on passe .
            $File = new SplFileInfo (current($listeTempo));

            if (!$File->isDir()){
                $liste2File[] = $File->getFilename();
            }
            else{
                $liste2File[] = array ($this->set_liste2DirBrute($File->getFilename()));
            }
            $this->_stop++;
        }

        return array ($chemin,$liste2File);
    }

}


$liste2Rep = new Dir2Array('./');

var_dump($liste2Rep->_liste2Dir);


//print_r($liste2Rep);