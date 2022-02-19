<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $title = $request->title;
        $model = $request->model;
        $category = $request->category;
        $brand = $request->brand;
        $manufacturer = $request->manufacturer;
        $barcode = $request->barcode;

        $title = urldecode($title);
        $model = urldecode($model);
        $category = urldecode($category);
        $brand = urldecode($brand);
        $manufacturer = urldecode($manufacturer);
        $barcode = urldecode($barcode);
        $allProduct = new Product();
        if (!empty($title)){
            $allProduct = $allProduct->where('title','LIKE',"%$title%");
        }
        if (!empty($barcode)){
            $allProduct = $allProduct->where('barcode','LIKE',"%$barcode%");
        }
        if (!empty($model)){
            $allProduct = $allProduct->where('model','LIKE',"%$model%");
        }
        if (!empty($category)){
            $allProduct = $allProduct->where('category','LIKE',"%$category%");
        }
        if (!empty($brand)){
            $allProduct = $allProduct->where('brand','LIKE',"%$brand%");
        }
        if (!empty($manufacturer)){
            $allProduct = $allProduct->where('manufacturer','LIKE',"%$manufacturer%");
        }
        $allProduct = $allProduct->get();
        if ($allProduct->isEmpty()){
            $allProduct = [];
            if (!empty($barcode)){
                $data = $this->callApiBarcode($barcode);
                $products = json_decode($data);
                if (!empty($products->products)){
                    foreach ($products->products as $key=>$item){
                        $product = new Product();
                        $this->extract($product,$item);
                        $product->save();
                        $allProduct[] = $product;
                    }
                }
            }
            if (!empty($title) || !empty($model) || !empty($brand) || !empty($category) || !empty($manufacturer)){
                $data = $this->callApi($title);
                $products = json_decode($data);
                if (!empty($products->products)){
                    foreach ($products->products as $key=>$item){
                        $product = new Product();
                        $this->extract($product,$item);
                        $product->save();
                        $allProduct[] = $product;
                    }
                }
            }
        }
        return ProductResource::collection($allProduct);
    }
    private function extract(Product $product,$item){
        $product->title = $item->title ? :'';
        $product->mpn = $item->mpn ? :'';
        $product->asin = $item->asin ? :'';
        $product->barcode = $item->barcode_number ? :'';
        $product->category = $item->category ? :'';
        $product->manufacturer = $item->manufacturer ? :'';
        $product->brand = $item->brand ? :'';
        $product->color = $item->color ? :'';
        $product->gender = $item->gender ? :'';
        $product->material = $item->material ? :'';
        $product->size = $item->size ? :'';
        $product->length = $item->length ? :'';
        $product->width = $item->width ? :'';
        $product->height = $item->height ? :'';
        $product->weight = $item->weight ? :'';
        $product->contributors = !empty($item->contributors) ? json_encode($item->contributors) :'';
        $product->ingredients = $item->ingredients ? :'';
        $product->release_date = $item->release_date ? : null;
        $product->description = $item->description ? :'';
        $product->features = !empty($item->features) ? json_encode($item->features) :'';
        $product->images = !empty($item->images) ? json_encode($item->images) :'';
        $product->stores = !empty($item->stores) ? json_encode($item->stores) :'';
        $product->reviews = !empty($item->reviews) ? json_encode($item->reviews) :'';
    }
    public function barcode(Request $request)
    {
        $barcode = $request->code;
        $product = Product::whereNotNull('barcode');
        if (!empty($barcode)){
            $product = $product->where('barcode','LIKE',"%$barcode%");
        }
        $product = $product->get();
        if (!empty($barcode)){
            if ($product->isEmpty()){
                $data = $this->callApiBarcode($barcode);
                $products = json_decode($data);
                if (!empty($products->products)){
                    foreach ($products->products as $key=>$item){
                        $product = new Product();
                        $product->title = $item->title ? :'';
                        $product->mpn = $item->mpn ? :'';
                        $product->asin = $item->asin ? :'';
                        $product->barcode = $item->barcode_number ? :'';
                        $product->category = $item->category ? :'';
                        $product->manufacturer = $item->manufacturer ? :'';
                        $product->brand = $item->brand ? :'';
                        $product->color = $item->color ? :'';
                        $product->gender = $item->gender ? :'';
                        $product->material = $item->material ? :'';
                        $product->size = $item->size ? :'';
                        $product->length = $item->length ? :'';
                        $product->width = $item->width ? :'';
                        $product->height = $item->height ? :'';
                        $product->weight = $item->weight ? :'';
                        $product->contributors = !empty($item->contributors) ? json_encode($item->contributors) :'';
                        $product->ingredients = $item->ingredients ? :'';
                        $product->release_date = $item->release_date ? : null;
                        $product->description = $item->description ? :'';
                        $product->features = !empty($item->features) ? json_encode($item->features) :'';
                        $product->images = !empty($item->images) ? json_encode($item->images) :'';
                        $product->stores = !empty($item->stores) ? json_encode($item->stores) :'';
                        $product->reviews = !empty($item->reviews) ? json_encode($item->reviews) :'';
                        $product->save();
                    }
                    $product = Product::where('barcode','LIKE',"%$barcode%")->get();
                }
            }
        }
        return response()->json($product);
    }
    public function create(Request $request)
    {
        $request->contributors = !empty($item->contributors) ? json_encode($item->contributors) :'';
        $request->features = !empty($item->features) ? json_encode($item->features) :'';
        $request->images = !empty($item->images) ? json_encode($item->images) :'';
        $request->stores = !empty($item->stores) ? json_encode($item->stores) :'';
        $request->reviews = !empty($item->reviews) ? json_encode($item->reviews) :'';
        $product = Product::create($request->all());
        return new ProductResource($product);
    }
    public function update($id,Request $request)
    {
        $product = Product::where('id',$id)->first();
        if (empty($product)){
            return response()->json([
                'status'=>false,
                'msg'=>'Product not found'
            ]);
        }
        $request->contributors = $request->contributors ? json_encode($request->contributors):'';
        $request->features = $request->features ? json_encode($request->features):'';
        $request->images = $request->images ? json_encode($request->images):'';
        $request->stores = $request->stores ? json_encode($request->stores):'';
        $request->reviews = $request->reviews ? json_encode($request->reviews):'';
        $product->fill($request->all());
        return new ProductResource($product);
    }

    public function delete($id)
    {
        $product = Product::where('id',$id)->first();
        if (!$product){
            return response()->json([
                'status'=>false,
                'msg'=>'Product not found.'
            ]);
        }else{
            $product->delete();
            return response()->json([
                'status'=>true,
                'msg'=>'Product delete successful.'
            ]);
        }
    }
    private function callApi($keyword){
        $api_key = 'rkmtw0c49xugy9k9si9v65vgwd90wb';
        $url = 'https://api.barcodelookup.com/v3/products?search='.$keyword.'&formatted=y&key=' . $api_key;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    private function callApiBarcode($code){
        $api_key = 'rkmtw0c49xugy9k9si9v65vgwd90wb';
        $url = "https://api.barcodelookup.com/v3/products?barcode=$code&formatted=y&key=$api_key";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
