<?php

require_once dirname(__FILE__) . '/Tools/Db.php';
require_once dirname(__FILE__) . '/Tools/Tools.php';

// Cree un jeu de test; 2 professeurs, 2 formations, avec 2 cours chacunes, dans la semaine actuelle.
// Les ids sont deliberement mis en dur pour pouvoir les retirer plus facilement.

$weekStartTimestamp = strtotime(Tools::getLastMonday());
$info1ClassStart = strtotime('next tuesday 14:00:00', $weekStartTimestamp);
$info2ClassStart = strtotime('next thursday 14:00:00', $weekStartTimestamp);
$english1ClassStart = strtotime('next tuesday 10:00:00', $weekStartTimestamp);
$english2ClassStart = strtotime('next thursday 10:00:00', $weekStartTimestamp);

Db::getPDO()->beginTransaction();
if (false === Db::getPDO()->exec("
    INSERT INTO professeurs(id, nom, prenom, email) VALUES (1000, 'Michel', 'DUPONT', 'michel.dupont@yopmail.com');
    INSERT INTO formations(id, nom, id_professeurs) VALUES (1000, 'Info', 1000);
    INSERT INTO formations(id, nom, id_professeurs) VALUES (1001, 'Anglais', 1000);
    INSERT INTO cours(id, date_debut, date_fin, lieu, id_formation) VALUES (1000, FROM_UNIXTIME($info1ClassStart), FROM_UNIXTIME($info1ClassStart + 7200), 'Cergy', 1000);
    INSERT INTO cours(id, date_debut, date_fin, lieu, id_formation) VALUES (1001, FROM_UNIXTIME($info2ClassStart), FROM_UNIXTIME($info2ClassStart + 7200), 'Noisy', 1000);
    INSERT INTO cours(id, date_debut, date_fin, lieu, id_formation) VALUES (1002, FROM_UNIXTIME($english1ClassStart), FROM_UNIXTIME($english1ClassStart + 7200), 'Cergy', 1001);
    INSERT INTO cours(id, date_debut, date_fin, lieu, id_formation) VALUES (1003, FROM_UNIXTIME($english2ClassStart), FROM_UNIXTIME($english2ClassStart + 7200), 'Noisy', 1001);
")
) {
    echo '<pre>' . print_r(Db::getPDO()->errorInfo(), true) . '</pre>';
    Db::getPDO()->rollBack();
    die();
} else {
    Db::getPDO()->commit();
}
?>
Jeu de test créé<br/>
Pour supprimer les lignes :<br/><br/>

DELETE FROM professeurs WHERE id = 1000;
DELETE FROM formations WHERE id = 1000;
DELETE FROM formations WHERE id = 1001;
DELETE FROM cours WHERE id = 1000;
DELETE FROM cours WHERE id = 1001;
DELETE FROM cours WHERE id = 1002;
DELETE FROM cours WHERE id = 1003;