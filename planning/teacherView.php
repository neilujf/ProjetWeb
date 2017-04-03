<?php

require_once dirname(__FILE__) . '/../Tools/Tools.php';
require_once dirname(__FILE__) . '/../Tools/Session.php';
require_once dirname(__FILE__) . '/../lib/courses.php';

// Check login...
if (!Session::isTeacherLogged()) {
    // Idealement, faudrait afficher le formulaire de connexion et mettre
    // dedans les donnees necessaires pour pouvoir revenir proprement ici
    echo "Vous devez être connecté pour accéder à cette page.";
    exit;
}

// On supposera que l'id du professeur est en session
$id_teacher = Session::getTeacherId();

// La date doit etre au format d(d)-m(m)-yyyy
$date = Tools::getValue('date', false);
if (empty($date)) {
    $date = Tools::getLastMonday();
} else if (!Tools::isValidDate($date)) {
    echo "Erreur dans les parametres";
    exit;
}

$courses = new Courses();
echo "<pre>" . print_r($courses->getTeacherWeekClasses($id_teacher, $date), true) . "</pre>";