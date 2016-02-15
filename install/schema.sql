-- CREATE DATABASE IF NOT EXISTS ci_postmaster;

--
-- Database: `ci_postmaster`
--

-- --------------------------------------------------------

--
-- Table structure for table ci_sessions
--

CREATE TABLE IF NOT EXISTS ci_sessions (
  session_id              varchar(40)         NOT NULL  DEFAULT 0,
  id                      varchar(40)         NOT NULL,
  ip_address              varchar(45)         NOT NULL,
  timestamp               int unsigned        NOT NULL  DEFAULT 0,
  data                    blob                NOT NULL,
  PRIMARY KEY (id),
  KEY ci_sessions_timestamp (timestamp)
) ENGINE=InnoDB DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table feedback
--

CREATE TABLE IF NOT EXISTS feedback (
  to_email                varchar(128)        NOT NULL,
  type                    varchar(16)                   DEFAULT NULL, -- latest status: delivery, bounce, complaint
  sub_type                varchar(64)                   DEFAULT NULL,
  recieved                datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  PRIMARY KEY (to_email)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table list_unsubscribe
--

CREATE TABLE IF NOT EXISTS list_unsubscribe (
  list_id                 int                 NOT NULL  AUTO_INCREMENT,
  list                    varchar(32)         NOT NULL,
  type                    varchar(16)         NOT NULL,                 -- autoresponder, campaign, transactional
  created                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (list_id)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

INSERT INTO `ci_postmaster`.`list_unsubscribe` (`list`, `type`) VALUES
  -- Transactional
  ('Report', 'transactional'), ('Account', 'transactional'), ('Notification', 'transactional'), ('Invite', 'transactional'), ('Request sign-up', 'transactional'),
  -- Camapaign
  ('Announcement', 'campaign'), ('Newsletter', 'campaign'),
  -- Autoresponder
  ('Requested sign-up', 'autoresponder'), ('Tips', 'autoresponder');

-- --------------------------------------------------------

--
-- Table structure for table recipient
--

-- autoresponder  - user_id + user_metadata     - (un)subscribe
-- campaign       - user_metadata + user_id     - (un)subscribe
-- transactional  - user    - email_id + name + user_id
--                - visitor - email_id + name + md5(email_id)

CREATE TABLE IF NOT EXISTS recipient (
  auto_recipient_id       int                 NOT NULL  AUTO_INCREMENT UNIQUE,  -- for internal use only
  recipient_id            varchar(512)        NOT NULL,                         -- ga_uid
  to_name                 varchar(128)                  DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  to_email                varchar(256)        NOT NULL,
  list_id                 int                 NOT NULL,
  unsubscribed            datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  metadata_json           text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci, -- for campaign, autoresponder
  metadata_updated        datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  updated                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  created                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP,                -- for autoresponder
  PRIMARY KEY (recipient_id, list_id),
  FOREIGN KEY (list_id) REFERENCES list_unsubscribe(list_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table message
--

CREATE TABLE IF NOT EXISTS message (
  message_id              int                 NOT NULL  AUTO_INCREMENT,
  list_id                 int                 NOT NULL,

  subject                 varchar(128)        NOT NULL  COLLATE utf8mb4_unicode_ci,
  body_html_input         text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  body_html               text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  body_text               text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,

  reply_to_name           varchar(128)                  DEFAULT NULL,
  reply_to_email          varchar(256)                  DEFAULT NULL,

  ga_campaign_query       varchar(256)                  DEFAULT NULL,
  list_unsubscribe        tinyint(1)          NOT NULL  DEFAULT 0,
  
  published_tds           bigint                        DEFAULT NULL, -- tds = Time Difference in Seconds. NULL = Draft

  archived                datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  created                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (message_id),
  FOREIGN KEY (list_id) REFERENCES list_unsubscribe(list_id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table request
--

CREATE TABLE IF NOT EXISTS request (
  request_id              int                 NOT NULL  AUTO_INCREMENT, -- ga_cid
  message_id              int                 NOT NULL,
  auto_recipient_id       int                 NOT NULL,
  to_name                 varchar(128)                  DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  to_email                varchar(256)        NOT NULL,
  pseudo_vars_json        text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  processed               datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  processed_error         varchar(32)                   DEFAULT NULL,       
  created                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (request_id),
  FOREIGN KEY (message_id) REFERENCES message(message_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (auto_recipient_id) REFERENCES recipient(auto_recipient_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table archive
--

CREATE TABLE IF NOT EXISTS archive (
  request_id              int                 NOT NULL,
  web_version_key         varchar(64)         NOT NULL,
  unsubscribe_key         varchar(64)         NOT NULL,
  from_name               varchar(128)                  DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  from_email              varchar(256)        NOT NULL,
  to_name                 varchar(128)                  DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  to_email                varchar(256)        NOT NULL  INDEX,
  reply_to_name           varchar(128)                  DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  reply_to_email          varchar(256)                  DEFAULT NULL,
  subject                 varchar(128)        NOT NULL  COLLATE utf8mb4_unicode_ci,
  body_html               text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  body_text               text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  list_unsubscribe        text                          DEFAULT NULL,
  priority                tinyint unsigned              DEFAULT 0,
  sent                    datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  ses_message_id          varchar(256)                  DEFAULT NULL,
  ses_feedback_json       text                          DEFAULT NULL, -- @todo: store it to s3 and thrash later
  PRIMARY KEY (request_id),
  FOREIGN KEY (request_id) REFERENCES request(request_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;