<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ViewConfigurationFormRequest;
use App\Http\Controllers\Controller;
use App\Models\Mongo\LanguagesModelMongo;
use App\Models\Mongo\All\LasersModelMongo;
use App\Models\Mongo\All\FormsConfiguratorContactModelMongo;
use Validator;
use App\Services\ipinfodb;
use App\Models\Mongo\All\FormsConfiguratorModelMongo;

class ConfiguratorController extends Controller
{
    /**
     * getSelectPlatform
     * @return [type] [description]
     */
    public function getSelectPlatform()
    {
        $results = [];

        $language = LanguagesModelMongo::findLanguage(getLanguage());
        
        $results['query'] = $language->getConfiguratorText()->toArray();

        getUri($_SERVER['REQUEST_URI']);

        // d($results['query']);die;
        return view('products.select_platform', compact('results'));
    }

    /**
     * getPlatforms
     * @return [type] [description]
     */
    public function getPlatforms()
    {
        $results = [];

        $language = LanguagesModelMongo::findLanguage(getLanguage());
        
        $results['query'] = $language->getAllPlatForms()->toArray();
           // d($results['query']);die;
        $results['laser'] = $language->getLaserConfigurationText()->toArray();

        $results['snippet'] = $language->getSnippet()->toArray();

        $results['max_options'] = $language->getConfiguratorSnippets(['max_part_size', 'laser_options'])->toArray();
        // d($results['max_options']);die;
        $results['select'] = $language->getConfiguratorText()->toArray();

        // d($results['select']);die;
        $results['contact_form'] = $language->getContactForm()->toArray();

        $results['expert'] = $language->getExpertText()->toArray();
        
        return view('products.platforms', compact('results'));
    }

    /**
     * getSelectPower
     * @return [type] [description]
     */
    public function getSelectPower($laser)
    {
        $results = [];

        $language = LanguagesModelMongo::findLanguage(getLanguage());

        $results['query'] = $language->getConfiguratorText()->toArray();
        // d($results['query']);die;
        $results['snippet'] = $language->getSnippet()->toArray();

        $results['expert'] = $language->getExpertText()->toArray();

        $results['contact_form'] = $language->getContactForm()->toArray();

        //set session for plat form
        session(['platform' => $laser]);

        $platformInterest = LasersModelMongo::getPlatformInterest(session('platform'));

        //set session for platform interest
        session(['platform_interest' => $platformInterest]);

        getUri($_SERVER['REQUEST_URI']);

        // d($results);die;
        // Get main content of page 
        return view('products.select_power', compact('results'));
    }

    /**
     * getSelectWattageXls10mwh
     * @return [type] [description]
     */
    public function getSelectWattageXls10mwh()
    {
        $results = [];

        session(['dual_laser_configuration' => 0]);

        $language = LanguagesModelMongo::findLanguage(getLanguage());

        $results['query'] = $language->getConfiguratorText()->toArray();
        // d($results['query']);die;
        $results['snippet'] = $language->getSnippet()->toArray();

        $results['videoText'] = $language->getMultiwaveText()->toArray();

        $laserWattages = $language->getLaserWattages()->toArray();

        // Get laser wattages
        $results['laseronea'] = array_where($laserWattages, function ($key, $value) {
            return $value['power_id'] == 32;
        });

        // Get laser wattages
        $results['laseroneb'] = array_where($laserWattages, function ($key, $value) {
            return $value['power_id'] == 33;
        });

        // Get laser wattages
        $results['lasertwoa'] = array_where($laserWattages, function ($key, $value) {
            return $value['power_id'] >= 21 && $value['power_id'] <= 24;
        });
        // d($results['lasertwoa']);die;
        // Get laser wattages
        $results['lasertwob'] = array_where($laserWattages, function ($key, $value) {
            return $value['power_id'] == 25 ||  $value['power_id'] == 26 || $value['power_id'] == 30;
        });

        // Get laser wattages
        $results['laserthreea'] = array_where($laserWattages, function ($key, $value) {
            return $value['power_id'] == 27;
        });

        // Get laser wattages
        $results['laserthreeb'] = array_where($laserWattages, function ($key, $value) {
            return $value['power_id'] == 31;
        });

       getUri($_SERVER['REQUEST_URI']);

        // d($results);die;
        return view('products.select_wattage_xls10mwh', compact('results'));
    }

    /**
     * getOptionsAccessories
     * @param  [type] $laser [description]
     * @return [type]        [description]
     */
    public function getOptionsAccessories($laser)
    {
        $results = [];

        $language = LanguagesModelMongo::findLanguage(getLanguage());

        $results['query'] = $language->getConfiguratorText()->toArray();
       
        $results['snippet'] = $language->getSnippet()->toArray();

        $laser_id = LasersModelMongo::selectLaser($laser);

        $results['options'] = $language->getLaserOption($laser_id);
        // d($results['options']);die;
        $results['accessories'] = $language->getFiberAccessories($laser_id)->toArray();
        // d( $results['accessories']die);die;
        // d( $results['accessories']);die;
        return view('products.options_accessories', compact('results'));
    }

    /**
     * getViewConfigurationForm
     * @param  [type] $laser [description]
     * @return [type]        [description]
     */
    public function postViewConfigurationForm($laser,ViewConfigurationFormRequest $request)
    {
        getUri($_SERVER['REQUEST_URI']);

        $results = [];

        $language = LanguagesModelMongo::findLanguage(getLanguage());

        $results['fields'] = $language->getFieldNames();

        $results['contact_form'] = $language->getContactForm();

        $results['snippet'] = $language->getSnippet();

        $results['query'] = $language->getConfiguratorText();

        $ipinfodb = new ipinfodb();
        $userIP = $ipinfodb->getIPAddress();
        $info = explode(';', $ipinfodb->getCity($userIP));
        $locations = [
                    'City' => $info[6],
                    'RegionName' => $info[5],
                    'CountryName' => $info[4]
                ];
        //Getting the result
        if (!empty($locations) && is_array($locations)) {
            $city = $locations['City'] . ', ';
            if (empty($locations['City'])) $city = '';
            
            $region = $locations['RegionName'] . ', ';
            if (empty($locations['RegionName'])) $region = '';
            
            $country = $locations['CountryName'];
            if (empty($locations['CountryName'])) $country = '';
            
            $location = $city .  $region . $country;
        } else {
            $location = 'Location not available via IP.  Please check ' . $_SERVER['REMOTE_ADDR'] . ' manually at http://www.iplocation.net';
        }
        $power_interest = '';
        if (session('power_laser1')) $power_interest .= session('power_laser1');
        if (session('power_laser2')) $power_interest .= ' | ' . session('power_laser2');
        if (session('power_laser3')) $power_interest .= ' | ' . session('power_laser3');
        $formData = array(
            'FName' => $request->get('FName'),
            'LName' => $request->get('LName'),
            'EmailAddr' => $request->get('EmailAddr'),
            'Company' => $request->get('Company'),
            'Addr1' => $request->get('Addr1'),
            'City' => $request->get('City'),
            'State' => $request->get('State'),
            'Zip' => $request->get('Zip'),
            'Country' => $request->get('Country'),
            'Phone' => $request->get('Phone'),
            'GeneralNotes' => $request->get('GeneralNotes'),
            'PlatformInterest' => session('platform_interest'),
            'PowerInterest' => $power_interest,
            'OptionsInterest' => session('options'),
            'AccessoryInterest' => session('accessories'),
            'WebAddress' =>  $_SERVER['REMOTE_ADDR'],
            'ApproxLocation' => $location,
            'datestamp' => date('Y-m-d H:i:s'),
            // 'url' => $this->input->server('SERVER_NAME') . $this->input->server('REQUEST_URI'),
            // 'channel_partner_id' => $channel_partner_id
            );  
        FormsConfiguratorModelMongo::submitConfiguration($formData);
        $language->autoResponder('configurator', $formData);
        return redirect()->action('ConfiguratorController@getThankYou', $laser);
    }

    /**
     * getViewConfigurationForm
     * @param  [type] $laser [description]
     * @return [type]        [description]
     */
    public function getViewConfiguration($laser, Request $request)
    {
       getUri($_SERVER['REQUEST_URI']);

       $results = [];

        $language = LanguagesModelMongo::findLanguage(getLanguage());

        // $results['platform'] = $language->getPlatformName(session('platform'));

        $results['fields'] = $language->getFieldNames()->toArray();

        $results['contact_form'] = $language->getContactForm()->toArray();
        // d($results['contact_form']);die;
        $results['snippet'] = $language->getSnippet()->toArray();
        // d($results['snippet']);die;
        $results['query'] = $language->getConfiguratorText()->toArray();

        if ($request->get('superspeed')) $superspeed = $request->get('superspeed'); else $superspeed = '|';
        if ($request->get('pass-through')) $pass_through = $request->get('pass-through'); else $pass_through = '|';
        if ($request->get('hpdfo')) $hpdfo = $request->get('hpdfo'); else $hpdfo = '|';
        if ($request->get('automation')) $automation = $request->get('automation'); else $automation = '|';
        if ($request->get('cutting-table')) $cutting_table = $request->get('cutting-table'); else $cutting_table = '|';
        if ($request->get('rotary-fixture')) $rotary_fixture = $request->get('rotary-fixture'); else $rotary_fixture = '|';
        if ($request->get('cc-air-assist')) $cc_air_assist = $request->get('cc-air-assist'); else $cc_air_assist = '|';
        if ($request->get('back-sweep')) $back_sweep = $request->get('back-sweep'); else $back_sweep = '|';
        if ($request->get('cone')) $cone = $request->get('cone'); else $cone = '|';
        if ($request->get('compressor')) $compressor = $request->get('compressor'); else $compressor = '|';
        if ($request->get('traveling-exhaust')) $traveling_exhaust = $request->get('traveling-exhaust'); else $traveling_exhaust = '|';
        if ($request->get('pin-table')) $pin_table = $request->get('pin-table'); else $pin_table = '|';
        if ($request->get('camera-registration')) $cam_reg = $request->get('camera-registration'); else $cam_reg = '|';
        if ($request->get('uacrendering')) $uacrendering = $request->get('uacrendering'); else $uacrendering = '|';
        if ($request->get('fsrendering')) $fsrendering = $request->get('fsrendering'); else $fsrendering = '|';
        if ($request->get('embeddepc')) $embeddepc = $this->input->post('embeddepc'); else $embeddepc = '|';

        $superspeed = explode('|', $superspeed);
            $pass_through = explode('|', $pass_through);
            $hpdfo = explode('|', $hpdfo);
            $automation = explode('|', $automation);
            $cutting_table = explode('|', $cutting_table);
            $rotary_fixture = explode('|', $rotary_fixture);
            $cc_air_assist = explode('|', $cc_air_assist);
            $back_sweep = explode('|', $back_sweep);
            $cone = explode('|', $cone);
            $compressor = explode('|', $compressor);
            $traveling_exhaust = explode('|', $traveling_exhaust);
            $pin_table = explode('|', $pin_table);
            $cam_reg = explode('|', $cam_reg);
            $uacrendering = explode('|', $uacrendering);
            $fsrendering = explode('|', $fsrendering);
            $embeddepc = explode('|', $embeddepc);
            
            $post_array = array(
                                $superspeed[1],
                                $pass_through[1],
                                $hpdfo[1],
                                $automation[1],
                                $cutting_table[1],
                                $rotary_fixture[1],
                                $cc_air_assist[1],
                                $back_sweep[1],
                                $cone[1],
                                $compressor[1],
                                $traveling_exhaust[1],
                                $pin_table[1],
                                $cam_reg[1],
                                $uacrendering[1],
                                $fsrendering[1],
                                $embeddepc[1]
                                );
                                
        $results['post_array'] = array_reverse($post_array);

        $results['options_array'] = $language->getOptionsArray();

        $results['accessories_array'] = $language->getAccessoriesArray();
        // d( $results['contact_form']);die;
        return view('products.view_configuration', compact('results'));
    }

    /**
     * getViewConfigurationForm
     * @param  [type] $laser [description]
     * @return [type]        [description]
     */
    public function postViewConfiguration($laser, Request $request)
    {
        getUri($_SERVER['REQUEST_URI']);

        $results = [];

        $language = LanguagesModelMongo::findLanguage(getLanguage());

        // $results['platform'] = $language->getPlatformName(session('platform'));

        $results['fields'] = $language->getFieldNames()->toArray();

        $results['contact_form'] = $language->getContactForm()->toArray();
        // d($results['contact_form']);die;
        $results['snippet'] = $language->getSnippet()->toArray();
        // d($results['snippet']);die;
        $results['query'] = $language->getConfiguratorText()->toArray();

        if ($request->get('superspeed')) $superspeed = $request->get('superspeed'); else $superspeed = '|';
        if ($request->get('pass-through')) $pass_through = $request->get('pass-through'); else $pass_through = '|';
        if ($request->get('hpdfo')) $hpdfo = $request->get('hpdfo'); else $hpdfo = '|';
        if ($request->get('automation')) $automation = $request->get('automation'); else $automation = '|';
        if ($request->get('cutting-table')) $cutting_table = $request->get('cutting-table'); else $cutting_table = '|';
        if ($request->get('rotary-fixture')) $rotary_fixture = $request->get('rotary-fixture'); else $rotary_fixture = '|';
        if ($request->get('cc-air-assist')) $cc_air_assist = $request->get('cc-air-assist'); else $cc_air_assist = '|';
        if ($request->get('back-sweep')) $back_sweep = $request->get('back-sweep'); else $back_sweep = '|';
        if ($request->get('cone')) $cone = $request->get('cone'); else $cone = '|';
        if ($request->get('compressor')) $compressor = $request->get('compressor'); else $compressor = '|';
        if ($request->get('traveling-exhaust')) $traveling_exhaust = $request->get('traveling-exhaust'); else $traveling_exhaust = '|';
        if ($request->get('pin-table')) $pin_table = $request->get('pin-table'); else $pin_table = '|';
        if ($request->get('camera-registration')) $cam_reg = $request->get('camera-registration'); else $cam_reg = '|';
        if ($request->get('uacrendering')) $uacrendering = $request->get('uacrendering'); else $uacrendering = '|';
        if ($request->get('fsrendering')) $fsrendering = $request->get('fsrendering'); else $fsrendering = '|';
        if ($request->get('embeddepc')) $embeddepc = $request->get('embeddepc'); else $embeddepc = '|';

        $superspeed = explode('|', $superspeed);
            $pass_through = explode('|', $pass_through);
            $hpdfo = explode('|', $hpdfo);
            $automation = explode('|', $automation);
            $cutting_table = explode('|', $cutting_table);
            $rotary_fixture = explode('|', $rotary_fixture);
            $cc_air_assist = explode('|', $cc_air_assist);
            $back_sweep = explode('|', $back_sweep);
            $cone = explode('|', $cone);
            $compressor = explode('|', $compressor);
            $traveling_exhaust = explode('|', $traveling_exhaust);
            $pin_table = explode('|', $pin_table);
            $cam_reg = explode('|', $cam_reg);
            $uacrendering = explode('|', $uacrendering);
            $fsrendering = explode('|', $fsrendering);
            $embeddepc = explode('|', $embeddepc);
            
            $post_array = array(
                                $superspeed[1],
                                $pass_through[1],
                                $hpdfo[1],
                                $automation[1],
                                $cutting_table[1],
                                $rotary_fixture[1],
                                $cc_air_assist[1],
                                $back_sweep[1],
                                $cone[1],
                                $compressor[1],
                                $traveling_exhaust[1],
                                $pin_table[1],
                                $cam_reg[1],
                                $uacrendering[1],
                                $fsrendering[1],
                                $embeddepc[1]
                                );
                                
        $results['post_array'] = array_reverse($post_array);
        
        $results['options_array'] = $language->getOptionsArray();

        $results['accessories_array'] = $language->getAccessoriesArray();
        // d( $results['contact_form']);die;
        return view('products.view_configuration', compact('results'));
    }
    /**
     * [getSelectWattageXls10mwhForm
     * @return [type] [description]
     */
    public function getSelectWattageXls10mwhForm($laser)
    {
        // die('11');
        return redirect()->action('ConfiguratorController@getOptionsAccessories', $laser);
    }

    /**
     * [getSelectWattageXls10mwhForm
     * @return [type] [description]
     */
    public function postSelectWattageXls10mwhForm($laser, Request $request)
    {
        session(['power_laser1' => '']);
        session(['power_laser2' => '']);
        session(['power_laser3' => '']);

        $language = LanguagesModelMongo::findLanguage(getLanguage());

        // d($results['contact_form']);die;
        $results['snippet'] = $language->getSnippet()->toArray();

        $laser1 = explode('|', $request->get('laser1'));

        if (strpos($request->get('laser2'), '|')) {
            $laser2 = explode('|', $request->get('laser2'));
        } else {
            $laser2 =  '|' . $results['snippet']['laser2_not_configured'];
            $laser2 = explode('|', $laser2);
        }
        if (strpos($request->get('laser3'), '|')) {
            $laser3 = explode('|', $request->get('laser3'));
        } else {
            $laser3 =  '|' . $results['snippet']['laser3_not_configured'];
            $laser3 = explode('|', $laser3);
        }

        session(['power_laser1' => $laser1[1]]);

        session(['power_laser2' => $laser2[1]]);

        if (!isset($laser1[0])) {
            $lazer = 'xls10mwh';
        } else {
            $lazer = 29;
            $laser1En = $language->lookupLaser($lazer);
        }

       if (!empty($laser2[0])) {
          $laser2En = $language->lookupLaser($laser2[0]);
       } else {
          $laser2En = 'Laser 2 not configured';
       }
       
       if (!empty($laser3[0])) {
          $laser3En = $language->lookupLaser($laser3[0]);
       } else {
          $laser3En = 'Laser 2 not configured';
       }                
                    
       session(['laser1_en' => $laser1En . ' Fiber']);
       session(['laser2_en' => $laser2En. ' 10.6 µm']);
       session(['laser3_en' => $laser3En. ' 9.3 µm']);

       if ($request->get('laser1')) 
        {
            $laser1 = explode('|', $request->get('laser1'));
            session(['power_laser1' => $laser1[1] . ' ' . $laser1[2]]);
            session(['fiber' => 1]);

        }

        if ($request->get('laser2')) 
        {
            $laser2 = explode('|', $request->get('laser2'));
            session(['power_laser2' => $laser2[1] . ' ' . $laser2[2]]);
            session(['co2-10.6' => 1]);
        }
        if ($request->get('laser3')) 
        {
            $laser3 = explode('|', $request->get('laser3'));
            session(['power_laser3' => $laser3[1] . ' ' . $laser3[2]]);
            session(['co2-9.3' => 1]);
        }

    return redirect()->action('ConfiguratorController@getOptionsAccessories', $laser);
    }
    /**
     * getHelp
     * @return [type] [description]
     */
    public function getHelp()
    {
        $language = LanguagesModelMongo::findLanguage(getLanguage());
        
        $results['query'] = $language->getConfiguratorText()->toArray();

        $results['expert'] = $language->getExpertText()->toArray();
   
        $results['contact_form'] = $language->getContactForm()->toArray();

        $results['snippet'] = $language->getSnippet()->toArray();

        return view('products.help', compact('results'));
    }

    /**
     * [postHelp description]
     * @return [type] [description]
     */
    public function postHelp(Request $request)
    {
        $ipinfodb = new ipinfodb();
        $userIP =  $ipinfodb->getIPAddress();
        $info = explode(';', $ipinfodb->getCity($userIP));

        $locations = [
                    'City' => $info[6],
                    'RegionName' => $info[5],
                    'CountryName' => $info[4]
                ];

                        //Getting the result
        if (!empty($locations) && is_array($locations)) {
            $city = $locations['City'] . ', ';
            if (empty($locations['City'])) $city = '';
            
            $region = $locations['RegionName'] . ', ';
            if (empty($locations['RegionName'])) $region = '';
            
            $country = $locations['CountryName'];
            if (empty($locations['CountryName'])) $country = '';
            
            $location = $city .  $region . $country;
        } else {
            $location = 'Location not available via IP.  Please check ' . $_SERVER['REMOTE_ADDR'] . ' manually at http://www.iplocation.net';
        }

        $postArray = array(
            'FName' => strip_tags($request->get('FName')),
            'LName' => strip_tags($request->get('LName')),
            'Phone' => strip_tags($request->get('Phone')),
            'EmailAddr' => strip_tags($request->get('EmailAddr')),
            'GeneralNotes' => strip_tags($request->get('GeneralNotes')),
            'WebAddress' => $_SERVER['REMOTE_ADDR'],
            'ApproxLocation' => $location,
            'datestamp' => date('Y-m-d H:i:s'),
            // 'url' => $this->input->server('SERVER_NAME') . $this->input->server('REQUEST_URI'),
            // 'channel_partner_id' => $channel_partner_id
            );
        $email = env('email_test', 'test@httsolution.com');

        FormsConfiguratorContactModelMongo::requestHelp($postArray, $email);
        // \Session::flash('key', 'value');
        $request->session()->flash('thanks', 'Thank you for submitting your request.');
        return redirect()->action('ConfiguratorController@getHelp');

    }

    /**
     * getThankYou
     * @param  [type] $laser [description]
     * @return [type]        [description]
     */
    public function getThankYou($laser)
    {
        $results = [];

        $language = LanguagesModelMongo::findLanguage(getLanguage());

        $results['query'] = $language->getConfiguratorText()->toArray();
        // d($results['query']);die;
        $results['snippet'] = $language->getSnippet()->toArray();

        $results['thank_you'] = $language->getThankYou()->toArray();

        // Get main content of page 
        return view('products.thank_you_configurator', compact('results'));
    }
}
