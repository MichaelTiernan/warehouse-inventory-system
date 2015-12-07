ALTER TABLE users ADD UNIQUE KEY (`username`);

ALTER TABLE products MODIFY `ks_storage` int(11) unsigned DEFAULT NULL;