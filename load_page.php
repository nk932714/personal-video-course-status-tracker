<?php

 if (isset($_GET['key'])) { $key = $_GET["key"]; 	

        $word ='<a href="#'.$key.'">&#10060;</a></li>'; //cross
    $lrntword ='<a href="#'.$key.'">&#9989;</a></li>';  //tickmark

$mystring = file_get_contents("mod.txt");

if(strpos($mystring, $word) !== false){
    
    $subtitles1 = str_replace($word,$lrntword,$mystring);
    file_put_contents("mod.txt",$subtitles1);
    echo "done";
    
}
else echo "word not found or already completed";

}     else { die("something is missing");   }

?>
