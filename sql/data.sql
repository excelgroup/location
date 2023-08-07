
-- tableau imprimante--

CREATE TABLE aaa_printer (
    rowid INT(6) AUTO_INCREMENT PRIMARY KEY,
    seriel VARCHAR(30) NOT NULL,
    reference VARCHAR(30) NOT NULL,
    etat int(6),
    FOREIGN KEY (etat) REFERENCES aaa_contrat(rowid),
    FOREIGN KEY (reference) REFERENCES aaa_annex(reference)
);
-- tableau marque imprimante --

CREATE TABLE aaa_contrat (
    rowid INT(6) AUTO_INCREMENT PRIMARY KEY,
    client VARCHAR(60) ,
    date_c DATE ,
    durée VARCHAR(15),
    remarque VARCHAR(150),
    contact VARCHAR(20)

);



CREATE TABLE aaa_location(
    rowid INT(6) AUTO_INCREMENT PRIMARY KEY,
    contrat_id INT(30) NOT NULL,
    seriel varchar(15) NOT NULL,
    FOREIGN KEY (contrat_id) REFERENCES aaa_contrat(rowid),
    FOREIGN KEY (seriel) REFERENCES aaa_printer(seriel)

);

CREATE TABLE aaa_intervention (
    rowid INT(6) AUTO_INCREMENT PRIMARY KEY,
    contrat_id INT(30) NOT NULL,
    remarque VARCHAR(150),
    cout INT(10),
    date_i DATE,
    FOREIGN KEY (contrat_id) REFERENCES aaa_contrat(rowid)

);


CREATE TABLE aaa_annex(
    rowid INT(6) AUTO_INCREMENT PRIMARY KEY,
    contrat_id INT(30) NOT NULL,
    reference VARCHAR(30) ,
    qte int(30),
    FOREIGN KEY (contrat_id) REFERENCES aaa_contrat(rowid),
    FOREIGN KEY (reference) REFERENCES aaa_reference(ref)
    

);


CREATE TABLE aaa_conteur (
    rowid INT(6) AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(15) UNIQUE NOT NULL
    contrat_id INT(30) NOT NULL,
    printer_id INT(30) NOT NULL,
    FOREIGN KEY (contrat_id) REFERENCES aaa_contrat(rowid),
    FOREIGN KEY (printer_id) REFERENCES aaa_printer(rowid)
);

CREATE TABLE aaa_printer_inter (
    rowid INT(6) AUTO_INCREMENT PRIMARY KEY,
    intervention_id INT(30) NOT NULL,
    seriel VARCHAR(15) NOT NULL,
    type_inter varchar(30),
    cout int(30),
    remarque VARCHAR(150),
    FOREIGN KEY (intervention_id) REFERENCES aaa_intervention(rowid),
    FOREIGN KEY (seriel) REFERENCES aaa_printer(seriel)
);


-- tableau reference imprimante --



