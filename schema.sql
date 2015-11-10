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
-- Table structure for table list
--

CREATE TABLE IF NOT EXISTS list (
  list_id                 int                 NOT NULL  AUTO_INCREMENT,
  id                      varchar(32)                   DEFAULT NULL,
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table list_subscribed
--

CREATE TABLE IF NOT EXISTS list_subscribed (
  email_id
  list_id
  unsubscribed            tinyint(1)          NOT NULL  DEFAULT 0,
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table campaign
--

CREATE TABLE IF NOT EXISTS campaign (
  campaign_id             int                 NOT NULL  AUTO_INCREMENT,
  title                   varchar(128)        NOT NULL  COLLATE utf8mb4_unicode_ci,
  description             text                          DEFAULT NULL COLLATE utf8mb4_unicode_ci,
  html                    text                          DEFAULT NULL COLLATE utf8mb4_unicode_ci,
  txt                     text                          DEFAULT NULL COLLATE utf8mb4_unicode_ci,
  tumblr_html             text                          DEFAULT NULL COLLATE utf8mb4_unicode_ci,
  tumblr_post_id          varchar(256)                  DEFAULT NULL,
  email_sent_at           datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',
  status                  varchar(16)                   DEFAULT NULL, -- in_progress
  created                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP,
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table campaign_list
--

CREATE TABLE IF NOT EXISTS campaign_list (
  campaign_id
  list_ids
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table category
--

CREATE TABLE IF NOT EXISTS category (
  category_id             int                 NOT NULL  AUTO_INCREMENT,
  name                    varchar(64)         NOT NULL  UNIQUE,
  color                   varchar(8)                    DEFAULT NULL,
  PRIMARY KEY (category_id)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table transaction
--

CREATE TABLE IF NOT EXISTS transaction (
  transaction_id          int                 NOT NULL  AUTO_INCREMENT,
  category_id             int                           DEFAULT NULL,

  is_archived             tinyint(1)          NOT NULL  DEFAULT 0,

  reply_to_name           varchar(128)                  DEFAULT NULL,
  reply_to_email          varchar(256)                  DEFAULT NULL,

  subject                 varchar(128)        NOT NULL  COLLATE utf8mb4_unicode_ci,
  body_html               text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,

  created                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (transaction_id),
  FOREIGN KEY (category_id) REFERENCES category(category_id) ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table transaction_history
--

CREATE TABLE IF NOT EXISTS transaction_history (
  unique_id               int                 NOT NULL  AUTO_INCREMENT,
  transaction_id          int                 NOT NULL,
  data                    text                          DEFAULT NULL  COLLATE utf8mb4_unicode_ci,
  created                 datetime            NOT NULL  DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (unique_id),
  FOREIGN KEY (transaction_id) REFERENCES transaction(transaction_id) ON UPDATE CASCADE ON DELETE CASCADE
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
  PRIMARY KEY (service, x_account_id)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table send
--

CREATE TABLE IF NOT EXISTS send (
  unique_id               int                 NOT NULL  AUTO_INCREMENT,
  from_email_id
  from_name
  from_email_id
  to_name
  subject
  body

  -- proirity
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;
