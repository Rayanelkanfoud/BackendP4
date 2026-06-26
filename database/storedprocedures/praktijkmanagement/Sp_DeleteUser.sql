DROP PROCEDURE IF EXISTS sp_DeleteUser;

DELIMITER $$

CREATE PROCEDURE sp_DeleteUser(
    IN p_id BIGINT
)
BEGIN
    DELETE FROM users
    WHERE id = p_id;

    SELECT ROW_COUNT() AS affected;
END$$

DELIMITER ;
