<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'type' => $this->type,
            'name' => $this->name,
            'label' => ucwords(implode(" ", explode("_", $this->name) ?? [])),
            'value' => $this->value,
            'notes' => $this->notes,
            'meta' => $this->meta,
            'updated_at' => $this->updated_at->diffForHumans()
        ];
    }
}
