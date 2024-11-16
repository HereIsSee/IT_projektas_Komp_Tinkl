#@(#) script.ddl

DROP TABLE IF EXISTS ZINUTE;
DROP TABLE IF EXISTS VARTOTOJO_RENGINIO_TIPAS_PASIRINKIMAI;
DROP TABLE IF EXISTS VARTOTOJO_GRUPES_PASIRINKIMAI;
DROP TABLE IF EXISTS RENGINIU_NUOTRAUKOS;
DROP TABLE IF EXISTS RENGINIAI_GRUPES;
DROP TABLE IF EXISTS VARTOTOJO_PASIRINKIMAI;
DROP TABLE IF EXISTS RENGINYS;
DROP TABLE IF EXISTS MIKRORAJONAS;
DROP TABLE IF EXISTS MIESTAS;
DROP TABLE IF EXISTS VARTOTOJAS;
DROP TABLE IF EXISTS SOCIALINES_GRUPES;
DROP TABLE IF EXISTS RENGINIO_TIPAS;
CREATE TABLE RENGINIO_TIPAS
(
	id int AUTO_INCREMENT,
	pavadinimas varchar (255) NOT NULL,
	kartu_panaudotas int DEFAULT 0,
	PRIMARY KEY(id)
);

CREATE TABLE SOCIALINES_GRUPES
(
	id int AUTO_INCREMENT,
	pavadinimas varchar (255) NOT NULL,
	kartu_panaudotas int DEFAULT 0,
	PRIMARY KEY(id)
);

CREATE TABLE VARTOTOJAS
(
	id int AUTO_INCREMENT,
	vardas varchar (255) NOT NULL,
	el_pastas varchar (255) NOT NULL,
	slaptazodis varchar (255) NOT NULL,
	vaidmuo char (11),
	CHECK(vaidmuo in ('vip', 'admin', 'vartotojas')),
	PRIMARY KEY(id),
	UNIQUE (vardas),
	UNIQUE (el_pastas)
);

CREATE TABLE MIESTAS
(
	id int AUTO_INCREMENT,
	miestas varchar (255) NOT NULL,
	kartu_panaudotas int DEFAULT 0,
	PRIMARY KEY(id)
);

CREATE TABLE MIKRORAJONAS
(
	id int AUTO_INCREMENT,
	pavadinimas varchar (255) NOT NULL,
	kartu_panaudotas int DEFAULT 0,
	fk_miesto_id int NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(fk_miesto_id) REFERENCES MIESTAS (id)
);

CREATE TABLE RENGINYS
(
	id int AUTO_INCREMENT,
	pavadinimas varchar (255) NOT NULL,
	renginio_data date NOT NULL,
	aprasymas varchar (20000),
	adressas varchar (255),
	fk_seno_renginio_id int,
	fk_renginio_tipas_id int,
	fk_vip_vartotojo_id int NOT NULL,
	fk_miesto_id int NOT NULL,
	fk_mikrorajono_id int,
	PRIMARY KEY(id),
	FOREIGN KEY(fk_seno_renginio_id) REFERENCES RENGINYS (id),
	FOREIGN KEY(fk_renginio_tipas_id) REFERENCES RENGINIO_TIPAS (id),
	FOREIGN KEY(fk_vip_vartotojo_id) REFERENCES VARTOTOJAS (id),
	FOREIGN KEY(fk_miesto_id) REFERENCES MIESTAS (id),
	FOREIGN KEY(fk_miesto_id) REFERENCES MIKRORAJONAS (id)
);

CREATE TABLE VARTOTOJO_PASIRINKIMAI
(
	id int AUTO_INCREMENT,
	fk_vartotojo_id int NOT NULL,
	fk_miesto_id int,
	fk_mikrorajono_id int,
	PRIMARY KEY(id),
	FOREIGN KEY(fk_vartotojo_id) REFERENCES VARTOTOJAS (id),
	FOREIGN KEY(fk_mikrorajono_id) REFERENCES MIKRORAJONAS (id),
	FOREIGN KEY(fk_miesto_id) REFERENCES MIESTAS (id)
);

CREATE TABLE RENGINIAI_GRUPES
(
	fk_renginio_id int NOT NULL,
	fk_socialines_grupes_id int NOT NULL,
	PRIMARY KEY(fk_socialines_grupes_id, fk_renginio_id),
	FOREIGN KEY(fk_renginio_id) REFERENCES RENGINYS (id),
	FOREIGN KEY(fk_socialines_grupes_id) REFERENCES SOCIALINES_GRUPES (id)
);

CREATE TABLE RENGINIU_NUOTRAUKOS
(
	id int AUTO_INCREMENT,
	nuotraukos_kelias varchar (255) NOT NULL,
	fk_renginio_id int NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(fk_renginio_id) REFERENCES RENGINYS (id)
);

CREATE TABLE VARTOTOJO_GRUPES_PASIRINKIMAI
(
	fk_socialines_grupes_id int NOT NULL,
	fk_vartotojo_pasirinkimo_id int NOT NULL,
	PRIMARY KEY(fk_socialines_grupes_id, fk_vartotojo_pasirinkimo_id),
	FOREIGN KEY(fk_socialines_grupes_id) REFERENCES SOCIALINES_GRUPES (id),
	FOREIGN KEY(fk_vartotojo_pasirinkimo_id) REFERENCES VARTOTOJO_PASIRINKIMAI (id)
);

CREATE TABLE VARTOTOJO_RENGINIO_TIPAS_PASIRINKIMAI
(
	fk_vartotojo_pasirinkimo_id int NOT NULL,
	fk_renginio_tipo_id int NOT NULL,
	PRIMARY KEY(fk_renginio_tipo_id, fk_vartotojo_pasirinkimo_id),
	FOREIGN KEY(fk_vartotojo_pasirinkimo_id) REFERENCES VARTOTOJO_PASIRINKIMAI (id),
	FOREIGN KEY(fk_renginio_tipo_id) REFERENCES RENGINIO_TIPAS (id)
);

CREATE TABLE ZINUTE
(
	id int AUTO_INCREMENT,
	antraste varchar (255),
	aprasymas varchar (1000),
	fk_vartotojo_id int NOT NULL,
	fk_vartotojo_pasirinkimo_id int,
	PRIMARY KEY(id),
	FOREIGN KEY(fk_vartotojo_id) REFERENCES VARTOTOJAS (id),
	FOREIGN KEY(fk_vartotojo_pasirinkimo_id) REFERENCES VARTOTOJO_PASIRINKIMAI (id)
);
