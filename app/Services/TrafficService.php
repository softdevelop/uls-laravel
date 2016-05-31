<?php namespace App\Services;

class TrafficService {
    // get service
    public static function getService(){
        // Creates and returns the Analytics service object.
        // Load the Google API PHP Client Library.
        require_once (base_path() . '/vendor/google/apiclient/src/Google/autoload.php');
        // require_once '../../google-api-php-client/src/Google/autoload.php';
        // Use the developers console and replace the values with your
        // service account email, and relative location of your key file.
        $service_account_email = '767831270570-b25p97lgtbd6se9e2gbq96a7ovjd2ppu@developer.gserviceaccount.com';
        $key_file_location = base_path('google/client_secrets/client_secrets.p12');
        // Create and configure a new client object.
        $config = new \Google_Config();
        $config->setClassConfig('Google_Cache_File', array('directory' => base_path('google/cache')));
        $client = new \Google_Client($config);
        $client->setApplicationName("GoogleAnalytics");
        $analytics = new \Google_Service_Analytics($client);
        // Read the generated client_secrets.p12 key.
        $key = file_get_contents($key_file_location);
        $cred = new \Google_Auth_AssertionCredentials($service_account_email, array(\Google_Service_Analytics::ANALYTICS_READONLY), $key);
        $client->setAssertionCredentials($cred);
        
        if ($client->getAuth()->isAccessTokenExpired()) {
            $client->getAuth()->refreshTokenWithAssertion($cred);
        }

        return $analytics;
    }

    // get first profile id
    public static function getFirstprofileId(&$analytics) {
        // Get the user's first view (profile) ID.
        // Get the list of accounts for the authorized user.
        $accounts = $analytics->management_accounts->listManagementAccounts();
        
        if (count($accounts->getItems()) > 0) {
            $items = $accounts->getItems();
            // $firstAccountId = $items[0]->getId();
            $firstAccountId = 5206561;
            // ULS account id
            // Get the list of properties for the authorized user.
            $properties = $analytics->management_webproperties->listManagementWebproperties($firstAccountId);
            
            if (count($properties->getItems()) > 0) {
                $items = $properties->getItems();
                $firstPropertyId = $items[0]->getId();
                // Get the list of views (profiles) for the authorized user.
                $profiles = $analytics->management_profiles->listManagementProfiles($firstAccountId, $firstPropertyId);
                
                if (count($profiles->getItems()) > 0) {
                    $items = $profiles->getItems();
                    // Return the first view (profile) ID.
                    return $items[0]->getId();
                } else  {
                    throw new Exception('No views (profiles) found for this user.');
                }

            } else {
                throw new Exception('No properties found for this user.');
            }

        } else {
            throw new Exception('No accounts found for this user.');
        }

    }

    // get results
    public static function getResults(&$analytics, $profileId, $pageUrl = '~/contact-us', $date = null)        
    {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        /**
     * note ga:networkLocation => Service Provider
     * formatDate => 2015-08-21
     */        // echo $date;
        
        if (is_null($date)){
            return;
        }

        $startDate = $endDate = $date;
        // var_dump($startDate, $endDate);die;
        return $analytics->data_ga->get('ga:' . $profileId, $startDate, // start date
        $endDate, //end date
        // 'page:contact-us',
        'ga:sessions, ga:users, ga:pageviews, ga:pageviewsPerSession, ga:avgSessionDuration, ga:bounceRate, ga:percentNewSessions', 
            [
                'filters' => 'ga:pagePath=' . $pageUrl, 
                'dimensions' => 'ga:language, ga:country, ga:city, ga:browser, ga:operatingSystem, ga:networkLocation, ga:screenResolution'       
                // 'system' => 'ga:browser, ga:operatingSystem, ga:serviceProvider'
            ]
        );
    }

    // print results
    public static function printResults(&$results)    
    {
        // Parses the response from the Core Reporting API and prints
        // the profile name and total sessions.
        
        if (count($results->getRows()) > 0)        {
            // Get the profile name.
            $profileName = $results->getProfileInfo()->getProfileName();
            // Get the entry for the first entry in the first row.
            $rows = $results->getRows();
            return $rows;
            // echo '<pre>'; print_r($rows);die;
            $sessions = $rows[0][0];
            // Print the results.
            print "First view (profile) found: $profileNamen";
            print "Total sessions: $sessionsn";
        } else        {
            return "No results found.n";
        }

    }

    // $analytics = getService();
    // $profile = getFirstProfileId($analytics);
    // $results = getResults($analytics, $profile);
    // printResults($results);
}