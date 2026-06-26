DROP PROCEDURE IF EXISTS sp_GetAllUserroles;

DELIMITER $$

CREATE PROCEDURE sp_GetAllUserroles()
BEGIN
    SELECT 'tandarts' AS rolename
    UNION SELECT 'mondhygienist'
    UNION SELECT 'assistent'
    UNION SELECT 'praktijkmanagement'
    UNION SELECT 'patient';
END$$

DELIMITER ;
