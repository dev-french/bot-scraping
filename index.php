<?php

// Voici comment va fonctionner mon bot de web scraping (extraction de données) :

    //  Fetching : Il va se connecter à la page du site et en télécharger le bout de code HTML choisis
    //  Parsing : Il va parser le code HTML à l’aide du sélecteur CSS ou du XPath pour extraire ce qui m'intéresse
    //  Stockage : Il va stocker le tout dans un fichier 

function scraping() {    

    // je définis le nom d'agent utilisateur 
    ini_set('user_agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:106.0) Gecko/20100101 Firefox/106.0 (https://www.welcometothejungle.com)');

    

    $url = 'https://www.welcometothejungle.com/fr/jobs?page=1&groupBy=job&sortBy=mostRelevant&query=laravel'; 


    // passage du contenu du fichier à une variable 
    $html = file_get_contents($url); //  cette function lis le fichier entier dans une chaîne de caractères, elle prend comme paramètre l'url

    // die();

     // stockage du DOM
     $site = new DOMDocument();

     // HTML est souvent bancal, cela supprime beaucoup d'avertissements
     libxml_use_internal_errors(TRUE);

    if (!empty($html)) { // si le contenue de ma variable $html n'est pas vide alors je rentre dans cette condition

        $site->loadHTML($html); //  Charge le HTML à partir d'une chaîne  (https://www.php.net/manual/en/domdocument.loadhtml.php)

        libxml_clear_errors(); // supression des erreurs dans le DOM 

        $site_path = new DOMXPath($site); // récupération du chemin du DOM (permet de faire les requetes)

        $query = '/html/body'; // je définis ma cible dans le DOM
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
        
        // echo $item->textContent;
        // var_dump($scraped_data);
        // die();

    // création d'un fichier JSON pour stocker le contenu crawlé par le bot
    // file_put_contents('file.json', json_encode($scraped_data));
    // file_put_contents('links.json', json_encode($scraped_data, JSON_PRETTY_PRINT));

    // file_put_contents('scraping.html',"\n\n".$scraped_data."\n\n",FILE_APPEND);  // FILE_APPEND permet d'ajouter du contenu au fichier existant

    }
    
}

scraping();

// class crawler {


//     public static $timeout = 2;
//     public static $agent   = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';
 
 
//     public static function http_request($url) {
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL,            $url);
//        curl_setopt($ch, CURLOPT_USERAGENT,      self::$agent);
//        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$timeout);
//        curl_setopt($ch, CURLOPT_TIMEOUT,        self::$timeout);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        $response = curl_exec($ch);
//        curl_close($ch);
//        return $response;
//     }
 
 
//     public static function strip_whitespace($data) {
//        $data = preg_replace('/\s+/', ' ', $data);
//        return trim($data);
//     }
 
 
//     public static function extract_elements($tag, $data) {
//        $response = array();
//        $dom      = new DOMDocument;
//        @$dom->loadHTML($data);
//        foreach ( $dom->getElementsByTagName($tag) as $index => $element ) {
//           $response[$index]['text'] = self::strip_whitespace($element->nodeValue);
//           foreach ( $element->attributes as $attribute ) {
//              $response[$index]['attributes'][strtolower($attribute->nodeName)] = self::strip_whitespace($attribute->nodeValue);
//           }
//        }
//        return $response;
//     }
 
 
//  }

//  $data  = crawler::http_request('https://www.welcometothejungle.com/fr/jobs?page=1&groupBy=job&sortBy=mostRelevant&query=laravel');
// $links = crawler::extract_elements('a', $data);
// if ( count($links) > 0 ) {
//    file_put_contents('links.json', json_encode($links, JSON_PRETTY_PRINT));
// }