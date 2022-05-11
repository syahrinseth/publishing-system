<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManuscriptCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'manuscript' => $this->manuscript,
            'user' => $this->user,
            'to' => $this->to,
            'updated_at' => $this->updated_at->diffForHumans(),
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
