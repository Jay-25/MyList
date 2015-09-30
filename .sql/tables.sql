/*
Navicat PGSQL Data Transfer

Source Server         : 115.28.76.20
Source Server Version : 90304
Source Host           : 115.28.76.20:5432
Source Database       : mydb
Source Schema         : public

Target Server Type    : PGSQL
Target Server Version : 90304
File Encoding         : 65001

Date: 2015-09-30 17:36:43
*/


-- ----------------------------
-- Table structure for tab_mylist_column
-- ----------------------------
DROP TABLE IF EXISTS "public"."tab_mylist_column";
CREATE TABLE "public"."tab_mylist_column" (
"id" int8 DEFAULT nextval('tab_mylist_column_id_seq'::regclass) NOT NULL,
"name" varchar(64) COLLATE "default" NOT NULL,
"sort" int4 DEFAULT 0
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Table structure for tab_mylist_columndetail
-- ----------------------------
DROP TABLE IF EXISTS "public"."tab_mylist_columndetail";
CREATE TABLE "public"."tab_mylist_columndetail" (
"id" int8 DEFAULT nextval('tab_mylist_columndetail_id_seq'::regclass) NOT NULL,
"cid" int8 NOT NULL,
"name" varchar(128) COLLATE "default" NOT NULL,
"custom_id" int8 DEFAULT 0 NOT NULL,
"sort" int4 DEFAULT 999
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Table structure for tab_mylist_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."tab_mylist_item";
CREATE TABLE "public"."tab_mylist_item" (
"id" int8 DEFAULT nextval('tab_mylist_item_id_seq'::regclass) NOT NULL,
"uid" int8 NOT NULL,
"name" varchar(64) COLLATE "default" NOT NULL,
"bell" timestamp(6),
"godate" timestamp(6),
"backdate" timestamp(6),
"timestamp" timestamp(6) DEFAULT now() NOT NULL,
"valid" int2 DEFAULT 1 NOT NULL
)
WITH (OIDS=FALSE)

;
COMMENT ON COLUMN "public"."tab_mylist_item"."id" IS '清单ID';
COMMENT ON COLUMN "public"."tab_mylist_item"."uid" IS '所属用户ID';
COMMENT ON COLUMN "public"."tab_mylist_item"."name" IS '清单名字';
COMMENT ON COLUMN "public"."tab_mylist_item"."bell" IS '提醒时间';
COMMENT ON COLUMN "public"."tab_mylist_item"."godate" IS '出发时间';
COMMENT ON COLUMN "public"."tab_mylist_item"."backdate" IS '返回时间';
COMMENT ON COLUMN "public"."tab_mylist_item"."timestamp" IS '本清单的创建时间';
COMMENT ON COLUMN "public"."tab_mylist_item"."valid" IS '清单是否被删除';

-- ----------------------------
-- Table structure for tab_mylist_itemdetail
-- ----------------------------
DROP TABLE IF EXISTS "public"."tab_mylist_itemdetail";
CREATE TABLE "public"."tab_mylist_itemdetail" (
"id" int8 NOT NULL,
"iid" int8 NOT NULL,
"cid" int8 NOT NULL,
"name" varchar(128) COLLATE "default" NOT NULL,
"selected" int2 DEFAULT 0 NOT NULL
)
WITH (OIDS=FALSE)

;
COMMENT ON COLUMN "public"."tab_mylist_itemdetail"."id" IS '清单细则ID';
COMMENT ON COLUMN "public"."tab_mylist_itemdetail"."iid" IS 'ITEM-ID';
COMMENT ON COLUMN "public"."tab_mylist_itemdetail"."cid" IS 'COLUMN-ID';
COMMENT ON COLUMN "public"."tab_mylist_itemdetail"."name" IS '清单细则项的名称';
COMMENT ON COLUMN "public"."tab_mylist_itemdetail"."selected" IS '是否已选择';

-- ----------------------------
-- Table structure for tab_mylist_user
-- ----------------------------
DROP TABLE IF EXISTS "public"."tab_mylist_user";
CREATE TABLE "public"."tab_mylist_user" (
"id" int8 DEFAULT nextval('tab_mylist_user_id_seq'::regclass) NOT NULL,
"cuid" varchar(255) COLLATE "default" NOT NULL,
"username" varchar(255) COLLATE "default",
"password" varchar(255) COLLATE "default",
"tel" varchar(32) COLLATE "default",
"email" varchar(255) COLLATE "default",
"weixin" varchar(255) COLLATE "default",
"qq" varchar(255) COLLATE "default",
"sina" varchar(255) COLLATE "default"
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Table structure for tab_mylist_userversion
-- ----------------------------
DROP TABLE IF EXISTS "public"."tab_mylist_userversion";
CREATE TABLE "public"."tab_mylist_userversion" (
"uid" int8 NOT NULL,
"columnversion" int8 DEFAULT 1,
"itemversion" int8 DEFAULT 1
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table tab_mylist_column
-- ----------------------------
ALTER TABLE "public"."tab_mylist_column" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table tab_mylist_columndetail
-- ----------------------------
CREATE INDEX "tab_mylist_columndetail_cid_custom_idx" ON "public"."tab_mylist_columndetail" USING btree (cid, custom_id);

-- ----------------------------
-- Primary Key structure for table tab_mylist_columndetail
-- ----------------------------
ALTER TABLE "public"."tab_mylist_columndetail" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table tab_mylist_item
-- ----------------------------
CREATE INDEX "tab_mylist_item_uid_bell_godate_valid_idx" ON "public"."tab_mylist_item" USING btree (uid, bell, godate, valid);

-- ----------------------------
-- Primary Key structure for table tab_mylist_item
-- ----------------------------
ALTER TABLE "public"."tab_mylist_item" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table tab_mylist_itemdetail
-- ----------------------------
CREATE INDEX "tab_mylist_itemdetail_id_iid_cid_selected_idx" ON "public"."tab_mylist_itemdetail" USING btree (id, iid, cid, selected);

-- ----------------------------
-- Uniques structure for table tab_mylist_user
-- ----------------------------
ALTER TABLE "public"."tab_mylist_user" ADD UNIQUE ("email");
ALTER TABLE "public"."tab_mylist_user" ADD UNIQUE ("weixin");
ALTER TABLE "public"."tab_mylist_user" ADD UNIQUE ("qq");
ALTER TABLE "public"."tab_mylist_user" ADD UNIQUE ("sina");
ALTER TABLE "public"."tab_mylist_user" ADD UNIQUE ("cuid");

-- ----------------------------
-- Primary Key structure for table tab_mylist_user
-- ----------------------------
ALTER TABLE "public"."tab_mylist_user" ADD PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table tab_mylist_userversion
-- ----------------------------
ALTER TABLE "public"."tab_mylist_userversion" ADD PRIMARY KEY ("uid");
