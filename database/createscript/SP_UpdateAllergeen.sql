DROP PROCEDURE IF EXISTS SP_UpdateAllergeen;

DELIMITER $$

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
END$$

DELIMITER ;
