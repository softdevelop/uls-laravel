<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use app\Models\InforConfiguarationUserModel;
use app\Models\GuidedConfiguarationModel;

class GuidedConfiguratorController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        /*code here...*/
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        /*code here...*/
    }
    /**
     * Delete Term
     *
     * @param  String $id [description]
     *
     * @return Json     [description]
     */
    public function destroy($id)
    {
        /*code here...*/
    }

    /**
     * [addDetailGuidedConfiguaration description]
     *
     * @author [Kim Bang] <[bang@httsolution.com]>
     * @param Request $request [description]
     */
    public function addDetailGuidedConfiguaration(Request $request)
    {
    	$data = $request->all();

    	$inforConfigUser = new InforConfiguarationUserModel();

    	$dataInforConfig = $inforConfigUser->addInforConfiguarationUser($data);

    	//check save infor configuaration user complete
    	if (!empty($dataInforConfig)) {
    		$guidedConfiguaration = new GuidedConfiguarationModel();

	    	$data = customDataGuideCongiguaration($data);

	    	$result = $guidedConfiguaration->addDetailGuidedConfiguaration($data);
    	} else {
    		return new JsonResponse(['status' => 0, 'result' => []]);
    	}

    	return new JsonResponse($result);
    }
}
