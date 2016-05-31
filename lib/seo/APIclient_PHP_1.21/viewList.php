<?php
    /*
        WebSEOAnalytics.com API: 1.21V
        View List of Reports - Example
    */
    
    //Basic Parameters
    $userID='YOUR_USER_ID';//This info is provided by Web SEO Analytics
    $apiKey='YOUR_API_KEY';//This info is provided by Web SEO Analytics
    
    if(function_exists('date_default_timezone_set')) {
        date_default_timezone_set('GMT');
    }
    $timestamp=time();
    $format='xml';//Output Format. viewList supports the following formats: xml and json
    //$format='json';
    
    $callback='';//The Callback Function. Works only with JSON Output Format.
    //$callback='YOUR_JSON_FUNCTION';
    
    $lang='EN';//The selected Language of the report. Currently only 'EN' (English) is supported.
    
    
    $string2sign = $userID."\n".$timestamp;
    $authKey = base64_encode(hash_hmac('sha1',$string2sign,$apiKey,true)); 
    
    
    $POSTparameters='userID='.urlencode($userID).'&authKey='.urlencode($authKey).'&timestamp='.urlencode($timestamp).'&format='.urlencode($format).'&lang='.urlencode($lang).'&callback='.urlencode($callback); //POSTvars
    
    $subscriptionID='YOUR_SUBSCRIPTION_ID';
    $POSTparameters.='&subscriptionID='.urlencode($subscriptionID);
    
    //Request Parameters
    
    $toolID='7';//KEYWORD ANALYZER
    /*
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
    
    $POSTparameters.='&toolID='.urlencode($toolID);
 
 
    //Calling Web SEO Analytics Webservice
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://www.webseoanalytics.com/api/1.2/viewList.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_POST, true );
    curl_setopt($ch, CURLOPT_POSTFIELDS, $POSTparameters);

    $result = curl_exec ($ch);
    curl_close ($ch);
    unset($ch);
    
    if($format=='xml') {
        $xml = simplexml_load_string($result); //load XML string
        if($xml->status==1) { //check for errors
            echo "ID\tDatetime\tName\n";
            foreach ($xml->output->reportList->entry as $entry) { //parse XML doc
                echo $entry->reportID."\t".$entry->datetime."\t".$entry->name."\n"; //print record
            }
        }
        else { //if an error occurred
            echo $xml->error->ErrorCode.': '.$xml->error->ErrorMessage;
        }
    }
    else if($format=='json') {
        //$result=json_decode($result,true);
        echo $result;
    }
    else {
        echo $result;
    }
?>