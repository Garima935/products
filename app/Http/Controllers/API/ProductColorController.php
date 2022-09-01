<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\Color;

use Validator;
use App\Http\Resources\ProductResource;

class ProductColorController extends BaseController
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
            'product_name'=>'required',
            'color'=>'required'
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());  
        }

        $pro=Product::where('product_name',$request->product_name)->first();

        if(is_null($pro))
        {
            return $this->sendError('Invalid Product',[]); 
        }
        else
        {
            $color=Color::where('color',$request->color)->first();
            if(is_null($color))
            {
                return $this->sendError('Invalid Color',[]); 
            }
            else
            {
            $data['product_id']=$pro->product_id;
            $data['color_id']=$color->color_id;
            $result=ProductColor::create($data);
            $res['pro_color_id']=$result->pro_color_id;
            $res['product_id']=$result->product_id;
            $res['product_name']=$result->product->product_name;
            $res['color_id']=$result->color_id;
            $res['color_name']=$result->color->color;
            $res['created_at']=date('d-m-Y',strtotime($result->created_at));
            $res['updated_at']=date('d-m-Y',strtotime($result->updated_at));
            return $this->sendResponse($res,'Data inserted successfully.');
        }
        }
    }

    public function show($id)
    {
        $result=Product::find($id);
        $result->pro_colors=$result->pro_colors;
        for($i=0;$i<count($result->pro_colors);$i++)
        {
            $result->pro_colors[$i]['color_name']=$result->pro_colors[$i]['color']->color;
            unset($result->pro_colors[$i]['color']);
        }
        if(is_null($result))
        {
            return $this->sendError('no data found');
        }

        return $this->sendResponse($result,'Product Colors');
    }



    public function destroy($id)
    {
        $result = ProductColor::find($id);
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
