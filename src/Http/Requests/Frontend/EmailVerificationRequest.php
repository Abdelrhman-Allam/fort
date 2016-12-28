<?php

/*
 * NOTICE OF LICENSE
 *
 * Part of the Rinvex Fort Package.
 *
 * This source file is subject to The MIT License (MIT)
 * that is bundled with this package in the LICENSE file.
 *
 * Package: Rinvex Fort Package
 * License: The MIT License (MIT)
 * Link:    https://rinvex.com
 */

namespace Rinvex\Fort\Http\Requests\Frontend;

use Rinvex\Support\Http\Requests\FormRequest;

class EmailVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ((($user = $this->user()) && $user->email_verified) || ($this->get('email') && array_get(app('rinvex.fort.user')->findBy('email', $this->get('email')), 'email_verified'))) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function forbiddenResponse()
    {
        return intend([
            'url'  => '/',
            'with' => ['rinvex.fort.alert.warning' => trans('rinvex/fort::frontend/messages.verification.email.already')],
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Skip validation rules for request validation form
        if ($this->route()->getName() == 'rinvex.fort.frontend.verification.email.request') {
            return [];
        }

        return $this->isMethod('post') ? [
            'email' => 'required|email|max:255|exists:'.config('rinvex.fort.tables.users').',email',
        ] : [
            'token' => 'required|regex:/^[0-9a-zA-Z]+$/',
            'email' => 'required|email|max:255|exists:'.config('rinvex.fort.tables.users').',email',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getRedirectUrl()
    {
        if ($this->isMethod('post')) {
            return parent::getRedirectUrl();
        }

        return route('rinvex.fort.frontend.verification.email.request');
    }
}
