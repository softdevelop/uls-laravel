<?php
    $toolID=24;
    if(isset($_GET['toolID']) && is_numeric($_GET['toolID'])){
        $toolID=$_GET['toolID'];
    }

    require_once('config.php');
    require_once('lib/WSAclient.php');
    require_once('lib/WSAParser.php');
    
    $WSAclient = new WSAclient(WSA_USER_ID,WSA_API_KEY);
    
    /*
    $toolID='7';//KEYWORD ANALYZER
    $toolID='18';//KEYWORD BATTLE
    $toolID='14';//SITE SUBMITTER
    $toolID='2';//DOMAIN INFO
    $toolID='4';//INDEXED PAGES
    $toolID='13';//REPUTATION TRACKER
    $toolID='8';//DUPLICATE CONTENT
    $toolID='3';//HTML VALIDATION
    $toolID='5';//LINK POPULARITY
    $toolID='6';//BACKLINK ANALYSIS
    $toolID='12';//WEB SEO ANALYSIS
    $toolID='20';//LINK STRUCTURE
    $toolID='21';//BACKLINK HUNTER
    $toolID='9';//DOMAIN BATTLE
    $toolID='10';//SERP ANALYSIS
    $toolID='11';//BLOG ANALYZER
    $toolID='15';//KEYWORD RESEARCH
    $toolID='16';//KEYWORD DIFFICULTY
    $toolID='23';//AGED DOMAIN FINDER
    $toolID='24';//URL ANALYZER
    */
    
    $result=$WSAclient->viewLimits($toolID,WSA_SUBSCRIPTION_ID,'xml','EN');

    unset($WSAclient);
    
    
    echo WSAParser::viewLimitsResponse($result);
    

?>
