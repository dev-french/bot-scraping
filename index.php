<?php

function crawl_test($url, $depth=1) {    

if($depth>0){
    
    $html = file_get_contents($url); //  cette function lis le fichier entier dans une chaîne de caractères
    preg_match_all('~<a.*?href="(.*?)".*?>~',$html,$matches);  // extraction du contenu de la page
   

    // var_dump($matches);
    // die();

    foreach ($matches[1] as $newurl) {
        crawl_test($newurl, $depth-1);
    }
    file_put_contents('results.html',"\n\n".$html."\n\n",FILE_APPEND);  // création d'un fichier html pour stocker le contenu crawlé
}

}

crawl_test('https://www.welcometothejungle.com/fr/jobs',1);

