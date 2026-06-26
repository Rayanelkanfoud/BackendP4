<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetAllUsers');
        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_GetAllUsers()
BEGIN
    SELECT id
          ,name
          ,email
          ,rolename
          ,email_verified_at
          ,created_at
          ,updated_at
    FROM users
    ORDER BY name;
END
SQL);

        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetUserById');
        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_GetUserById(
    IN p_id BIGINT
)
BEGIN
    SELECT id
          ,name
          ,email
          ,rolename
          ,email_verified_at
          ,created_at
          ,updated_at
    FROM users
    WHERE id = p_id
    LIMIT 1;
END
SQL);

        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetAllUserroles');
        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_GetAllUserroles()
BEGIN
    SELECT 'tandarts' AS rolename
    UNION SELECT 'mondhygienist'
    UNION SELECT 'assistent'
    UNION SELECT 'praktijkmanagement'
    UNION SELECT 'patient';
END
SQL);

        DB::unprepared('DROP PROCEDURE IF EXISTS sp_UpdateUserRole');
        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_UpdateUserRole(
    IN p_id BIGINT,
    IN p_rolename VARCHAR(20)
)
BEGIN
    UPDATE users
    SET rolename = p_rolename,
        updated_at = NOW()
    WHERE id = p_id;

    SELECT ROW_COUNT() AS affected;
END
SQL);

        DB::unprepared('DROP PROCEDURE IF EXISTS sp_DeleteUser');
        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_DeleteUser(
    IN p_id BIGINT
)
BEGIN
    DELETE FROM users
    WHERE id = p_id;

    SELECT ROW_COUNT() AS affected;
END
SQL);

        DB::unprepared('DROP PROCEDURE IF EXISTS SP_GetAllAllergenen');
        DB::unprepared(<<<'SQL'
CREATE PROCEDURE SP_GetAllAllergenen()
BEGIN
    SELECT ALGE.Id
          ,ALGE.Naam
          ,ALGE.Omschrijving
    FROM Allergenen AS ALGE;
END
SQL);

        DB::unprepared('DROP PROCEDURE IF EXISTS SP_CreateAllergeen');
        DB::unprepared(<<<'SQL'
CREATE PROCEDURE SP_CreateAllergeen(
    IN p_naam VARCHAR(100),
    IN p_omschrijving VARCHAR(255)
)
BEGIN
    INSERT INTO Allergenen (Naam, Omschrijving)
    VALUES (p_naam, p_omschrijving);

    SELECT LAST_INSERT_ID() AS new_id;
END
SQL);

        DB::unprepared('DROP PROCEDURE IF EXISTS SP_GetAllergeenById');
        DB::unprepared(<<<'SQL'
CREATE PROCEDURE SP_GetAllergeenById(
    IN p_id BIGINT
)
BEGIN
    SELECT ALGE.Id
          ,ALGE.Naam
          ,ALGE.Omschrijving
    FROM Allergenen AS ALGE
    WHERE ALGE.Id = p_id
    LIMIT 1;
END
SQL);

        DB::unprepared('DROP PROCEDURE IF EXISTS SP_DeleteAllergeen');
        DB::unprepared(<<<'SQL'
CREATE PROCEDURE SP_DeleteAllergeen(
    IN p_id BIGINT
)
BEGIN
    DELETE FROM Allergenen
    WHERE Id = p_id;

    SELECT ROW_COUNT() AS affected;
END
SQL);

        DB::unprepared('DROP PROCEDURE IF EXISTS SP_UpdateAllergeen');
        DB::unprepared(<<<'SQL'
CREATE PROCEDURE SP_UpdateAllergeen(
    IN p_id BIGINT,
    IN p_naam VARCHAR(100),
    IN p_omschrijving VARCHAR(255)
)
BEGIN
    UPDATE Allergenen
    SET Naam = p_naam,
        Omschrijving = p_omschrijving
    WHERE Id = p_id;

    SELECT ROW_COUNT() AS affected;
END
SQL);
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::unprepared('DROP PROCEDURE IF EXISTS SP_UpdateAllergeen');
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_DeleteAllergeen');
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_GetAllergeenById');
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_CreateAllergeen');
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_GetAllAllergenen');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_DeleteUser');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_UpdateUserRole');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetAllUserroles');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetUserById');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetAllUsers');
    }
};
