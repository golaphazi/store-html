<?php
class pityJob{

    private $working_dir;
    private $dirContents;

    function __construct($tab){
        $this->working_dir = getcwd() . '/layout_data/' . $tab;
        echo $this->working_dir;
        if(!file_exists($this->working_dir)){
            return false;
        }

        $this->dirContents = $this->getDirContents();

        print_r($this->dirContents);

        // $this->renameDir();
        // $this->renameJson();
        // $this->renameFile();
    }

    protected function getDirContents() {

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->working_dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST, 
            RecursiveIteratorIterator::CATCH_GET_CHILD
        );
        foreach($files as $file) {
            $results[] = [
                'obj' => $file,
                // 'path' => $file->parentFolder,
                // 'name' => basename($file),
            ];
        }

        return $results;
    }

    private function renameDir(){
        foreach($this->dirContents as $f){
            if($f['obj']->isDir()){
               $this->renamePolicy($f);
            }
        }
    }
    
    private function renameFile(){
        foreach($this->dirContents as $f){
            if($f['obj']->isFile()){
                echo $f['name'];
                echo "\n";
                if(stripos($f['name'], '.json') !== false){
                    $this->renamePolicy($f, 'data.json');
                }
                if(stripos($f['name'], '.jpg') !== false){
                    $this->renamePolicy($f, 'preview.jpg');
                }
            }
        }
    }
}

new pityJob('section');

echo "\n";