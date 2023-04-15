<?php

namespace App\Http\Resources;

use App\Models\ManuscriptAttachFile;
use Illuminate\Http\Resources\Json\JsonResource;

class ManuscriptAttachResource extends JsonResource
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
            "id" => $this->id,
            "manuscript" => $this->manuscript,
            "type" => collect(ManuscriptAttachFile::$types)->where('id', $this->type)->first(),
            "description" => $this->description,
            "file_name" => $this->file_name,
            "file_location" => $this->file_location,
            "size" => $this->sizeFormated(),
            "unread_comment_notifications" => $this->unreadCommentNotifications(),
            "created_at" => $this->created_at->diffForHumans(),
            "updated_at" => $this->updated_at->diffForHumans()
        ];
    }
}
