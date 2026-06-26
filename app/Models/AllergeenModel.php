<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

#[Fillable(['Naam', 'Omschrijving'])]
class AllergeenModel extends Model
{
    protected $table = 'Allergenen';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    public static function spGetAllAllergenen(): array
    {
        if (DB::getDriverName() === 'sqlite') {
            return self::orderBy('Naam')->get()->all();
        }

        return DB::select('CALL SP_GetAllAllergenen()');
    }

    public static function spCreateAllergeen(string $naam, ?string $omschrijving): int
    {
        if (DB::getDriverName() === 'sqlite') {
            return (int) self::create([
                'Naam' => $naam,
                'Omschrijving' => $omschrijving,
            ])->getKey();
        }

        $result = DB::select('CALL SP_CreateAllergeen(?, ?)', [$naam, $omschrijving]);

        return (int) ($result[0]->new_id ?? $result[0]->Id ?? 0);
    }

    public static function spGetAllergeenById(int $id): ?object
    {
        if (DB::getDriverName() === 'sqlite') {
            return self::whereKey($id)->first();
        }

        return DB::selectOne('CALL SP_GetAllergeenById(?)', [$id]);
    }

    public static function spDeleteAllergeen(int $id): int
    {
        if (DB::getDriverName() === 'sqlite') {
            return self::whereKey($id)->delete();
        }

        $result = DB::select('CALL SP_DeleteAllergeen(?)', [$id]);

        return (int) ($result[0]->affected ?? 0);
    }

    public static function spUpdateAllergeen(int $id, string $naam, ?string $omschrijving): int
    {
        if (DB::getDriverName() === 'sqlite') {
            return self::whereKey($id)->update([
                'Naam' => $naam,
                'Omschrijving' => $omschrijving,
            ]);
        }

        $result = DB::select('CALL SP_UpdateAllergeen(?, ?, ?)', [$id, $naam, $omschrijving]);

        return (int) ($result[0]->affected ?? 0);
    }
}
