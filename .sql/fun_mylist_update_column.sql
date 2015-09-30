CREATE OR REPLACE FUNCTION "public"."fun_mylist_update_column"(p_id int8, p_cid int8, p_name int8, p_custom_id int8)
  RETURNS "pg_catalog"."int8" AS $BODY$DECLARE
  v_id INTEGER;
  v_version INTEGER;
BEGIN
	IF(p_id<0) THEN
      SELECT nextval('tab_mylist_columndetail_id_seq'::regclass) INTO v_id;
      INSERT INTO tab_mylist_columndetail(id, cid, name, custom_id) VALUES (v_id, p_cid, p_name, p_custom_id);
  ELSE
      v_id = p_id;
			UPDATE tab_mylist_columndetail
         SET name=p_name
      WHERE id = v_id AND custom_id = p_custom_id AND p_custom_id > 0;
  END IF;

  SELECT columnversion INTO v_version FROM tab_mylist_userversion WHERE uid = p_custom_id;
  iF(v_version IS NULL) THEN
      INSERT INTO tab_mylist_userversion(uid) VALUES (p_custom_id);
      v_version = 1;
  ELSE
      v_version = v_version + 1;
      UPDATE tab_mylist_userversion SET columnversion = v_version WHERE uid = p_custom_id;
  END IF;

	RETURN v_id;
END
$BODY$
  LANGUAGE 'plpgsql' VOLATILE COST 100
;

ALTER FUNCTION "public"."fun_mylist_update_column"(p_id int8, p_cid int8, p_name int8, p_custom_id int8) OWNER TO "postgres";