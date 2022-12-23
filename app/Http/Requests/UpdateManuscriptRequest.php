<?php

namespace App\Http\Requests;

use App\Models\Manuscript;
use Illuminate\Foundation\Http\FormRequest;

class UpdateManuscriptRequest extends FormRequest
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
            'type' => 'required|integer',
            'category' => 'nullable',
            'title' => 'required',
            'short_title' => 'nullable',
            'abstract' => 'nullable',
            'keywords' => 'nullable',
            'authors' => 'nullable|array',
            'corresponding_authors' => 'nullable|array',
            'editors' => 'nullable|array|between:0,1',
            'reviewers' => 'nullable|array',
            'funding_information' => 'nullable',
            'is_confirm_grant_numbers' => 'required|boolean',
            'is_acknowledge' => 'required|boolean',
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
}
