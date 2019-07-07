<?php

namespace Modules\Users\Models;

use App\Models\MainModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;
use Spatie\Permission\Traits\HasRoles;

class Users extends MainModel
{
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use Notifiable;
    use HasRoles;
    public $rules = [
        'name' => ['required', 'max:255', 'min:1'],
        'email' => ['required', 'max:255', 'email'],
        'password' => ['required_with:password_confirmation', 'same:password_confirmation'],
        'remember_token' => ['nullable', 'string', 'sometimes'],
    ];

    protected $table = 'users';

    protected $guarded = [];

    protected $with = [];

    protected $fillable = [
        'name', 'email', 'password', 'remember_token',
    ];

    public function fill(array $attributes)
    {
        if (isset($attributes['email'])) {
            $this->rules['email'][] = Rule::unique('users', 'email')->ignore($this->id);
        }

        return parent::fill($attributes);
    }
}
