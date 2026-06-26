DROP PROCEDURE IF EXISTS sp_GetUserById;

DELIMITER $$

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
END$$

DELIMITER ;
