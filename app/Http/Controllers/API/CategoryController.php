<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Category;
use Validator;
use App\Http\Resources\CategoryResource;

class CategoryController extends BaseController
{
    public function index()
    {

        $result=Category::all();
        return $this->sendResponse(CategoryResource::collection($result),'Categories');
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'category'=>'required'
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());  
        }

        $result=Category::create($request->all());
        return $this->sendResponse(new CategoryResource($result),'Data inserted successfully.');
    }

    public function show($id)
    {
        $result=Category::find($id);
        if(is_null($result))
        {
            return $this->sendError('no data found');
        }

        return $this->sendResponse(new CategoryResource($result),'Categories');
    }

    public function update(Request $request, $id)
    {
        $input=$request->all();
        $validator=Validator::make($request->all(),
        [
            'category'=>'required'
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());  
        }

        $size = Category::findOrFail($id);
        $size->update($request->all());
        return $this->sendResponse(new CategoryResource($size),'Data updated successfully.');
    }

    public function destroy($id)
    {
        $result = Category::find($id);
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
