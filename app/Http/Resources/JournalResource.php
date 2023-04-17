<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JournalResource extends JsonResource
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
            'name' => $this->name,
            'date' => $this->date,
            'status' => $this->status,
            'manuscripts' => $this->manuscripts(),
            'get_manuscripts' => $this->getManuscripts()->with([
                'getAuthors:id,first_name,last_name,email',
                'getCoAuthors:id,first_name,last_name,email',
                'getEditors:id,first_name,last_name,email',
                'getReviewers:id,first_name,last_name,email',
            ])->get(),
            'description' => $this->description,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans()
        ];
    }
}
