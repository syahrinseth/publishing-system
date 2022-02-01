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
            'editors' => count($this->editors) > 0 ? $this->editors[0] : null,
            'reviewers' => count($this->reviewers) > 0 ? $this->reviewers[0] : null,
            'category' => $this->category,
            'funding_information' => $this->funding_information,
            'is_confirm_grant_numbers' => empty($this->additional_informations) ? false : $this->additional_informations['is_confirm_grant_numbers'],
            'is_acknowledge' => empty($this->additional_informations) ? false : $this->additional_informations['is_acknowledge'],
            'short_title' => $this->short_title,
            'abstract' => $this->abstract,
            'keywords' => $this->keywords,
            'authors' => null,
            'funding_information' => $this->funding_information,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
        // return parent::toArray($request);
    }
}
