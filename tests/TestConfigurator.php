<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Rowboat\DatabaseManagement\Services\RecommendedLaserFormulaService;
use Rowboat\Users\Models\UserModel;

use Rowboat\DatabaseManagement\Models\Mongo\ConfiguratorMongo;

//api/database-manager/guided-configurator/get-platform

class TestConfigurator extends TestCase
{
	public $recommendedLaserFormulaService;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function setUp()
    {
        parent::setUp();
        Session::start();

        $user = UserModel::find(6);
        \Auth::login($user);

        // $recommendedLaserFormulaService = new RecommendedLaserFormulaService();

        // $this->recommendedLaserFormulaService = $recommendedLaserFormulaService;

    }

    public function getArrayValue()
    {
        $arrayValue = ConfiguratorMongo::find('57465ef3bffebc68098b4567');

        return $arrayValue;
    }

    public function getDataValueMaterial()
    {
        $listMaterialValueData = ['dataSources' => [], 'dataCustomerEntries' => []];

        $dataConfiguratorMongo = ConfiguratorMongo::find('57465ef3bffebc68098b4567');
        dd($dataConfiguratorMongo);

        $listMaterialValueData = $dataConfiguratorMongo->getDataGuideCommendedWithId();

        return $listMaterialValueData;
    }

    public function testP2GmaxC()
    {
        $_arrayValue = $this->getArrayValue();

        $recommendedLaerService = new RecommendedLaserFormulaService();

        $listMaterialValueData = $this->getDataValueMaterial();

        $dataValueQuery = $recommendedLaerService->getDataValueQueryTestCase($listMaterialValueData);

        $request->dump();
    }



    /**
     * testMaterialMinRecommendedCuttingLaserPower.
     *
     * MATx P2MinC = Material Min Recommended Cutting Laser Power
     *
     * @author  Huy Nguyen <huy@httsolution.com>
     * 
     * @return [type] [description]
     */
    // public function testMaterialMinRecommendedCuttingLaserPower()
    // {
    // 	$recommendedLaserFormulaService = new RecommendedLaserFormulaService();

    	
    // }

    /**
     * testMaterialMinRecommendedCuttingLaserPower.
     *
     *  MATx P2MaxC = Material Max Recommended Cutting Laser Power
     *  
     * @author  Huy Nguyen <huy@httsolution.com>
     * 
     * @return [type] [description]
     */
    // public function testMaterialMaxRecommendedCuttingLaserPower()
    // {

    // }

    /**
     * testMinMaterialTypeCo2PowerRange.
     *
     * MATx minMPRC = Minimum Material Power Range for MATx
     *
     * @author  Huy Nguyen <huy@httsolution.com>
     * 
     * @return [type] [description]
     */
    // public function testMinMaterialTypeCo2PowerRange()
    // {

    // }

    /**
     * testMinMaterialTypeCo2PowerRange.
     *
     * MATx minMPRC = Maximum Material Power Range for MATx
     *
     * @author  Huy Nguyen <huy@httsolution.com>
     * 
     * @return [type] [description]
     */
    // public function testMaxMaterialTypeCo2PowerRange()
    // {

    // }

    /**
     * testMaterialTypeCo2GlobalMinimumRecommendedLaserPower.
     *
     * P2GMinC Global Minimum Recommended Laser Power for C02 Material Type
     * 
     * @return [type] [description]
     */
    // public function testMaterialTypeCo2GlobalMinimumRecommendedLaserPower()
    // {

    // }

    /**
     * testMaterialTypeCo2GlobalMinimumRecommendedLaserPower.
     *
     * P2GMaxC Global Maximum Recommended Laser Power for C02 Material Type
     * 
     * @return [type] [description]
     */
    // public function testMaterialTypeCo2GlobalMaximumRecommendedLaserPower()
    // {

    // }

    /**
     * testMaterialTypeCo2MultipleLaserConfigurationTrue
     *
     * MLCC
     * 
     * @author  Huy Nguyen<huy@httsolution.com>.
     * 
     * @return [type] [description]
     */
    // public function testMaterialTypeCo2MultipleLaserConfigurationTrue()
    // {

    // }

    /**
     * [testMaterialTypeCo2MultipleLaserConfigurationFalse.
     * 
     * MLCC 
     * 
     * @author  Huy Nguyen <huy@httsolution.com>
     * 
     * @return [type] [description]
     */
    // public function testMaterialTypeCo2MultipleLaserConfigurationFalse()
    // {

    // }

    /**
     * testMaterialTypeCo2DualLaserSystemTrue.
     * 
     * DLSC 
     * @author  Huy Nguyen <huy@httsolution.com>
     * 
     * @return [type] [description]
     */
   	// public function testMaterialTypeCo2DualLaserSystemTrue()
   	// {

   	// }

   	/**
     * testMaterialTypeCo2DualLaserSystemFalse.
     *
     * DLSC.
     *
     * @author  Huy Nguyen <huy@httsolution.com>
     * 
     * @return [type] [description]
     */
   	// public function testMaterialTypeCo2DualLaserSystemFalse()
   	// {

   	// }




}
