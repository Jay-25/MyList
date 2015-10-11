CREATE OR REPLACE FUNCTION "public"."fun_mylist_update_item"(p_uid int8, p_id int8, p_name varchar)
  RETURNS "pg_catalog"."int8" AS $BODY$DECLARE
  v_id INTEGER;
  v_version INTEGER;
BEGIN
    IF(p_id<0) THEN
        SELECT nextval('tab_mylist_item_id_seq'::regclass) INTO v_id;
        INSERT INTO tab_mylist_item(id, uid, name) VALUES (v_id, p_uid, p_name);
    ELSE
        v_id = p_id;
		IF(length(p_name)=0 OR p_name IS NULL) THEN
            UPDATE tab_mylist_item SET valid = 0 WHERE id = p_id AND uid = p_uid;
        ELSE
            UPDATE tab_mylist_item SET name = p_name WHERE id = p_id AND uid = p_uid;
        END IF;
    END IF;

  SELECT itemversion INTO v_version FROM tab_mylist_userversion WHERE uid = p_uid;
  iF(v_version IS NULL) THEN
      INSERT INTO tab_mylist_userversion(uid) VALUES (p_uid);
      v_version = 1;
  ELSE
      v_version = v_version + 1;
      UPDATE tab_mylist_userversion SET itemversion = v_version WHERE uid = p_uid;
  END IF;

	RETURN v_id;
END
$BODY$
  LANGUAGE 'plpgsql' VOLATILE COST 100
;

ALTER FUNCTION "public"."fun_mylist_update_item"(p_uid int8, p_id int8, p_name varchar) OWNER TO "postgres";