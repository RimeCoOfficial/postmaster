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
  email_id                varchar(256)        NOT NULL  UNIQUE,
  state                   varchar(32)                   DEFAULT NULL, -- latest status: delivery, bounce, complaint
  type                    varchar(64)                   DEFAULT NULL,
  timestamp               datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  message_json            text                          DEFAULT NULL,
  PRIMARY KEY (email_id)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table message
--

CREATE TABLE IF NOT EXISTS message (
  message_id              int                 NOT NULL  AUTO_INCREMENT,
  owner                   varchar(16)         NOT NULL,

  subject                 varchar(128)        NOT NULL  COLLATE utf8mb4_unicode_ci,
  body_html_input         text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  body_html               text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  body_text               text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,

  reply_to_name           varchar(128)                  DEFAULT NULL,
  reply_to_email          varchar(256)                  DEFAULT NULL,

  ga_campaign_query       varchar(256)                  DEFAULT NULL,
  list_unsubscribe        tinyint(1)          NOT NULL  DEFAULT 0,
  
  published               datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  archived                datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',

  created                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (message_id)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table message_request
--

CREATE TABLE IF NOT EXISTS message_request (
  request_id              int                 NOT NULL  AUTO_INCREMENT,
  message_id              int                 NOT NULL,
  to_name                 varchar(64)                   DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  to_email                varchar(256)        NOT NULL,
  pseudo_vars_json         text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  processed               datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  created                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (request_id),
  FOREIGN KEY (message_id) REFERENCES message(message_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table message_archive
--

CREATE TABLE IF NOT EXISTS message_archive (
  request_id              int                 NOT NULL,
  web_version_key         varchar(64)         NOT NULL,
  unsubscribe_key         varchar(64)         NOT NULL,
  from_name               varchar(64)                   DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  from_email              varchar(256)        NOT NULL,
  to_name                 varchar(64)                   DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  to_email                varchar(256)        NOT NULL,
  reply_to_name           varchar(64)                   DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  reply_to_email          varchar(256)                  DEFAULT NULL,
  subject                 varchar(128)        NOT NULL  COLLATE utf8mb4_unicode_ci,
  body_html               text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  body_text               text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  list_unsubscribe        tinyint(1)          NOT NULL  DEFAULT 0,
  priority                tinyint unsigned              DEFAULT 0,
  sent                    datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  amzn_message_id         varchar(256)                  DEFAULT NULL,
  PRIMARY KEY (request_id),
  FOREIGN KEY (request_id) REFERENCES message_request(request_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table list
--

CREATE TABLE IF NOT EXISTS list (
  list_id                 int                 NOT NULL  AUTO_INCREMENT,
  name                    varchar(32)                   DEFAULT NULL,
  unsubscribe_link        varchar(256)                  DEFAULT NULL,
  PRIMARY KEY (list_id)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

INSERT INTO `ci_postmaster`.`list` (`name`) VALUES
  -- @debug: do not remove ✊
  ('debug'),
  -- Camapaign
  ('announcement'), ('newsletter'), ('debug'),
  -- Autoresponder
  ('requested-invitation'), ('tips'), ('debug'),
  -- Transactional
  ('auth'), ('notification'), ('report'), ('invite'), ('debug');

-- --------------------------------------------------------

--
-- Table structure for table list_subscribed
--

CREATE TABLE IF NOT EXISTS list_subscribed (
  to_name                 varchar(64)         NOT NULL,
  to_email                varchar(256)        NOT NULL,
  list_id                 int                 NOT NULL  AUTO_INCREMENT,
  uid                     varchar(64)                   DEFAULT NULL,
  -- subscribed              datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP, -- DEFAULT '1000-01-01 00:00:00',
  unsubscribed            datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  updated                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (email_id, list_id),
  FOREIGN KEY (list_id) REFERENCES list(list_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table autoresponder (drip campaign)
--

CREATE TABLE IF NOT EXISTS autoresponder (
  message_id              int                 NOT NULL,
  list_id                 int                 NOT NULL,
  time_str                varchar(64)                   DEFAULT NULL, -- now, +1 day http://php.net/manual/en/function.strtotime.php
  PRIMARY KEY (message_id),
  FOREIGN KEY (list_id) REFERENCES list(list_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (message_id) REFERENCES message(message_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table campaign
--

CREATE TABLE IF NOT EXISTS campaign (
  message_id              int                 NOT NULL,
  list_id                 int                 NOT NULL,
  PRIMARY KEY (message_id),
  FOREIGN KEY (list_id) REFERENCES list(list_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (message_id) REFERENCES message(message_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table transactional
--

CREATE TABLE IF NOT EXISTS transactional (
  message_id              int                 NOT NULL,
  list_id                 int                 NOT NULL,
  PRIMARY KEY (message_id),
  FOREIGN KEY (list_id) REFERENCES list(list_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (message_id) REFERENCES message(message_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;
