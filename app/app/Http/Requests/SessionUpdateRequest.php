<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\Contracts\SessionInterface;

class SessionUpdateRequest extends FormRequest
{
    private $sessionService;
    public function __construct(SessionInterface $sessionService)
    {
        $this->sessionService = $sessionService;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        $this->sessionService->validate();

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
            'fcmToken' => 'string'
        ];
    }
}
