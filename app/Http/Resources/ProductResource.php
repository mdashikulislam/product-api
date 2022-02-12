<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ProductResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title ? :'',
            'mpn' => $this->mpn ? :'',
            'asin' => $this->asin ? :'',
            'barcode' => $this->barcode_number ? :'',
            'category' => $this->category ? :'',
            'manufacturer' => $this->manufacturer ? :'',
            'brand' => $this->brand ? :'',
            'color' => $this->color ? :'',
            'gender' => $this->gender ? :'',
            'material' => $this->material ? :'',
            'size' => $this->size ? :'',
            'length' => $this->length ? :'',
            'width' => $this->width ? :'',
            'height' => $this->height ? :'',
            'weight' => $this->weight ? :'',
            'contributors' => !empty($this->contributors) ? json_decode($this->contributors) :[],
            'ingredients' => $this->ingredients ? :'',
            'release_date' => $this->release_date ? : null,
            'description' => $this->description ? :'',
            'features' => !empty($this->features) ? json_decode($this->features) :[],
            'images' => !empty($this->images) ? json_decode($this->images) :[],
            'stores' => !empty($this->stores) ? json_decode($this->stores) :[],
            'reviews' => !empty($this->reviews) ? json_decode($this->reviews) :[],
        ];
    }
}
