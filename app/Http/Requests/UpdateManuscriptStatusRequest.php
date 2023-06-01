<?php

namespace App\Http\Requests;

use App\Models\Manuscript;
use Illuminate\Foundation\Http\FormRequest;

class UpdateManuscriptStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'required|in:Draft,Submit For Review,Rejected Invite To Resubmit,Rejected,Accepted Without Changes,Accepted With Minor Changes,Accepted With Major Changes,Published,Submit To Editor'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->canSubmitToEditor()) {
                $validator->errors()->add('status', '"Manuscript", "Cover Letter" and "Plagiarism Report" attached files are required. Please upload the following documents.');
            }
            if ($this->onPublish()) {
                if (!$this->hasManuscriptForPublish()) {
                    $validator->errors()->add('status', 'Unable to preceed. You need to upload "Manuscript (for publish)" attachment file before publish the manuscript.');
                }
            }
        });
    }

    /**
     * 
     * @return boolean
     */
    public function canSubmitToEditor()
    {
        $manuscript = Manuscript::find($this->id);
        if (!empty($manuscript) && $this->status == "Submit To Editor") {
            $attachments = $manuscript->attachments->unique('type')->whereIn('type', [1, 5, 13]);
            if ($attachments->count() != 3) {
                return false;
            }
        }
        return true;
    }

    public function onPublish()
    {
        return strtolower($this->status) == 'published' ? true : false;
    }

    public function hasManuscriptForPublish()
    {
        return empty(Manuscript::find($this->id)?->attachments()->where('type', 14)->first()) ? false : true;
    }
}
