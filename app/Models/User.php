<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class, "role_user", "user_id", "role_id");
    }

    public function permissions(){
        return $this->roles()->withPivot("permission_id");
    }

    public function addRole($role){
        if (is_string($role)) {
            Role::firstOrCreate(['name' => $role]);
        }
    }

    public function removeRole($role){
        $this->roles()->where('name', $role)?->detach();
    }

    public function syncRoles(array $roles) {
        return $this->roles()->sync($roles);
    }

    public function hasRole($role){
        if(is_string($role) ){
           return $this->roles->contains('name', $role);
        }
        return (bool) $role->intersect($this->roles)->count();
    }

    public function hasPermission($permission){
        if (is_string($permission)) {
            foreach ($this->roles as $role) {
                if ($role->permissions->contains('name', $permission)) {
                    return true;
                }
            }
        }

        foreach ($this->roles as $role) {
            if ($role->permissions->contains($permission)){
                return true;
            }
        }

        return false;
    }

    public function canUse($permission)
    {
        return $this->hasPermission($permission);
    }

    public function hasAllRoles(...$roles)
    {
        foreach ($roles as $role) {
            if (!$this->hasRole($role)){
                return false;
            };
        }

        return true;
    }

    public function hasAnyRole(...$roles){
        foreach ($roles as $role) {
            if ($this->hasRole($role)){
                return true;
            }

            return false;
        }
    }
}
