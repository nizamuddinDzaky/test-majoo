<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $this->productCategory =  ProductCategory::all();
            $data = ['productCategory'];
            return $this->view('product_category.index',$data);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function add(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'code' => 'required|string',
            ]);
            if ($validator->fails()){
                throw new \Exception($validator->errors()->first());
            }
            $productCategory = new ProductCategory();
            $productCategory->name = $request->name;
            $productCategory->code = $request->code;
            if(!$productCategory->save()){
                throw new \Exception("Failed Save");
            }
            DB::commit();

            $res = [
                'url' => route('list-product-category')
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
            $productCategory = ProductCategory::find($request->id);
            if(!$productCategory){
                throw new \Exception("Not Found");
            }
            $res = [
                'productCategory' => $productCategory
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
            ]);
            if ($validator->fails()){
                throw new \Exception($validator->errors()->first());
            }
            $productCategory = ProductCategory::find($request->id);
            if(!$productCategory){
                throw new \Exception("Not Found");
            }
            $productCategory->name = $request->name;
            $productCategory->code = $request->code;
            if(!$productCategory->save()){
                throw new \Exception("Failed Save");
            }
            DB::commit();

            $res = [
                'url' => route('list-product-category')
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

            $productCategory = ProductCategory::find($request->id);
            if(!$productCategory){
                throw new \Exception("Not Found");
            }

            if(count($productCategory->product) >0 ){
                throw new \Exception("Not Found");
            }

            if(!$productCategory->delete()){
                throw new \Exception("Failed Save");
            }
            DB::commit();

            $res = [
                'url' => route('list-product-category')
            ];

            return $this->success_response("Success Save Data", $res, $request->all());
        } catch (\Exception $e) {
            DB::rollback();
            return $this->failed_response($e->getMessage());
        }
    }
}
