<?php namespace App\Models\Mongo\All;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ProductstModelMongo extends Eloquent {

	protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable = [
    							'language_id',
    							'title',
    							'subtitle',
    							'page_title',
    							'laser_platform',
    							'power_configuration',
    							'laser_interface',
    							'rapid_reconfiguration',
    							'superspeed',
    							'pass_through',
    							'multiwave',
    							'work_area',
    							'single_laser_config',
    							'dual_laser_config',
    							'view_details',
    							'overview',
                                'details_ils1275',
                                'details_ils975',
                                'details_pls6mw',
                                'details_pls6150d_ss',
                                'details_pls6150d',
                                'details_pls675',
                                'details_pls475',
                                'details_vls660',
                                'details_vls460',
                                'details_vls360',
                                'details_vls350',
                                'details_vls230',
                                'download',
                                'configure_system',
                                'measurements',
                                'with_superspeed',
                                'multiwavelength',
                                'description',
                                'keywords'
    						];

}
