<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;
use App\Models\Apparelsize;
use Validator;
use App\Http\Resources\ProductResource;

class ProductController extends BaseController
{
    public function index()
    {

        $result=Product::all();
        for($i=0;$i<count($result);$i++)
        {
            $result[$i]['size_code']=$result[$i]->apparelsize->size_code;
            $result[$i]['pro_colors']=$result[$i]['pro_colors'];
            for($j=0;$j<count($result[$i]['pro_colors']);$j++)
            {
            $result[$i]['pro_colors'][$j]['color_name']=$result[$i]['pro_colors'][$j]['color']->color;
            unset($result[$i]['pro_colors'][$j]['color']);
        }

        for($k=0;$k<count($result[$i]['pro_categories']);$k++)
            {
            $result[$i]['pro_categories'][$k]['sub_category']=$result[$i]['pro_categories'][$k]['sub_cat']->sub_cat;
            $result[$i]['pro_categories'][$k]['category_name']=$result[$i]['pro_categories'][$k]['sub_cat']->category->category;
            unset($result[$i]['pro_categories'][$k]['sub_cat']->category);
            unset($result[$i]['pro_categories'][$k]['sub_cat']);
        }
        
            unset($result[$i]->apparelsize);
        }
        return $this->sendResponse($result,'Products');
    }

    public function store(Request $request)
    {
        $input=$request->all();
        $validator=Validator::make($request->all(),
        [
            'product_name'=>'required',
            'size_id'=>'required'
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());  
        }

        $size=Apparelsize::find($input['size_id']);

        if(is_null($size))
        {
            return $this->sendError('Invalid Size',[]); 
        }
        else
        {
            $data['product_name']=$input['product_name'];
            $data['size_id']=$input['size_id'];
            $result=Product::create($data);
  
            $result->size_code=$result->apparelsize->size_code;
            $result->pro_colors=$result->pro_colors;
            for($j=0;$j<count($result['pro_colors']);$j++)
            {
            $result['pro_colors'][$j]['color_name']=$result['pro_colors'][$j]['color']->color;
            unset($rresult['pro_colors'][$j]['color']);
        }

        for($k=0;$k<count($result['pro_categories']);$k++)
            {
            $result['pro_categories'][$k]['sub_category']=$result['pro_categories'][$k]['sub_cat']->sub_cat;
            $result['pro_categories'][$k]['category_name']=$result['pro_categories'][$k]['sub_cat']->category->category;
            unset($result['pro_categories'][$k]['sub_cat']->category);
            unset($result['pro_categories'][$k]['sub_cat']);
        }
        
            unset($result->apparelsize);
        
            return $this->sendResponse($result,'Data inserted successfully.');
        }
    }

    public function show($id)
    {
        $result=Product::find($id);
        if(is_null($result))
        {
            return $this->sendError('no data found');
        }

        $res['product_id']=$result->product_id;
        $res['size_code']=$result->apparelsize->size_code;
        $res['product_name']=$result->product_name;
        $res['created_at']=date('d-m-Y',strtotime($result->created_at));
        $res['updated_at']=date('d-m-Y',strtotime($result->updated_at));
        return $this->sendResponse($res,'Products');
    }

    public function update(Request $request, $id)
    {
        $input=$request->all();
        $validator=Validator::make($request->all(),
        [
            'product_name'=>'required',
            'size'=>'required'
        ]);

        if($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());  
        }

        $size=Apparelsize::where('size_code',$request->size)->first();

        if(is_null($size))
        {
            return $this->sendError('Invalid Size',[]); 
        }
        else
        {
            $pro = Product::findOrFail($id);
            $data['product_name']=$pro['product_name'];
            $data['size_id']=$size->size_id;
            $pro->update($data);
            
            $res['product_id']=$pro->product_id;
            $res['size_code']=$pro->apparelsize->size_code;
            $res['product_name']=$pro->product_name;
            $res['created_at']=date('d-m-Y',strtotime($pro->created_at));
            $res['updated_at']=date('d-m-Y',strtotime($pro->updated_at));
            return $this->sendResponse($res,'Data updated successfully.');
        }

    }

    public function destroy($id)
    {
        $size = Product::findOrFail($id);
        $size->delete();
        return $this->sendResponse([],'Data deleted successfully.');
    }
}
