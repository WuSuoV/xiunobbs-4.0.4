ALTER TABLE bbs_forum ADD COLUMN  announcement text NOT NULL;
ALTER TABLE bbs_post ADD COLUMN  message_fmt longtext NOT NULL;