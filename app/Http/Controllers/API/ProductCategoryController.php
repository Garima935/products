<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Subcategory;

use Validator;
use App\Http\Resources\ProductResource;

class ProductCategoryController extends BaseController
{
    public function index()
    {

        $result=Product::all();
        for($i=0;$i<count($result);$i++)
        {
            $result[$i]['apparelsize']=$result[$i]['apparelsize']->size_code;
            $result[$i]['pro_colors']=$result[$i]['pro_colors'];
        }

        return $this->sendResponse($result,'Product Colors');
    }

    public function store(Request $request)
    {
        $input=$request->all();
        $validator=Validator::make($request->all(),
        [
            'product_id'=>'required',
            'sub_cat_id'=>'required'
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());  
        }

        $pro=Product::find($request->product_id);

        if(is_null($pro))
        {
            return $this->sendError('Invalid Product',[]); 
        }
        else
        {
            $sub_cat=Subcategory::find($request->sub_cat_id);
            if(is_null($sub_cat))
            {
                return $this->sendError('Invalid Category',[]); 
            }
            else
            {
            $data['product_id']=$request->product_id;
            $data['sub_cat_id']=$request->sub_cat_id;
            $result=ProductCategory::create($data);
           $result->product=$result->product;
           $result->sub_cat=$result->sub_cat;
            return $this->sendResponse($result,'Data inserted successfully.');
        }
        }
    }

    public function show($id)
    {
        $result=Product::find($id);
        $result->pro_categories=$result->pro_categories;
        for($i=0;$i<count($result->pro_categories);$i++)
        {
            $result->pro_categories[$i]['sub_category']=$result->pro_categories[$i]['sub_cat']->sub_cat;
            unset($result->pro_categories[$i]['sub_cat']);
        }
        if(is_null($result))
        {
            return $this->sendError('no data found');
        }

        return $this->sendResponse($result,'Product Categories');
    }



    public function destroy($id)
    {
        $result = ProductCategory::find($id);
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
