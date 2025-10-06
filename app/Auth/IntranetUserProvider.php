<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class IntranetUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $user = DB::connection('intranet')
            ->table('users')
            ->where('id', $identifier)
            ->where('active', 1)
            ->first();

        if ($user) {
            return $this->getGenericUser($user);
        }

        return null;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $user = DB::connection('intranet')
            ->table('users')
            ->where('id', $identifier)
            ->where('remember_token', $token)
            ->where('active', 1)
            ->first();

        if ($user) {
            return $this->getGenericUser($user);
        }

        return null;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        DB::connection('intranet')
            ->table('users')
            ->where('id', $user->getAuthIdentifier())
            ->update(['remember_token' => $token]);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials) || 
            (count($credentials) === 1 && array_key_exists('password', $credentials))) {
            return null;
        }

        $query = DB::connection('intranet')->table('users');

        foreach ($credentials as $key => $value) {
            if (! str_contains($key, 'password')) {
                $query->where($key, $value);
            }
        }

        // Solo usuarios activos pueden autenticarse
        $query->where('active', 1);

        $user = $query->first();

        if ($user) {
            return $this->getGenericUser($user);
        }

        return null;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $plain = $credentials['password'];

        return Hash::check($plain, $user->getAuthPassword());
    }

    /**
     * Get the generic user.
     *
     * @param  mixed  $user
     * @return \App\Auth\IntranetUser
     */
    protected function getGenericUser($user)
    {
        if (! is_null($user)) {
            return new IntranetUser((array) $user);
        }

        return null;
    }
}
