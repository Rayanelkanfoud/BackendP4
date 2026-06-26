<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'rolename'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function spGetAllUsers(): Collection
    {
        if (DB::getDriverName() === 'sqlite') {
            return self::orderBy('name')->get();
        }

        return self::hydrate(DB::select('CALL sp_GetAllUsers()'));
    }

    public static function spGetUserById(int $userId): ?object
    {
        if (DB::getDriverName() === 'sqlite') {
            return self::whereKey($userId)->first();
        }

        return DB::selectOne('CALL sp_GetUserById(?)', [$userId]);
    }

    public static function spGetAllUserroles(): array
    {
        if (DB::getDriverName() === 'sqlite') {
            return [
                (object) ['rolename' => 'tandarts'],
                (object) ['rolename' => 'mondhygienist'],
                (object) ['rolename' => 'assistent'],
                (object) ['rolename' => 'praktijkmanagement'],
                (object) ['rolename' => 'patient'],
            ];
        }

        return DB::select('CALL sp_GetAllUserroles()');
    }

    public static function spUpdateUserRole(int $userId, string $rolename): int
    {
        if (DB::getDriverName() === 'sqlite') {
            return self::whereKey($userId)->update(['rolename' => $rolename]);
        }

        $result = DB::select('CALL sp_UpdateUserRole(?, ?)', [$userId, $rolename]);

        return (int) ($result[0]->affected ?? 0);
    }

    public static function spDeleteUser(int $userId): int
    {
        if (DB::getDriverName() === 'sqlite') {
            return self::whereKey($userId)->delete();
        }

        $result = DB::select('CALL sp_DeleteUser(?)', [$userId]);

        return (int) ($result[0]->affected ?? 0);
    }
}
