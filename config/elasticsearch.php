<?php

use Monolog\Logger;

return array(
    'hosts' => array(
       env('url_elastic_search', 'localhost:9200')
    ),
    'logPath' => storage_path().'logs/',
    'logLevel' => Logger::INFO
);