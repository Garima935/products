<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Category;
use App\Models\Subcategory;
use Validator;
use App\Http\Resources\SubcategoryResource;

class SubcategoryController extends BaseController
{
    public function index()
    {
        $result=Subcategory::all();
        for($i=0;$i<count($result);$i++)
        {
            $result[$i]['category_name']=$result[$i]->category->category;
            unset($result[$i]['category']);
        }
        return $this->sendResponse($result,'Sub Categories');
    }

    public function store(Request $request)
    {
        $input=$request->all();
        $validator=Validator::make($request->all(),
        [
            'cat_id'=>'required',
            'sub_cat'=>'required',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());  
        }

        $cat=Category::find($input['cat_id']);

        if(is_null($cat))
        {
            return $this->sendError('Invalid Category',[]); 
        }
        else
        {
            $data['sub_cat']=$input['sub_cat'];
            $data['cat_id']=$input['cat_id'];
            $result=Subcategory::create($data);
            $result->category_name=$result->category->category;
            unset($result->category);
            return $this->sendResponse($result,'Data inserted successfully.');
        }
    }

    public function show($id)
    {
        $result=Subcategory::find($id);
        if(is_null($result))
        {
            return $this->sendError('no data found');
        }

       $result->category_name=$result->category->category;
            unset($result->category);
        return $this->sendResponse($result,'Sub Category');
    }

    public function update(Request $request, $id)
    {
        $input=$request->all();
        $validator=Validator::make($request->all(),
        [
            'sub_cat'=>'required',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());  
        }

        $sub_cat=Subcategory::find($id);

        if(is_null($sub_cat))
        {
            return $this->sendError('Invalid Sub Category',[]); 
        }
        else
        {
            $data['sub_cat']=$input['sub_cat'];
            $sub_cat->update($data);
            
            $sub_cat->category_name=$sub_cat->category->category;
            unset($sub_cat->category);
            return $this->sendResponse($sub_cat,'Data updated successfully.');
        }

    }

    public function destroy($id)
    {
        $result = Subcategory::find($id);
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
