<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }

    public function index()
    {
        try {
            $this->products =  Product::all();
            $this->productCatgory =  ProductCategory::all();
            $data = ['products', 'productCatgory'];
            return $this->view('product.index',$data);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with(['error' => $e->getMessage()]);
        }
    }
    public function fileUpload(Type $var = null)
    {
        # code...
    }

    public function add(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'code' => 'required|string',
                'category_id' => 'required|numeric|min:1',
                'price' => 'required',
                'description' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($validator->fails()){
                throw new \Exception($validator->errors()->first());
            }
            $product = new Product();
            $product->name = $request->name;
            $product->code = $request->code;
            $product->price = preg_replace('/[^0-9]/', '', $request->price); 
            $product->category_id = $request->category_id;
            $product->description = $request->description;

            if($request->image){
                $imageName = date('Ymd').time().'.'.$request->image->extension();
                $request->image->move(storage_path('app/public/uploads'), $imageName);
                $pathFile = storage_path('app/public/uploads').$imageName;
                if(!$pathFile){
                    throw new \Exception("Failed");    
                }
                $product->path_image = $imageName;
            }
            
            if(!$product->save()){
                throw new \Exception("Failed");    
            }

            DB::commit();
            $res = [
                'url' => route('list-product')
            ];

            return $this->success_response("Success Save Data", $res, $request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }

    public function getData(Request $request)
    {
        try {
            $product = Product::find($request->id);
            if(!$product){
                throw new \Exception("Not Found");
            }
            $res = [
                'product' => $product
            ];

            return $this->success_response("Success Save Data", $res, $request->all());
        } catch (\Exception $e) {
            return $this->failed_response($e->getMessage());
        }
    }
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'code' => 'required|string',
                'category_id' => 'required|numeric|min:1',
                'price' => 'required',
                'description' => 'required|string',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($validator->fails()){
                throw new \Exception($validator->errors()->first());
            }
            $product = Product::find($request->id);
            $product->name = $request->name;
            $product->code = $request->code;
            $product->price = preg_replace('/[^0-9]/', '', $request->price); 
            $product->category_id = $request->category_id;
            $product->description = $request->description;

            if($request->image){
                $imageName = date('Ymd').time().'.'.$request->image->extension();
                $request->image->move(storage_path('app/public/uploads'), $imageName);
                $pathFile = storage_path('app/public/uploads').$imageName;
                if(!$pathFile){
                    throw new \Exception("Failed");    
                }
                $product->path_image = $imageName;
            }
            
            if(!$product->save()){
                throw new \Exception("Failed");    
            }

            DB::commit();
            $res = [
                'url' => route('list-product')
            ];

            return $this->success_response("Success Save Data", $res, $request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {

            $product = Product::find($request->id);
            if(!$product){
                throw new \Exception("Not Found");
            }

            if(!$product->delete()){
                throw new \Exception("Failed Save");
            }
            DB::commit();

            $res = [
                'url' => route('list-product')
            ];

            return $this->success_response("Success Save Data", $res, $request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }
}
