<?php

require_once dirname(__FILE__) . '/../Tools/Db.php';

/**
 * Class Courses
 * Les formations
 */
class Courses
{

    /**
     * Recupere les cours d'un enseignant pour une periode donnee
     *
     * @param int $id_teacher l'id de l'enseignant
     * @param string $dateStart la date de debut de la periode
     * @param $dateEnd la date de debut de fin de la periode
     * @return array
     */
    public function getTeacherPeriodClasses($id_teacher, $dateStart, $dateEnd)
    {
        $db = Db::getInstance();
        return $db->fetchAll('SELECT cours.*, form.nom as formation FROM cours ' .
            'INNER JOIN formations as form ON form.id_cours = cours.id ' .
            'INNER JOIN professeurs as prof ON prof.id = form.id_professeurs ' .
            'WHERE UNIX_TIMESTAMP(cours.date_debut) >= ' . strtotime($dateStart) . ' ' .
            'AND UNIX_TIMESTAMP(cours.date_fin) < ' . strtotime($dateEnd) . ' ' .
            'AND prof.id = ' . (int)$id_teacher . ' ' .
            'ORDER BY cours.date_debut ASC');
    }

    /**
     * Recupere les cours d'un enseignant ayant lieu 7 jours après la date specifiee.
     *
     * @param int $id_teacher l'id de l'enseignant
     * @param string $dateStart la date de debut de la periode
     * @return array
     */
    public function getTeacherWeekClasses($id_teacher, $dateStart)
    {
        $timestampEnd = strtotime('+7 days', strtotime($dateStart));
        return $this->getTeacherPeriodClasses($id_teacher, $dateStart, date('d-m-Y', $timestampEnd));
    }

}