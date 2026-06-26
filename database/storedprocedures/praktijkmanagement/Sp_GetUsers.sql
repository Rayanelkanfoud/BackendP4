DROP PROCEDURE IF EXISTS sp_GetAllUsers;

DELIMITER $$

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
END$$

DELIMITER ;
