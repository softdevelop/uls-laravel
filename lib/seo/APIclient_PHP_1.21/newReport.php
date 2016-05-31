<?php
    /*
        WebSEOAnalytics.com API: 1.21V
        New Report - Example
    */
    
    //Basic Parameters
    $userID='YOUR_USER_ID';//This info is provided by Web SEO Analytics
    $apiKey='YOUR_API_KEY';//This info is provided by Web SEO Analytics
    
    if(function_exists('date_default_timezone_set')) {
        date_default_timezone_set('GMT');
    }
    $timestamp=time();
    $format='xml';//Output Format. newReport supports the following formats: xml, json, pdf and csv
    //$format='json';
    //$format='pdf';
    //$format='csv';
    
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
    $inputArray=array(
        'url'=>'http://www.webseoanalytics.com' //The URL of the Page
    );
    
    /*
    $toolID='18';//KEYWORD BATTLE
    $inputArray=array(
        'urlList'=>"http://www.webseoanalytics.com\r\nhttp://www.example.com\r\nhttp://www.google.com", //The list of URLs separated by \n or \r\n
        'keywordList'=>"web seo analytics\r\ngoogle\r\ngoogle seo\r\nexample",//The list of Keywords separated by \n or \r\n
        'searchengineType'=>0,//GOOGLE - The selected Search Engine (0: Google, 1: Bing)
        //'searchengineType'=>1,//BING
        'countryData'=>'en', //The Language version of the Search Engine
        'checkOtherSubdomain'=>1 //Allow to scan all subdomains of the domain (1: true, 0: false)
    );
    */
    
    /*
    $toolID='14';//SITE SUBMITTER
    $inputArray=array(
        'url'=>'http://www.example.com', //The URL of the Website
        'sitemap'=>'http://www.example.com/sitemap.xml', //The URL of the Sitemap
        'mail'=>'test@example.com', //The Contact Email
        'name'=>'Example Name', //The Owner Name
        'title'=>'Example Title', //The Title of the Website
        'keywords'=>'Example Keywords', //The keywords of the Website
        'description'=>'Example Description' //The description of the Website
    );
    */
    
    /*
    $toolID='2';//DOMAIN INFO
    $inputArray=array(
        'url'=>'http://www.example.com', //The URL of the Website
        'checkOtherSubdomain'=>1 //Allow to scan all subdomains of the domain (1: true, 0: false)
    );
    */
    
    /*
    $toolID='4';//INDEXED PAGES
    $inputArray=array(
        'url'=>'http://www.webseoanalytics.com', //The URL of the Website
        'checkOtherSubdomain'=>1 //Allow to scan all subdomains of the domain (1: true, 0: false)
    );
    */
    
    /*
    $toolID='13';//REPUTATION TRACKER
    $inputArray=array(
        'url'=>'http://www.example.com' //The URL of the Page
    );
    */
    
    /*
    $toolID='8';//DUPLICATE CONTENT
    $inputArray=array(
        'url1'=>'http://www.webseoanalytics.com/free/', //The URL of the first Page
        'url2'=>'http://www.webseoanalytics.com' //The URL of the second Page
    );
    */
    
    /*
    $toolID='3';//HTML VALIDATION
    $inputArray=array(
        'urlList'=>"http://www.example.com\r\nhttp://www.webseoanalytics.com/free\r\nhttp://www.webseoanalytics.com" //The list of URLs separated by \n or \r\n
    );
    */

    /*
    $toolID='5';//LINK POPULARITY
    $inputArray=array(
        'url'=>'http://www.example.com' //The URL of the Page
        'checkOtherSubdomain'=>1 //Allow to scan all subdomains of the domain (1: true, 0: false)
    );
    */
    
    /*
    $toolID='6';//BACKLINK ANALYSIS
    $inputArray=array(
        'url'=>'http://www.example.com', //The URL of the Page
        'checkOtherSubdomain'=>1 //Allow to scan all subdomains of the domain (1: true, 0: false)
    );
    */
    
    /*
    $toolID='12';//WEB SEO ANALYSIS
    $inputArray=array(
        'url'=>'http://www.webseoanalytics.com', //The URL of the Page
        'checkOtherSubdomain'=>1 //Allow to scan all subdomains of the domain (1: true, 0: false)
    );
    */
    
    /*
    $toolID='20';//LINK STRUCTURE
    $inputArray=array(
        'url'=>'http://www.webseoanalytics.com', //The URL of the Page
        'checkOtherSubdomain'=>1 //Allow to scan all subdomains of the domain (1: true, 0: false)
    );
    */
    
    /*
    $toolID='21';//BACKLINK HUNTER
    $inputArray=array(
        'keyword'=>'online marketing', //The Keyword
        'type'=>1, //ALL WEBSITES - The type of search (1: All Websites, 2: Blogs, 3: Directories, 4: Forums, 5: URL Submission)
        //'type'=>2, //BLOG
        //'type'=>3, //DIRECTORY
        //'type'=>4, //FORUM
        //'type'=>5, //URL SUBMISSION
    );
    */
    
    /*
    $toolID='9';//DOMAIN BATTLE
    $inputArray=array(
        'urlList'=>"http://www.example.com\r\nhttp://www.google.com/\r\nhttp://www.webseoanalytics.com", //The list of URLs separated by \n or \r\n
        'checkOtherSubdomain'=>1 //Allow to scan all subdomains of the domain (1: true, 0: false)
    );
    */
    
    /*
    $toolID='10';//SERP ANALYSIS
    $inputArray=array(
        'keyword'=>"online marketing",//The search term
        'searchengineType'=>0,//GOOGLE - The selected Search Engine (0: Google, 1: Bing)
        //'searchengineType'=>1,//BING
        'countryData'=>'en', //The Language version of the Search Engine
        'url'=>'http://www.example.com', // (optional) The URL of the Page that we want to Rank
    );
    */
    
    /*
    $toolID='11';//BLOG ANALYZER
    $inputArray=array(
        'url'=>'http://www.webseoanalytics.com/blog/multiple-domains-vs-subdomains-vs-folders-in-seo/', //The URL of the Blog Article
        'checkOtherSubdomain'=>1 //Allow to scan all subdomains of the domain (1: true, 0: false)
    );
    */
    
    /*
    $toolID='15';//KEYWORD RESEARCH
    $inputArray=array(
        'keyword'=>'web', //The initial Keyword
        'findStats'=>1 //Calculate Statistics for the returned keyword list (1: true, 0: false)
    );
    */
    
    /*
    $toolID='16';//KEYWORD DIFFICULTY
    $inputArray=array(
        'urlList'=>"http://www.webseoanalytics.com\r\nhttp://www.webseoanalytics.com/free/\r\nhttp://www.example.com\r\nhttp://www.google.com", //The list of URLs separated by \n or \r\n
        'keywordList'=>"web seo analytics\r\ngoogle\r\ngoogle seo\r\nexample",//The list of Keywords separated by \n or \r\n
        'searchengineType'=>0,//GOOGLE - The selected Search Engine (0: Google, 1: Bing)
        //'searchengineType'=>1,//BING
        'countryData'=>'en', //The Language version of the Search Engine
    );
    */
    
    /*
    $toolID='23';//AGED DOMAIN FINDER
    $inputArray=array(
        'keywordList'=>"web\r\nonline marketing\r\nseo\r\nexample",//The list of Keywords separated by \n or \r\n
        'negativeKeywords'=>"sem, free, test",//The list of negative Keywords separated by ,
        'tldList'=>"com, net, org",//The list of allowed TLDs separated by , If it is empty the results are not filtered by this characteristic.
        'noadult'=>1, //Do not return adult domains (1: true, 0: false)
        'nodigits'=>1, //Do not return domains that contain numbers (1: true, 0: false)
        'nodashes'=>1, //Do not return domains that contain dashes (1: true, 0: false)
        'price'=>100, //The maximum domain Price. If it is empty the results are not filtered by this characteristic.
    );
    */
    
    /*
    $toolID='24';//URL ANALYZER
    $inputArray=array(
        'urlList'=>"http://www.webseoanalytics.com\r\nhttp://www.example.com\r\nhttp://www.google.com", //The list of URLs separated by \n or \r\n
        'checkOtherSubdomain'=>1 //Allow to scan all subdomains of the domain (1: true, 0: false)
    );
    */
    
    $POSTparameters.='&toolID='.urlencode($toolID); //The ID of the Tool
    foreach($inputArray as $key=>$value) { //The Tool parameters
        $POSTparameters.='&'.$key.'='.urlencode($value);
    }
 
    //Calling Web SEO Analytics Webservice
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://www.webseoanalytics.com/api/1.2/newReport.php');
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
    else if($format=='pdf') {
        header('Content-Type: application/pdf');
        echo $result;
    }
    else if($format=='csv') {
        header('Content-Type: application/csv');
        echo $result;
    }
    else {
        echo $result;
    }
?>