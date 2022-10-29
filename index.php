<?php

// Voici comment va fonctionner mon bot de web scraping (extraction de données) :

    //  Fetching : Il va se connecter à la page du site et en télécharger le bout de code HTML choisis
    //  Parsing : Il va parser le code HTML à l’aide du sélecteur CSS ou du XPath pour extraire ce qui m'intéresse
    //  Stockage : Il va stocker le tout dans un fichier 

function scraping($url) {    

    $url = 'https://www.welcometothejungle.com/fr/jobs?groupBy=job&sortBy=mostRelevant&query=laravel&aroundQuery=Paris%2C+France&refinementList%5Boffices.district%5D%5B0%5D=Paris&refinementList%5Boffices.state%5D%5B0%5D=Ile-de-France&refinementList%5Boffices.country_code%5D%5B0%5D=FR&page=1'; 

    // passage du contenu du fichier à une variable 
    $html = file_get_contents($url); //  cette function lis le fichier entier dans une chaîne de caractères, elle prend comme paramètre l'url

     // stockage du DOM
     $site = new DOMDocument();

     // permet de supprimer les erreurs potentiel avec le DOM
     libxml_use_internal_errors(TRUE);

    if (!empty($html)) { // si le contenue de ma variable $html n'est pas vide alors je rentre dans cette condition

        $site->loadHTML($html); //  Charge le HTML à partir d'une chaîne  (https://www.php.net/manual/en/domdocument.loadhtml.php)

        libxml_clear_errors(); // supression des erreurs dans le DOM 

        $site_path = new DOMXPath($site); // récupération du chemin du DOM (permet de faire les requetes)

        $query = '/html/body//header'; // je définis ma cible dans le DOM
        // /html/body/div[1]/div/div/div/div/div/main/div[1]/div/div/div[2]/ol/li[1]/article/div[2]/header/div/a/h3
        // je recupere la requete
        $result = $site_path->query($query);

        // var_dump($result);
        // die();

        $scraped_data = [];

        // si la longeur du tableau est supérieur à zéro alors je rentre dans la condition
        if ($result->length >0) {
            foreach ($result as $item) {
                $scraped_data[] = $item->nodeValue;
            }
        }

        var_dump($scraped_data);
        die();

    // création d'un fichier JSON pour stocker le contenu crawlé par le bot
    file_put_contents('file.json', json_encode($scraped_data));

    // file_put_contents('scraping.html',"\n\n".$scraped_data."\n\n",FILE_APPEND);  // FILE_APPEND permet d'ajouter du contenu au fichier existant

    }
    
}

scraping($url);

