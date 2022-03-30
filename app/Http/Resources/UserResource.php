<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->roles,
            'permissions_attribute' => $this->getPermissionsAttr(),
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'postcode' => $this->postcode,
            'city' => $this->city,
            'state' => $this->state,
            'fax_no' => $this->fax_no,
            'country' => $this->country,
            'website_url' => $this->website_url,
            'about' => $this->about,
            'photo' => $this->photo,
            'updated_at' => $this->updated_at->diffForHumans(),
            'created_at' => $this->created_at->diffForHumans(),
            'university' => $this->university,
            'affiliation' => $this->affiliation
        ];
    }
}
