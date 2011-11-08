DROP TABLE IF EXISTS webfrete_tipo_frete_has_parametro;
DROP TABLE IF EXISTS webfrete_parametro;
DROP TABLE IF EXISTS webfrete_tipo_frete;
DROP TABLE IF EXISTS webfrete_grupo_tipo_frete;
DROP TABLE IF EXISTS webfrete_log;
CREATE TABLE IF NOT EXISTS webfrete_log (
	id_log BIGINT AUTO_INCREMENT,
	ip_requisitante VARCHAR(100),
	parametros_requisitados TEXT,
	data_requisicao DATETIME,
	PRIMARY KEY(id_log)
);

CREATE TABLE IF NOT EXISTS webfrete_grupo_tipo_frete (
	id_grupo BIGINT UNSIGNED AUTO_INCREMENT,
	nome_grupo VARCHAR(100)  NOT NULL,
	PRIMARY KEY(id_grupo)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS webfrete_tipo_frete (
	id_tipo_frete BIGINT UNSIGNED AUTO_INCREMENT,
	id_grupo_tipo_frete BIGINT UNSIGNED,
	codigo_tipo_frete VARCHAR(100),
	nome_tipo_frete VARCHAR(100),
	cubagem VARCHAR(100),
	PRIMARY KEY(id_tipo_frete),
	FOREIGN KEY(id_grupo_tipo_frete)
		REFERENCES webfrete_grupo_tipo_frete(id_grupo)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS webfrete_parametro (
	id_parametro BIGINT UNSIGNED AUTO_INCREMENT,
	nome_parametro VARCHAR(100) NOT NULL,
	tipo_parametro ENUM('ESTATICO','DINAMICO'),
	PRIMARY KEY(id_parametro)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS webfrete_tipo_frete_has_parametro (
	id_tipo_frete BIGINT UNSIGNED,
	id_parametro BIGINT UNSIGNED,
	PRIMARY KEY(id_tipo_frete,id_parametro),
	FOREIGN KEY(id_tipo_frete)
		REFERENCES webfrete_tipo_frete(id_tipo_frete),
	FOREIGN KEY (id_parametro)
		REFERENCES webfrete_parametro(id_parametro)
) ENGINE=InnoDB;


