<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Color;
use Validator;
use App\Http\Resources\ColorResource;

class ColorController extends BaseController
{
    public function index()
    {

        $result=Color::all();
        return $this->sendResponse(ColorResource::collection($result),'Colors');
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'color'=>'required'
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());  
        }

        $result=Color::create($request->all());
        return $this->sendResponse(new ColorResource($result),'Data inserted successfully.');
    }

    public function show($id)
    {
        $result=Color::find($id);
        if(is_null($result))
        {
            return $this->sendError('no data found');
        }

        return $this->sendResponse(new ColorResource($result),'Colors');
    }

    public function update(Request $request, $id)
    {
        $result = Color::find($id);
        if(is_null($result))
        {
            return $this->sendError('Invalid Id');
        }
        else
        {
        $input=$request->all();
        $validator=Validator::make($request->all(),
        [
            'color'=>'required'
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());  
        }
        $result->update($request->all());
        return $this->sendResponse(new ColorResource($result),'Data updated successfully.');
    }
    }

    public function destroy($id)
    {
        $result = Color::find($id);
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
