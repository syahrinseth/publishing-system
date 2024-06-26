<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\User;
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
            'manuscript_no' => $this->manuscript_no,
            'abstract' => $this->abstract,
            'keywords' => $this->keywords,
            'attachments' => new ManuscriptAttachCollection($this->attachments),
            'authors' => $this->authors,
            'authors_in_users' => User::whereIn('id', $this->authors->map(function($q){return $q->user_id;}))->get()->all(),
            'corresponding_authors' => $this->correspondingAuthors,
            'corresponding_authors_in_users' => User::whereIn('id', $this->correspondingAuthors->map(function($q){return $q->user_id;}))->get()->all(),
            'editors' => $this->editors,
            'editors_in_users' => User::whereIn('id', $this->editors->map(function($q){return $q->user_id;}))->get()->all(),
            'reviewers' => $this->reviewers,
            'reviewers_in_users' => User::whereIn('id', $this->reviewers->map(function($q){return $q->user_id;}))->get()->all(),
            'category' => $this->category,
            'funding_information' => $this->funding_information,
            'is_confirm_grant_numbers' => $this->is_confirm_grant_numbers ? true : false,
            'is_acknowledge' => $this->is_acknowledge ? true : false,
            'short_title' => $this->short_title,
            'abstract' => $this->abstract,
            'keywords' => $this->keywords,
            'status' => ucwords($this->status),
            'funding_information' => $this->funding_information,
            'created_at' => $this->created_at->diffForHumans(),
            'created_at_date' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
    }
}
