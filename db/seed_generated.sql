-- Generated seed SQL
START TRANSACTION;

INSERT INTO loginuser (username, password_hash)
VALUES ('admin', '$2y$12$tLWXr0IR0B0Dt95Y.QbIZ.FaeEdlITR5L6AKW.NpqyWsaUS.8NMCu')
ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash);

DELETE FROM foto_data;

INSERT INTO foto_data (foto, category, titel, afmeting_hoogte) VALUES ('brons/cobra.jpg', 'brons', 'Cobra', '33 cm');
INSERT INTO foto_data (foto, category, titel, afmeting_hoogte) VALUES ('brons/jumeau.jpg', 'brons', 'Jumeau', '60 cm');
INSERT INTO foto_data (foto, category, titel, afmeting_hoogte) VALUES ('brons/vanity.jpg', 'brons', 'Vanity', '144 cm');
INSERT INTO foto_data (foto, category, titel, afmeting_hoogte) VALUES ('brons/volante.jpg', 'brons', 'Volante', '97 cm');
INSERT INTO foto_data (foto, category, titel, afmeting_hoogte) VALUES ('brons/voltige.jpg', 'brons', 'Voltige', '33 cm');
INSERT INTO foto_data (foto, category, titel, afmeting_hoogte) VALUES ('keramiek/assis.jpg', 'keramiek', 'Assis', '40 cm');
INSERT INTO foto_data (foto, category, titel, afmeting_hoogte) VALUES ('keramiek/bovenOnder.jpg', 'keramiek', 'Boven & onder', '24 cm');
INSERT INTO foto_data (foto, category, titel, afmeting_hoogte) VALUES ('keramiek/Overdenking.jpg', 'keramiek', 'Overdenking', '86 cm');
INSERT INTO foto_data (foto, category, titel, afmeting_hoogte) VALUES ('keramiek/tors.jpg', 'keramiek', 'Tors', '62 cm');
INSERT INTO foto_data (foto, category, titel, afmeting_hoogte) VALUES ('keramiek/trio.jpeg', 'keramiek', 'Trio', '35 cm');
INSERT INTO foto_data (foto, category, titel, afmeting_hoogte) VALUES ('keramiek/relief.jpg', 'keramiek', 'Relief', '94 cm');

COMMIT;
