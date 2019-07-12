<?php
/*
$thefiles=[];

$thefiles[] = array('dir1/dir2/dir3/file1.mkv', 44444);
$thefiles[] = array('dir1/dir2/dir3/file2.mkv', 44444);
$thefiles[] = array('dir1/dir2/file1.mkv', 44444);
$thefiles[] = array('dir1/dir2/file2.txt', 11111);
$thefiles[] = array('dir1/dir4/file5.mkv', 22444);
$thefiles[] = array('dir1/dir4/file6.txt', 15111);
$thefiles[] = array('dir1/file1.exe', 22222);
$thefiles[] = array('dir1/file2.exe', 22222);
$thefiles[] = array('file1.rar', 3333);

$filearray=[];

function scanpath($patharray,$filesize) {
    $tree=[];
    if(count($patharray)===1) {
        $filename=array_pop($patharray);
        $tree[] = ['name'=>$filename, 'size'=>$filesize];
    } else {
        $pathpart = array_pop($patharray);
        $tree[$pathpart] = scanpath($patharray,$filesize);
    }
    return $tree;
}

foreach($thefiles as $fileentry) {
    $patharray=array_reverse(explode('/',$fileentry[0]));
    $thisarray = scanpath($patharray,$fileentry[1]);
    $filearray= array_merge_recursive($filearray,$thisarray);
}

echo '<pre>';
print_r($filearray);
echo '</pre>';
*/

/*
$path='E:\wamp\www\plugin\donate';
$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
$tree_array=array();
foreach($objects as $name => $object){
    if(in_array($object->getFilename(),array('..','.')) || is_dir($object->getPathname()))
    {
        continue;
    }
    $path_info=explode(DIRECTORY_SEPARATOR ,$object->getPathname());
    $file_name=array_pop($path_info);
    $path_info="['".implode("']['",$path_info)."']";
    $code='$tree_array'.$path_info.'[] = '.'\''.$file_name.'\';';
    eval($code);
}

var_dump($tree_array);
*/

/*
function scanpath($path) {
    $myscan = scandir($path);
    $tree=[];
    foreach($myscan as $entry) {
        //echo '<br>'.$entry;
        if($entry==='.' || $entry ==='..') {
            // do nothing
        } else  if(is_dir($path.'/'.$entry)) {
            // this is a folder, I will recurse
            $tree[$entry] = scanpath($path.'/'.$entry);
        } else {
            // this is a file or link. Value is file size
            $tree[$entry] = filesize($path.'/'.$entry);
        }
    }
    return $tree;
}
$path='E:\wamp\www\plugin\donate';
//$scanresult=scanpath(__DIR__);
$scanresult=scanpath( $path );
echo '<pre>';
print_r($scanresult);
echo '</pre>';
*/

/*
// Get a file into an array.  In this example we'll go through HTTP to get
// the HTML source of a URL.
$lines = file('http://localhost/plugin/donate/');

// Loop through our array, show HTML source as HTML source; and line numbers too.
foreach ($lines as $line_num => $line) {
    echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
}

// Another example, let's get a web page into a string.  See also file_get_contents().
$html = implode('', file('http://localhost/plugin/donate/'));

// Using the optional flags parameter since PHP 5
$trimmed = file('somefile.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

*/

