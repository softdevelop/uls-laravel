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
    $format='xml';//Output Format. viewSubscriptions supports the following formats: xml and json
    //$format='json';
    
    $callback='';//The Callback Function. Works only with JSON Output Format.
    //$callback='YOUR_JSON_FUNCTION';
    
    $lang='EN';//The selected Language of the report. Currently only 'EN' (English) is supported.
    
    
    $string2sign = $userID."\n".$timestamp;
    $authKey = base64_encode(hash_hmac('sha1',$string2sign,$apiKey,true));
       
    
    $POSTparameters='userID='.urlencode($userID).'&authKey='.urlencode($authKey).'&timestamp='.urlencode($timestamp).'&format='.urlencode($format).'&lang='.urlencode($lang).'&callback='.urlencode($callback); //POSTvars
    
 
    //Calling Web SEO Analytics Webservice
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://www.webseoanalytics.com/api/1.2/viewSubscriptions.php');
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
            print_r($xml);
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
