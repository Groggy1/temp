--
-- Tabellstruktur `measurement`
--

CREATE TABLE IF NOT EXISTS `measurement` (
  `sensorID` varchar(20) NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `measurement` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
