DROP PROCEDURE IF EXISTS sp_UpdateUserRole;

DELIMITER $$

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
END$$

DELIMITER ;
