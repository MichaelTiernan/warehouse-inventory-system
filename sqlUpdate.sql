ALTER TABLE sales MODIFY `custnr` VARCHAR(10) NOT NULL;
ALTER TABLE products ADD last_edited_by int(11) unsigned;

CREATE TABLE IF NOT EXISTS logg (
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  userID int(11) unsigned NOT NULL,
  quantity int(11) DEFAULT NULL,
  ks_storage int(11) unsigned DEFAULT NULL,
  productID int(11) unsigned NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (productID) REFERENCES products(id)
);
