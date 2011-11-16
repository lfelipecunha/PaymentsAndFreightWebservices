DROP TABLE IF EXISTS webfrete_faixa_cep_capital;
DROP TABLE IF EXISTS webfrete_jadlog_prazo;
DROP TABLE IF EXISTS webfrete_estado;

CREATE TABLE webfrete_estado (
	sigla CHAR(2) PRIMARY KEY,
	nome VARCHAR(100) NOT NULL,
	cep_inicio CHAR(9) NOT NULL,
	cep_fim CHAR(9) NOT NULL,
	cep_inicio2 CHAR(9),
	cep_fim2 CHAR(9)
)ENGINE=INNODB;


CREATE TABLE webfrete_jadlog_prazo (
	id_jadlog_prazo BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	estado CHAR(2) NOT NULL,
        regiao ENUM('CAPITAL','INTERIOR') NOT NULL DEFAULT 'INTERIOR',
        prazo_rodoviario INT UNSIGNED NOT NULL,
	prazo_expresso INT UNSIGNED NOT NULL,
        FOREIGN KEY (estado)
		REFERENCES webfrete_estado(sigla)
)ENGINE=INNODB;


CREATE TABLE webfrete_faixa_cep_capital (
	id_faixa_cep BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	cep_inicio CHAR(9) NOT NULL,
	cep_fim CHAR(9) NOT NULL,
	estado CHAR(2) NOT NULL,
	FOREIGN KEY(estado)
		REFERENCES webfrete_estado(sigla)
) ENGINE=INNODB;

INSERT INTO webfrete_estado (sigla,cep_inicio,cep_fim,nome)
VALUES
('AC','69900000','69999999','Acre'),
('AL','57000000','57999999','Alagoas'),
('AP','68900000','68999999','Amapá'),
('BA','40000000','48999999','Bahia'),
('CE','60000000','63999999','Ceara'),
('DF','70000000','73699999','Distrito Federal'),
('ES','29000000','29999999','Espirito Santo'),
('GO','73700000','76799999','Goiais'),
('MA','65000000','65999999','Maranhão'),
('MG','30000000','39999999','Minas Gerais'),
('MS','79000000','79999999','Mato Grosso do Sul'),
('MT','78000000','78999999','Mato Grosso'),
('PE','50000000','56999999','Pernambuco'),
('RJ','20000000','28999999','Rio de Janeiro'),
('SE','49000000','49999999','Sergipe'),
('SP','00000000','19999999','São Paulo'),
('PA','66000000','68899999','Pará'),
('PB','58000000','58999999','Paraiba'),
('PI','64000000','64999999','Piaui'),
('PR','80000000','87999999','Paraná'),
('RN','59000000','59999999','Rio Grande do Norte'),
('RO','76800000','76999999','Rondônia'),
('RR','69300000','69399999','Roraima'),
('RS','90000000','99999999','Rio Grande do Sul'),
('SC','88000000','89999999','Santa Catarina'),
('TO','77000000','77999999','Tocantins');
INSERT INTO webfrete_estado (sigla,cep_inicio,cep_fim,nome,cep_inicio2,cep_fim2)
VALUES
('AM','69000000','69299999','Amazonas','69400000','69899999');


INSERT INTO webfrete_faixa_cep_capital (estado,cep_inicio,cep_fim)
VALUES
    ('SP','01000001', '05999999'),
    ('SP','08000000', '08499999'),
    ('MG','30000001', '31999999'),
    ('PR','80000001', '82999999'),
    ('RJ','20000001', '23799999'),
    ('SC','88000001', '88099999'),
    ('DF','70000001', '70639999'),
    ('DF','70700000', '70999999'),
    ('ES','29000001', '29099999'),
    ('MS','79000001', '79124999'),
    ('RS','90000001', '91999999'),
    ('GO','74000001', '74899999'),
    ('TO','77000001', '77249999'),
    ('BA','40000001', '42499999'),
    ('MT','78000001', '78099999'),
    ('AL','57000001', '57099999'),
    ('SE','49000001', '49098999'),
    ('PB','58000001', '58099999'),
    ('PE','50000001', '52999999'),
    ('PI','64000001', '64099999'),
    ('RO','76800001', '76834999'),
    ('AC','69900001', '69990999'),
    ('AP','68950001', '68911999'),
    ('AM','69000001', '69099999'),
    ('CE','60000001', '61599999'),
    ('MA','65000001', '65109999'),
    ('PA','66000001', '66999999'),
    ('RN','59000001', '59139999'),
    ('RR','69300001', '69339999');

INSERT INTO webfrete_jadlog_prazo(estado, regiao, prazo_rodoviario,prazo_expresso)
VALUES
	('AC','INTERIOR',25,10),
	('AC','CAPITAL',15,2),
	('AL','INTERIOR',12,8),
	('Al','CAPITAL',5,2),
	('AM','INTERIOR',36,15),
	('AM','CAPITAL',20,2),
	('AP','INTERIOR',25,14),
	('AP','CAPITAL',13,12),
	('BA','INTERIOR',16,11),
	('BA','CAPITAL',8,5),
	('CE','INTERIOR',17,12),
	('CE','CAPITAL',12,04),
	('DF','INTERIOR',8,5),
	('DF','CAPITAL',3,2),
	('ES','INTERIOR',10,7),
	('ES','CAPITAL',5,3),
	('GO','INTERIOR',13,12),
	('GO','CAPITAL',5,2),
	('MA','INTERIOR',20,15),
	('MA','CAPITAL',12,6),
	('MG','INTERIOR',10,7),
	('MG','CAPITAL',7,5),
	('MS','INTERIOR',6,2),
	('MS','CAPITAL',12,7),
	('MT','INTERIOR',15,9),
	('MT','CAPITAL',7,2),
	('PA','INTERIOR',22,15),
	('PA','CAPITAL',15,4),
	('PB','INTERIOR',17,10),
	('PB','CAPITAL',6,3),
	('PE','INTERIOR',15,10),
	('PE','CAPITAL',7,3),
	('PI','INTERIOR',20,12),
	('PI','CAPITAL',9,2),
	('PR','INTERIOR',11,7),
	('PR','CAPITAL',6,3),
	('RJ','INTERIOR',6,4),
	('RJ','CAPITAL',5,4),
	('RN','INTERIOR',17,11),
	('RN','CAPITAL',11,5),
	('RO','INTERIOR',11,7),
	('RO','CAPITAL',6,3),
	('PR','INTERIOR',22,15),
	('PR','CAPITAL',19,5),
	('RR','INTERIOR',25,12),
	('RR','CAPITAL',23,2),
	('RS','INTERIOR',9,7),
	('RS','CAPITAL',5,4),
	('SC','INTERIOR',9,7),
	('SC','CAPITAL',6,4),
	('SE','INTERIOR',12,9),
	('SE','CAPITAL',7,4),
	('SP','INTERIOR',6,5),
	('SP','CAPITAL',5,3),
	('TO','INTERIOR',14,10),
	('TO','CAPITAL',5,2);
