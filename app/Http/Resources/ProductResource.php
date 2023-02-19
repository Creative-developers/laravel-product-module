<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class ProductResource extends JsonResource {
    
    public function toArray($request){
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'price'  => $this->price,
            'staus'  => $this->status,
            'user'   => new UserResource($this->user),
            'type'   => $this->type,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString()
        ];
    }
}
