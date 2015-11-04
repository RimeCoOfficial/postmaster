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
-- Table structure for table status
--

CREATE TABLE IF NOT EXISTS status (
  email_id                varchar(256)        NOT NULL  UNIQUE,
  -- name                    varchar(256)                  DEFAULT NULL,

  -- latest status
  status                  varchar(32)                   DEFAULT NULL, -- delivery, bounce, complaint
  status_type             varchar(32)                   DEFAULT NULL,
  status_timestamp        datetime            NOT NULL  DEFAULT '1000-01-01 00:00:00',

  status_json             text                          DEFAULT NULL,
  PRIMARY KEY (email_id)
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table list
--

CREATE TABLE IF NOT EXISTS list (
  id                      varchar(32)                   DEFAULT NULL,

  -- -- unsubscribtion category
  -- campaign                tinyint(1)          NOT NULL  DEFAULT 0,
  -- tips                    tinyint(1)          NOT NULL  DEFAULT 0,
  -- newsletter              tinyint(1)          NOT NULL  DEFAULT 0,
  -- notification            tinyint(1)          NOT NULL  DEFAULT 0,
  -- promotion               tinyint(1)          NOT NULL  DEFAULT 0,
  -- announcement            tinyint(1)          NOT NULL  DEFAULT 0,
  -- digest                  tinyint(1)          NOT NULL  DEFAULT 0,
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table list_subscribed
--

CREATE TABLE IF NOT EXISTS list_subscribed (
  unsubscribed              tinyint(1)          NOT NULL  DEFAULT 0,
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;

-- --------------------------------------------------------

--
-- Table structure for table campaign
--

CREATE TABLE IF NOT EXISTS campaign (
  news_id                 int                 NOT NULL  AUTO_INCREMENT,
  title                   varchar(256)        NOT NULL  COLLATE utf8mb4_unicode_ci,
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
-- Table structure for table send
--

CREATE TABLE IF NOT EXISTS tumblr (
  news_id                 int                 NOT NULL  AUTO_INCREMENT,
  title                   varchar(256)        NOT NULL  COLLATE utf8mb4_unicode_ci,
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
-- Table structure for table send
--

CREATE TABLE IF NOT EXISTS send (
) ENGINE=InnoDB  DEFAULT CHARSET=ascii COLLATE=ascii_bin;
