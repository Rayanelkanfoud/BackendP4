DROP PROCEDURE IF EXISTS SP_DeleteAllergeen;

DELIMITER $$

CREATE PROCEDURE SP_DeleteAllergeen(
    IN p_id BIGINT
)
BEGIN
    DELETE FROM Allergenen
    WHERE Id = p_id;

    SELECT ROW_COUNT() AS affected;
END$$

DELIMITER ;
