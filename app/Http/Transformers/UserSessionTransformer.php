<?php

namespace App\Http\Transformers;

use Illuminate\Contracts\Auth\Authenticatable;

class UserSessionTransformer
{
    /**
     * Transform the user data to return only the necessary fields
     *
     * @param Authenticatable $user
     * @return array
     */
    public function transform(Authenticatable $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
