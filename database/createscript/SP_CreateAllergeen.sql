DROP PROCEDURE IF EXISTS SP_CreateAllergeen;

DELIMITER $$

CREATE PROCEDURE SP_CreateAllergeen(
    IN p_naam VARCHAR(100),
    IN p_omschrijving VARCHAR(255)
)
BEGIN
    INSERT INTO Allergenen (Naam, Omschrijving)
    VALUES (p_naam, p_omschrijving);

    SELECT LAST_INSERT_ID() AS new_id;
END$$

DELIMITER ;
