<?php namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Services\CacheService;

use App\Models\Mongo\All\Configurator\LasersOptionsModelMongo;

class LanguagesModelMongo extends Eloquent {

	protected $connection = 'mongodb';
  protected $collection = 'languages';

  protected $fillable = ['language_id', 'code'];

    //relationship for App/Models/Mongo/AllConfigurator/TextModelMongo
    public function allConfiguratorText()
    {
        return $this->hasOne('App\Models\Mongo\All\Configurator\TextModelMongo', 'language_id');
    }
    
    //relationship for App/Models/Mongo/AllConfigurator/TextModelMongo
    public function thankYou()
    {
        return $this->hasOne('App\Models\Mongo\All\ThankYouModelMongo', 'language_id');
    }

    //relationship for App/Models/Mongo/AllConfigurator/TextModelMongo
    public function allConfiguratorText2()
    {
        return $this->hasOne('App\Models\Mongo\All\Configurator\Text2ModelMongo', 'language_id');
    }

    //relationship for App/Models/Mongo/AllConfigurator/TextModelMongo
    public function autoResponders()
    {
        return $this->hasMany('App\Models\Mongo\All\AutoRespondersModelMongo', 'language_id');
    }

    //relationship for App/Models/Mongo/AllConfigurator/TextModelMongo
    public function allContact()
    {
        return $this->hasOne('App\Models\Mongo\All\ContactModelMongo', 'language_id');
    }

    //relationship for App/Models/Mongo/AllConfigurator/TextModelMongo
    public function allOptionsText()
    {
        return $this->hasMany('App\Models\Mongo\All\Configurator\OptionsTextModelMongo', 'language_id');
    }

      //relationship for App/Models/Mongo/AllConfigurator/TextModelMongo
    public function linksConfiguratorAccessories()
    {
        return $this->hasMany('App\Models\Mongo\All\LinksConfiguratorAccessories', 'language_id');
    }
    
    //relationship for App/Models/Mongo/AllConfigurator/TextModelMongo
    public function allExpert()
    {
        return $this->hasOne('App\Models\Mongo\All\ExpertModelMongo', 'language_id');
    }

    //relationship for App/Models/Mongo/AllConfigurator/TextModelMongo
    public function allProducts()
    {
        return $this->hasOne('App\Models\Mongo\All\ProductstModelMongo', 'language_id');
    }

    //relationship for App/Models/Mongo/AllConfigurator/TextModelMongo
    public function allSnippets()
    {
        return $this->hasOne('App\Models\Mongo\All\SnippetsModelMongo', 'language_id');
    }

    //relationship for App/Models/Mongo/AllConfigurator/TextModelMongo
    public function allPlatforms()
    {
        return $this->hasMany('App\Models\Mongo\All\PlatformModelMongo', 'language_id')->orderBy('order_by', 'asc');
    }

    //relationship for App/Models/Mongo/AllConfigurator/TextModelMongo
    public function allSpecs()
    {
        return $this->hasMany('App\Models\Mongo\All\SpecsModelMongo', 'language_id');
    }

    //relationship for App/Models/Mongo/AllConfigurator/TextModelMongo
    public function powerText()
    {
        return $this->hasMany('App\Models\Mongo\All\Configurator\PowerTextModelMongo', 'language_id');
    }

    //relationship for App/Models/Mongo/AllConfigurator/TextModelMongo
    public function accessoriesText()
    {
        return $this->hasMany('App\Models\Mongo\All\Configurator\AccessoriestModelMongo', 'language_id');
    }

    /**
     * [lasersAccessories description]
     * @return [type] [description]
     */
    public function lasersAccessories()
    {
      return $this->hasMany('App\Models\Mongo\All\Configurator\LasersAccessoriesModelMongo', 'language_id');
    }
    /**
     * findLanguage
     * @return [type] find language from language code
     */
    public static function findLanguage($code) 
    {
        
        try {
          $language = self::where('code', $code)->first();
        } catch (ModelNotFoundException $ex) {
          // Error handling code
        }

        return $language;
    }

    /**
     * getStep1
     * @return [type] get data for feature power step1
     */
    public function getConfiguratorText()
    {
        $data = self::with('allConfiguratorText', 'allConfiguratorText2')
                    ->where('_id',$this->_id)
                    ->first();
        return $data;
    }

    /**
     * getAllPlatForms
     * @return get data of plat forms
     */
    public function getAllPlatForms()
    {
        $results = [];
        $languageId = $this->_id;
        $data = self::with('allPlatforms', 'allPlatforms.lasers', 'allPlatforms.spec')
                    ->where('_id', $this->_id)
                    ->first();
        return $data;
    }

    /**
     * getLaserConfigurationText
     * @return [type] [description]
     */
    public function getLaserConfigurationText()
    {
        $data = $this->allConfiguratorText()
                ->select('single_laser_configuration', 'dual_laser_configuration', 'nine_three_configuration', 'one_oh_six_configuration')
                ->first();
        return $data;
    }

    /**
     * getSnippet
     * @return [type] getSnippet with language code
     */
    public function getSnippet()
    {
        $data = $this->allSnippets()->first();

        return $data;
    }

    /**
     * getConfiguratorSnippets
     * @return [type] get data for configurator snippets with data must array
     */
    public function getConfiguratorSnippets($selectData = null) 
    {
        if (is_null($selectData)) {
            $selectData = '*';
        }

        $data = $this->allSpecs()
                    ->where('type', 'labels')
                    ->select($selectData)
                    ->first();
        return $data;
    }

    /**
     * getContactForm
     * @return [type] [description]
     */
    public function getContactForm($selectData = null)
    {
       if (is_null($selectData)) {
            $selectData = '*';
        }
        $data = $this->allContact()
                    ->select($selectData)
                    ->first();

        return $data;
    }

    /**
     * getExpertText
     * @return [type] [description]
     */
    public function getExpertText()
    {
        $data = $this->allExpert()
                    ->select('contact', 'questions')
                    ->first();
        return $data;
    }

    /**
     * getMultiwaveText
     * @return [type] [description]
     */
    public function getMultiwaveText()
    {
        $data = $this->allProducts()
                    ->select('details_pls6mw')
                    ->first();
        return $data;
    }

    /**
     * getLaserWattages
     * @return [type] [description]
     */
    public function getLaserWattages() 
    {

        $data = $this->powerText()
                    ->get();
        return $data;
    }

    /**
     * getLaserOption
     * @return [type] [description]
     */
    public function getLaserOption($laserId)
    {
        $laserOptions = LasersOptionsModelMongo::where('laser_id', $laserId)->get();
        $results = [];

        $datas = self::with(['allOptionsText' => function($query) use($laserId){
                    $query->orderBy('order_by','asc');
                    $query->with(['optionsActive' => function($query){
                        $query->active_dev = 1;
                    }]);
                    $query->with('videoNames');
                    }])
                     ->where('_id', $this->_id)
                    ->first()->toArray();

         foreach ( $datas['all_options_text'] as $key => &$value) {
            foreach ($laserOptions as $key1 => $value1) {
                if ($value1->option_id == $value['option_id']) {
                    $value['true_false'] =  $value1->true_false;
                     $results[] = $value;
                }
            }
  
        }
        return $results;
    }

    /**
     * [getLaserAccessories description]
     * @return [type] [description]
     */
    public function getLaserAccessories($laserId)
    {
      $accessoriesLasersIds = $this->lasersAccessories()
                              ->where('laser_id', $laserId)
                              ->lists('accessory_id')
                              ->all();

      $data = self::with(['accessoriesText' => function($query) use ($accessoriesLasersIds) {
        $query->where('active_dev', 1);
        $query->whereIn('_id', $accessoriesLasersIds);
        $query->with('accessoriesImages', 'allLinksConfiguratorAccessories', 'allLinksConfiguratorAccessories.videoNames');
      
      }])
      ->where('_id', $this->_id)
                    ->first();
      return $data;

    }

    /**
     * getFiberAccessories
     * @param  [type] $laserId [description]
     * @return [type]          [description]
     */
    public function getFiberAccessories($laserId) 
    {
        $accessoriesLasersIds = $this->lasersAccessories()
                              ->where('laser_id', $laserId)
                              ->lists('accessory_id')
                              ->all();

        $data = self::with(['accessoriesText' => function($query) use ($accessoriesLasersIds) {
                        $query->where('active_dev', 1);
                        $query->whereIn('_id', $accessoriesLasersIds);
                        $query->whereNotIn('accessory_id', [15,16]);
                        $query->orderBy('order_by', 'asc');
                        $query->with('accessoriesImages', 'allLinksConfiguratorAccessories', 'allLinksConfiguratorAccessories.videoNames');
                      }])
                        ->where('_id', $this->_id)
                       
                        ->first();
      return $data;
    }
    /**
     * getFieldNames
     * @return getFieldNames of form contact
     */
    public function getFieldNames()
    {
        $data = $this->allContact()
                ->select('first_name','last_name', 'email_address', 
                        'verify_email', 'serial_number', 'password',
                        'password_confirm', 'open_house_name', 
                        'place', 'description', 'link', 'button_text')
                ->first();
        return $data;
    }

    /**
     * lookupLaser
     * @return [type] [description]
     */
    public function lookupLaser($powerId)
    {
       $data = $this->powerText()
                    ->where('power_id', intval($powerId))
                    ->first()
                    ->power_level;
        return $data;
    }

    /**
     * getOptionsArray
     * @return [type] [description]
     */
    public function getOptionsArray()
    {
       $data = $this->allOptionsText()->lists('option_name')->all();
       return $data;
    }

    /**
     * getAccessoriesArray
     * @return [type] [description]
     */
    public function getAccessoriesArray()
    {
       $data = $this->accessoriesText()->lists('accessory_name')->all();
       return $data;
    }

    /**
     * getThankYou
     * @return [type] [description]
     */
    public function getThankYou()
    {
        $data = $this->thankYou()->select('title', 'subtitle', 'will_be_in_touch')->first();
        return $data;
    }

    /**
     * autoResponder
     * @return [type] [description]
     */
    public function autoResponder($form, $data)
    {
        $results = $this->autoResponders()
                    ->select('html', 'subject')
                    ->where('form',$form)
                    ->first();
        // d($results->toArray());die;
        $message = stripslashes($results->html);

        $results->subject = $results->subject;

        $message = str_replace('{$FName}', $data['FName'], $message);
        
        if (session('platform') == 'pls6150d-superspeed')  {
             $image = 'pls6150d';
        }  else {
             $image = session('platform');
        } 

        $message = str_replace('{$image}', $image, $message); 
        $message = str_replace('{$platform}', session('platform_interest'), $message);
        $message = str_replace('{$wattages}', session('wattages'),  $message);
        $message = str_replace('{$date}', date('Y'), $message);
        
        // Email tracking code
        $message = str_replace('{$tld}', $_SERVER['SERVER_NAME'], $message);
        $message = str_replace('{$content}', 'configurator', $message);
        $message = str_replace('{$form}', 'configurator', $message);
        
        $options = '';
        $optionText = session('options');
        if(!empty($optionText)){
                $options .= $optionText.' ';
            }
        //if ($this->session->userdata('accessories') == '') $options .= ' ,';
        $options .= session('accessories');
        
        // if ($options == '')
        // {
        //     $this->db->select('no_options_accessories_chosen');
        //     $this->db->where('language', $this->session->userdata('lang'));
        //     $options = $this->db->get('all_snippets')->row();
            
        //     $options = $options->no_options_accessories_chosen;
        // }
        $message = str_replace('{$options}', $options, $message);
        
        switch (session('platform'))
        {
            case 'pls6150d-superspeed':
            case 'pls6150d':
            case 'pls675':
            case 'pls475':
                $spec_sheet = 'PLS_Platform.pdf';
                break;
            case 'ils1275':
            case 'ils975':
                $spec_sheet = 'ILS_Platform.pdf';
                break;
            case 'pls6mw':
                $spec_sheet = 'PLS6MW_Platform.pdf';
                break;
            case 'vls660':
            case 'vls460':
            case 'vls360':
                $spec_sheet = 'VLS_platform.pdf';
                break;
            case 'vls350':
            case 'vls230':
                $spec_sheet = 'VLS_Desktop.pdf';
                break;
            case 'xls10150d':
            case 'xls10mwh':
                $spec_sheet = 'XLS_Platform.pdf';
                break;  
        }
        
        // $link = base_url('downloads/spec-sheets/' . $spec_sheet);
        $message = str_replace('{$link}', getBaseUrl().'/downloads/spec-sheets/'.$spec_sheet, $message);
        
        // $uri4 = base_url() . uri4() . name_url();
        // $message = str_replace('{$uri4}', $uri4, $message);
        $message = str_replace('{$uri4}', getBaseUrl(),$message);
        $subject = str_replace('{$laser}', session('platform_interest'), $results->subject);

        \Mail::send([], [],function ($m) use($subject, $message) {
            $m->to(env('email_test', 'test@httsolution.com'));
            $m->subject($subject);
            $m->setBody($message, 'text/html');
        });
    }
}
