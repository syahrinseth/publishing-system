<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ManuscriptAttachCollection;

class ManuscriptResource extends JsonResource
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
            'type' => $this->getType(),
            'title' => $this->title,
            'abstract' => $this->abstract,
            'keywords' => $this->keywords,
            'attachments' => new ManuscriptAttachCollection($this->attachments),
            'authors' => $this->authors,
            'corresponding_authors' => $this->corresponding_authors,
            'editors' => $this->editors,
            'reviewers' => $this->reviewers,
            'category' => $this->category,
            'funding_information' => $this->funding_information,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
        // return parent::toArray($request);
    }
}
