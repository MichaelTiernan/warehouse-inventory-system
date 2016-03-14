CREATE TABLE IF NOT EXISTS lagerlogging (
	id int(11) unsigned NOT NULL AUTO_INCREMENT,
	diff_hoved int(11),
	diff_ks int(11),
	diff_m int(11),
	hovedlager int(11),
	kslager int(11),
	monlager int(11),
	timecreated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FK_prod int(11) unsigned NOT NULL,
	FK_userID int(11) unsigned NOT NULL,
	PRIMARY KEY (id)
);

 ALTER TABLE lagerlogging ADD FOREIGN KEY (FK_prod) REFERENCES products(id) ON DELETE CASCADE ON UPDATE CASCADE;
 ALTER TABLE lagerlogging ADD FOREIGN KEY (FK_userID) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;
