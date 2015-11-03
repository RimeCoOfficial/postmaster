-- CREATE DATABASE IF NOT EXISTS ci_email;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ci_email`
--

-- --------------------------------------------------------

--
-- Table structure for table ci_session
--

CREATE TABLE IF NOT EXISTS ci_session (
  session_id              varchar(40)         NOT NULL  DEFAULT 0,
  id                      varchar(40)         NOT NULL,
  ip_address              varchar(45)         NOT NULL,
  timestamp               int unsigned        NOT NULL  DEFAULT 0,
  data                    blob                NOT NULL,
  PRIMARY KEY (id),
  KEY ci_sessions_timestamp (timestamp)
) ENGINE=InnoDB DEFAULT CHARSET=ascii COLLATE=ascii_bin;
