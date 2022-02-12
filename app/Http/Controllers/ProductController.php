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
        $barcode = $request->barcode;
        $title = urldecode($title);
        $barcode = urldecode($barcode);
        $allProduct = new Product();
        if (!empty($title)){
            $allProduct = $allProduct->where('title','LIKE',"%$title%");
        }
        if (!empty($barcode)){
            $allProduct = $allProduct->where('barcode','LIKE',"%$barcode%");
        }
        $allProduct = $allProduct->get();
        if (count($allProduct) < 1){
            $data = $this->callApi($title);
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
                $allProduct = new Product();
                if (!empty($title)){
                    $allProduct = $allProduct->where('title','LIKE',"%$title%");
                }
//                if (!empty($barcode)){
//                    $allProduct = $allProduct->where('barcode','LIKE',"%$barcode%");
//                }
                $allProduct = $allProduct->get();
            }
        }
        return ProductResource::collection($allProduct);
    }

    public function create(Request $request)
    {
        $request->contributors = !empty($item->contributors) ? json_encode($item->contributors) :'';
        $request->features = !empty($item->features) ? json_encode($item->features) :'';
        $request->images = !empty($item->images) ? json_encode($item->images) :'';
        $request->stores = !empty($item->stores) ? json_encode($item->stores) :'';
        $request->reviews = !empty($item->reviews) ? json_encode($item->reviews) :'';
        $product = Product::create($request->all());
        return $product;
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
        return response()->json($product);
    }
    private function callApi($keyword){
        $api_key = 'rkmtw0c49xugy9k9si9v65vgwd90wb';
        $url = 'https://api.barcodelookup.com/v3/products?title='.$keyword.'&formatted=y&key=' . $api_key;
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
