DROP PROCEDURE IF EXISTS SP_GetAllergeenById;

DELIMITER $$

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
END$$

DELIMITER ;
