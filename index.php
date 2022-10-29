<?php

// Voici comment va fonctionner notre bot de web scraping :

    //  Fetching : Il va se connecter à la page d’accueil du site et en télécharger le code HTML 
    //  Parsing : Il va parser le code HTML à l’aide du sélecteur CSS ou du XPath pour extraire les liens vers chaque article
    //  Stockage : Il va stocker les titres et les URL des offres d'emploi dans un fichier CSV


function scraping($url) {    

    $url = 'https://www.welcometothejungle.com/fr/jobs';


    // passage du contenu du fichier à une variable 
    $html = file_get_contents($url); //  cette function lis le fichier entier dans une chaîne de caractères, elle prend comme paramètre l'url

    // extraction des offres d'emplois
    preg_match_all('~<a.*?href="(.*?)".*?>~',$html);  // extraction du contenu de la page

    // var_dump($matches);
    // die();

    // création d'un fichier html pour stocker le contenu crawlé
    file_put_contents('results.html',"\n\n".$html."\n\n",FILE_APPEND);  
  

}

scraping($url);

