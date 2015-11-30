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
  owner                   varchar(64)         NOT NULL,

  subject                 varchar(128)        NOT NULL  COLLATE utf8mb4_unicode_ci,
  body_html_ori           text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  body_html               text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,

  reply_to_name           varchar(128)                  DEFAULT NULL,
  reply_to_email          varchar(256)                  DEFAULT NULL,

  tumblr_post_id          varchar(256)                  DEFAULT 0, -- 1 = must be posted or filled
  is_archived             tinyint(1)          NOT NULL  DEFAULT 0,

  created                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (message_id)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table tumblr
--

CREATE TABLE IF NOT EXISTS tumblr (
  x_account_id            varchar(256)        NOT NULL,
  token                   text                NOT NULL,
  token_secret            text                NOT NULL,
  limit_used              int                           DEFAULT 0,

  url                     text                          DEFAULT NULL,

  updated                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  created                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (x_account_id)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table message_history
--

CREATE TABLE IF NOT EXISTS message_history (
  history_id              int                 NOT NULL  AUTO_INCREMENT,
  message_id              int                 NOT NULL,
  to_name                 varchar(64)                   DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  to_email                varchar(256)        NOT NULL,
  subject_var_json        text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  body_var_json           text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  processed               datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  created                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (history_id),
  FOREIGN KEY (message_id) REFERENCES message(message_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table message_send
--

CREATE TABLE IF NOT EXISTS message_send (
  history_id              int                 NOT NULL,
  verify_id               varchar(64)         NOT NULL,
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
  email_sent              datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  amzn_message_id         varchar(256)                  DEFAULT NULL,
  PRIMARY KEY (history_id),
  FOREIGN KEY (history_id) REFERENCES message_history(history_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table list
--

CREATE TABLE IF NOT EXISTS list (
  list_id                 int                 NOT NULL  AUTO_INCREMENT,
  name                    varchar(32)                   DEFAULT NULL,
  PRIMARY KEY (list_id)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

INSERT INTO `ci_postmaster`.`list` (`name`) VALUES ('announcement'), ('request-invitation'), ('newsletter'), ('tips');

-- --------------------------------------------------------

--
-- Table structure for table list_subscribed
--

CREATE TABLE IF NOT EXISTS list_subscribed (
  email_id                varchar(256)        NOT NULL,
  list_id                 int                 NOT NULL  AUTO_INCREMENT,
  subscribed              datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  unsubscribed            datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  created                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP,
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
  email_sent              datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  status                  varchar(16)                   DEFAULT NULL, -- in_progress
  PRIMARY KEY (message_id),
  FOREIGN KEY (list_id) REFERENCES list(list_id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (message_id) REFERENCES message(message_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table label
--

CREATE TABLE IF NOT EXISTS label (
  label_id                int                 NOT NULL  AUTO_INCREMENT,
  name                    varchar(32)         NOT NULL  UNIQUE,
  color                   varchar(8)                    DEFAULT NULL,
  PRIMARY KEY (label_id)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

INSERT INTO `ci_postmaster`.`label` (`name`) VALUES ('auth'), ('feedback'), ('notification'), ('invite'), ('report'), ('test');

-- --------------------------------------------------------

--
-- Table structure for table transaction
--

CREATE TABLE IF NOT EXISTS transaction (
  message_id              int                 NOT NULL,
  label_id                int                           DEFAULT NULL,
  PRIMARY KEY (message_id),
  FOREIGN KEY (label_id) REFERENCES label(label_id) ON UPDATE CASCADE ON DELETE SET NULL,
  FOREIGN KEY (message_id) REFERENCES message(message_id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;
