<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $output_response = array();
        if(is_iterable($this->resource)) {
            foreach ($this->resource as $item) {
                array_push($output_response, $item->load('posts')->posts->toArray());
            }
            return $output_response;
        } else {
            return [ $this->resource->load('posts')->posts->toArray() ];
        }
    }
}
