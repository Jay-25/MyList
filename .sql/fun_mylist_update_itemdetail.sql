CREATE OR REPLACE FUNCTION "public"."fun_mylist_update_itemdetail"(p_uid int8, p_iid int8, p_ids text, p_cids text, p_names text, p_selecteds text)
  RETURNS "pg_catalog"."int8" AS $BODY$DECLARE
  a_ids VARCHAR[];
  a_cids VARCHAR[];
  a_names VARCHAR[];
  a_selecteds VARCHAR[];
  v_len INTEGER;
  v_i  INTEGER DEFAULT 1;
  v_version INTEGER;
BEGIN
    DELETE FROM tab_mylist_itemdetail WHERE iid = p_iid;
		
		a_ids = regexp_split_to_array(p_ids,',');
		a_cids = regexp_split_to_array(p_cids,',');
		a_names = regexp_split_to_array(p_names,',');
		a_selecteds = regexp_split_to_array(p_selecteds,',');
		
		v_len = array_length(a_ids, 1);
		WHILE v_i <= v_len LOOP
			INSERT INTO tab_mylist_itemdetail(id, iid, cid, name, selected) VALUES (a_ids[v_i]::INT8,p_iid,a_cids[v_i]::INT8,a_names[v_i],a_selecteds[v_i]::INT4);
			v_i = v_i + 1;
		END LOOP;

  SELECT itemversion INTO v_version FROM tab_mylist_userversion WHERE uid = p_uid;
  iF(v_version IS NULL) THEN
      INSERT INTO tab_mylist_userversion(uid) VALUES (p_uid);
      v_version = 1;
  ELSE
      v_version = v_version + 1;
      UPDATE tab_mylist_userversion SET itemversion = v_version WHERE uid = p_uid;
  END IF;

	RETURN 1;
END
$BODY$
  LANGUAGE 'plpgsql' VOLATILE COST 100
;

ALTER FUNCTION "public"."fun_mylist_update_itemdetail"(p_uid int8, p_iid int8, p_ids text, p_cids text, p_names text, p_selecteds text) OWNER TO "postgres";