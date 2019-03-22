<?php
//if mooving the project somwhere else, use "composer require google/cloud-translate" or it will NEVER work
# Includes the autoloader for libraries installed with composer

require __DIR__ . '/vendor/autoload.php';
//composer require google/cloud-translate;      //necessaire
//set GOOGLE_APPLICATION_CREDENTIALS='key.json';
//export GOOGLE_APPLICATION_CREDENTIALS="key.json";

//gcloud iam service-accounts create twitter_analyser
//gcloud projects add-iam-policy-binding singular-acumen-234307 --member "serviceAccount:twitter_analyser@singular-acumen-234307.iam.gserviceaccount.com" --role "roles/owner"
//gcloud iam service-accounts keys create key.json --iam-account twitter_analyser@singular-acumen-234307.iam.gserviceaccount.com

# Imports the Google Cloud client library
use Google\Cloud\Translate\TranslateClient;

function translate($message){

    # Your Google Cloud Platform project ID
    $projectId = 'singular-acumen-234307';

    //missing a valid api key

    # Instantiates a client
    $translate = new TranslateClient([
        'keyFilePath' => 'key.json',
        'projectId' => $projectId
    ]);

    # The text to translate
    $text = $message;
    # The target language
    $target = 'en';

    # Translates some text into English
    $translation = $translate->translate($text, [
        'target' => $target
    ]);

    //echo 'Text: ' . $text . '
    echo 'Translation: ' . $translation['text'];
    return $translation['text'];

}
?>