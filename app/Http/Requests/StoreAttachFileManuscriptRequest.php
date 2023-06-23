<?php

namespace App\Http\Requests;

use App\Models\Manuscript;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAttachFileManuscriptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('manuscripts.edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');
        $type = $this->type;
        return [
            'type' => ['required', ($type == 1 ? Rule::unique('manuscript_attach_files')->where(function ($query) use($id, $type) {
                return $query->where('manuscript_id', $id)
                    ->where('type', $type)
                    ->where('deleted_at', null);
            }) : 'integer')],
            'file' => ['required', $type == 14 ? 'mimes:pdf' : 'mimes:doc,docx,pdf']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'type.unique' => $this->isManuscript() ? 'Manuscript attach type already exists.' : 'The type has already been taken.',
        ];
    }

    public function isManuscript()
    {
        return $this->type == 1;
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
            if ($this->isReviewer()) {
                if (!($this->isManuscript() || $this->isHighlightsForReview())) {
                    $validator->errors()->add('type', 'Reviewer can only upload file attach type "Manuscript" or "Highlight for review" only.');
                }
            }
        });
    }

    public function isReviewer()
    {
        return Manuscript::select('id')->find($this->route('id'))?->authIsReviewer();
    }

    public function isHighlightsForReview()
    {
        return $this->type == 2;
    }
}
