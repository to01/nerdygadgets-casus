CREATE TABLE IF NOT EXISTS Aanbevolen
(
AanbevolenID	int(11) 	NOT NULL	AUTO_INCREMENT,
StockItemID		int(11)		NOT NULL,
Korting			int(11)		NOT NULL,
primary key		(AanbevolenID)
);

ALTER TABLE aanbevolen
ADD FOREIGN KEY (StockItemID) REFERENCES stockitems(StockItemID);