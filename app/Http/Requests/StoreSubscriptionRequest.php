<?php

namespace App\Http\Requests;

use App\MailchimpManager;
use App\Models\EmailSubscription;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
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
            'email' => 'required|email|unique:email_subscription,email'
        ];
    }

    public function store()
    {
        $model = new EmailSubscription();
        $model->email = $this->email;
        $model->status = 'pending';

        if($model->save()) {
            $syncResult = app('mailchimpmanager')->subscribe($this->email);

            if($syncResult) {
                $model->hash = $syncResult;
                $model->status = 'subscribed';
                $model->save();
            }
        }

        return true;
    }
}
