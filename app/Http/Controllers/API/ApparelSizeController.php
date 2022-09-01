<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Apparelsize;
use Validator;
use App\Http\Resources\ApparelSizeResource;

class ApparelSizeController extends BaseController
{
    public function index()
    {

        $result=Apparelsize::all();
        return $this->sendResponse(ApparelSizeResource::collection($result),'Apparel Size');
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'size_code'=>'required'
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());  
        }

        $result=Apparelsize::create($request->all());
        return $this->sendResponse(new ApparelSizeResource($result),'Data inserted successfully.');
    }

    public function show($id)
    {
        $result=Apparelsize::find($id);
        if(is_null($result))
        {
            return $this->sendError('no data found');
        }

        return $this->sendResponse(new ApparelSizeResource($result),'Apparel Size');
    }

    public function update(Request $request, $id)
    {
        $input=$request->all();
        $validator=Validator::make($request->all(),
        [
            'size_code'=>'required'
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());  
        }

        $size = Apparelsize::findOrFail($id);
        $size->update($request->all());
        return $this->sendResponse(new ApparelSizeResource($size),'Data updated successfully.');
    }

    public function destroy($id)
    {
        $result = Apparelsize::find($id);
        if(is_null($result))
        {
            return $this->sendError('Invalid Id');
        }
        else
        {
        $result->delete();
        return $this->sendResponse([],'Data deleted successfully.');
    }
    }
}
