<?php

require_once dirname(__FILE__) . '/../Tools/Db.php';
require_once dirname(__FILE__) . '/../lib/courses.php';
require_once dirname(__FILE__) . '/../lib/teachers.php';
require_once dirname(__FILE__) . '/../Tools/Tools.php';

/**
 * Envoie un mail recapitulatif de ses cours sur une periode donnee a un professeur
 *
 * @param $id_teacher l'id du professeur
 * @param $dateStart la date de debut de la periode, au format d-m-y
 * @param $dateEnd la date de fin de la periode, au format d-m-y
 * @return bool
 */
function sendMailForPeriod($id_teacher, $dateStart, $dateEnd)
{
    if (!Tools::isValidDate($dateStart) || !Tools::isValidDate($dateEnd) || !is_numeric($id_teacher) || strtotime($dateEnd) - strtotime($dateStart) < 86400) {
        return false;
    }

    $courses = new Courses();
    $periodClasses = $courses->getTeacherPeriodClasses($id_teacher, $dateStart, $dateEnd);

    $teachers = new Teachers();
    $myTeacher = $teachers->getTeacherById($id_teacher);
    if (empty($myTeacher)) {
        return false;
    }

    if (strtotime($dateEnd) - strtotime($dateStart) > 86400) {
        $periodString = "la période du " . date("d/m/Y", strtotime($dateStart)) . " au " . date("d/m/Y", strtotime($dateEnd));
    } else {
        $periodString = "la journée du " . date("d/m/Y", strtotime($dateStart));
    }

    $mailSubject = "Votre récapitulatif pour " . $periodString;
    $mailContent = "Bonjour " . $myTeacher['prenom'] . " " . $myTeacher['nom'] . ",\n\n" .
        "Voici le récapitulatif de vos cours pour " . $periodString . " :\n\n";

    if (empty($periodClasses)) {
        $mailContent .= "Aucun cours.\n\n";
    } else {
        $prevDate = null;
        foreach ($periodClasses as $class) {
            if ($prevDate != $class['date_debut']) {
                $mailContent .= "Le " . date('d/m/Y', strtotime($class['date_debut'])) . " :\n\n";
                $prevDate = $class['date_debut'];
            }
            $mailContent .= "de " . date('H\hi', strtotime($class['date_debut'])) . " à " . date('H\hi', strtotime($class['date_debut'])) . "\n";
            $mailContent .= $class['formation'] . " à " . $class['lieu'] . "\n\n";
        }
        $mailContent .= "\n";
    }

    $mailContent .= "Cordialement,\nL'équipe ESIEE-learning";

    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/plain; charset=utf-8';
    $headers[] = 'To: ' . $myTeacher['prenom'] . " " . $myTeacher['nom'] . ' <' . $myTeacher['email'] . '>';
    echo '<pre>' . $mailContent . '</pre>';
    //return mail($myTeacher['email'], $mailSubject, $mailContent, $headers);
}

sendMailForPeriod(1, '01-01-2017', '21-07-2018');