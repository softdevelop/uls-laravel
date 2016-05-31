<?php 
namespace App\Services\FindRepresentatives;

use App\Models\Mongo\Cp\DealersModelMongo;
use App\Models\Mongo\CoordinatesModelMongo;
use App\Models\Mongo\Cp\DealersLocationModelMongo;
use App\Models\Mongo\Cp\LocationsModelMongo;
use App\Models\Mongo\Cp\ZoneRadiiModelMongo;
class FindByAddressService
{

    function getGeocode($address)
    {
        $address = str_replace(' ', '+', $address);
        // Get Google maps data
        $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $address . '&sensor=false');
        
        return json_decode($geocode);
    }
    function getChannelPartners($geocode) 
    {

        $results = [];

        if ($geocode->status != 'ZERO_RESULTS')
        {
            $latitude = $geocode->results[0]->geometry->location->lat;

            $longitude = $geocode->results[0]->geometry->location->lng;
            
            $addr = array();

            $country = '';

            $addressArr = $geocode->results[0]->address_components;

            foreach ($addressArr as $key => $address) 
            {
                if (strlen($address->short_name) == 2)
                {
                    $country .= $address->short_name . '|';   
                }
            }

            $country = substr($country, 0, -1); // strip off last pipe

            $closestChannelPartners = self::findClosestChannelPartners($latitude, $longitude, $country);

            asort($closestChannelPartners);

            $checkInRadius = false;

            foreach ($closestChannelPartners as $key => $value) {
                
                $inRadius = self::checkRadius($key, $value);

                if ($inRadius){

                    $checkInRadius = true;

                    $distanceMiles = round($value, 2);

                    $distanceKm = round(($value * 1.609344), 2); // convert miles to kilometer

                    $coordinates = self::getCoordinates($key);

                    $lat = trim($coordinates->latitude);

                    $long = trim($coordinates->longitude);

                    $channelPartnerInfo = self::getChannelPartnerInfoById($key);

                    $openHouses = self::getOpenHousesByChannelPartnerId($key);

                    $results[] = [
                        'cpInfo' => $channelPartnerInfo, 
                        'miles' => $distanceMiles, 
                        'km' => $distanceKm, 
                        'openHouses' => $openHouses, 
                        'coordinates' => ['latitude'=> $lat, 'longitude' => $long],
                    ];
                }
            
            }

            if(!$checkInRadius){

                $lt = 33.6328481;

                $lg = -111.9115065;

                $uls = self::getChannelPartnerInfoById(62501);

                $results[] = [
                    'cpInfo' => $uls,
                    'miles' => '', 
                    'km' => '', 
                    'openHouses' => '', 
                    'coordinates' => ['latitude' => $lt, 'longitude' => $lg]
                ];


            }
        }

        return $results;
    }

    public function findClosestChannelPartners($lat1, $long1, $country,  $education = null)
    {

        $coordinatesCps = $this->getCps($country, $education);

        $radius = 3958.7558657440545; // Radius of earth in Miles 
        
        $closestChannelPartners = [];

        foreach ($coordinatesCps as $key => $coordinates)
        {
            $dLat = $this->toRad($coordinates->latitude - $lat1);

            $dLon = $this->toRad($coordinates->longitude - $long1); 

            $a = sin($dLat/2) * sin($dLat/2) + cos($this->toRad($lat1)) * cos($this->toRad($coordinates->latitude)) * sin($dLon/2) * sin($dLon/2); 

            $c = 2 * atan2(sqrt($a), sqrt(1-$a));

            $distance = $radius * $c; 

            $closestChannelPartners[$coordinates->channel_partner_id] = $distance;
        }

        return $closestChannelPartners;
    }


    public function toRad($value)
    {
        /** Converts numeric degrees to radians */
        return ($value * pi()) / 180;
    }
    
    public function getCps($country, $education = NULL)
    {

        $countryArr = explode('|', $country);

        for ($i = 0; $i < count($countryArr); $i++) {

            $locations = LocationsModelMongo::where('google_cc', strtolower($countryArr[$i]))->lists('_id');
            
            $dealerLocations = DealersLocationModelMongo::whereIn('location_id', $locations)->lists('channel_partner_id');

            $count = DealersModelMongo::whereIn('channel_partner_id', $dealerLocations)->count();

            if ($count > 0)
            {
                $cc = $countryArr[$i]; 

            } else {

                $cc = $countryArr[0];
            }
        }

        $locations= LocationsModelMongo::where('google_cc', strtolower($cc))->lists('_id');

        $dealersLocations = DealersLocationModelMongo::whereIn('location_id', $locations)->lists('channel_partner_id');

        $dealers =  DealersModelMongo::whereIn('channel_partner_id', $dealersLocations)
                                    ->where('active', 1)
                                    ->where(function($query) use($education){
                                       if($education == 'education'){
                                            $query->where('education', $education);
                                        }else{
                                            $query->where('find_by_representative', 1);
                                        }
                                    })
                                    ->lists('channel_partner_id');

        $coordinatesCps = CoordinatesModelMongo::whereIn('channel_partner_id', $dealers)->get();

        return $coordinatesCps;
    }

    public function checkRadius($channelPartnerId, $distance)
    {

        $dealersRadiusLists =  DealersModelMongo::where('channel_partner_id', $channelPartnerId)->lists('zone_radius_id');

        $radiusZone = ZoneRadiiModelMongo::whereIn('_id', $dealersRadiusLists)->where('radius', '>=', $distance)->count();

        return $radiusZone;

    }

    public function getCoordinates($channelPartnerId)
    {

        $coordinatesCps = CoordinatesModelMongo::where('channel_partner_id', $channelPartnerId)->first();

        return $coordinatesCps;
    }
    public function getChannelPartnerInfoById($channelPartnerId)
    {
        $dealer = DealersModelMongo::where('channel_partner_id', $channelPartnerId)->first();

        $dealer->dealerLocation = $dealer->dealerLocation;


        $dealer->location = $dealer->dealerLocation->location;

        $dealer->location->country = $dealer->location->country->name;

        $dealer->company = $dealer->companie->name;

        return $dealer;
    }
    public function getOpenHousesByChannelPartnerId($channelPartnerId)
    {

        return false;
    }
}