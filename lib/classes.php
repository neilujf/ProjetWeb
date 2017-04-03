<?php

require_once dirname(__FILE__) . '/../Tools/Db.php';

class Classes
{

    /**
     * Renvoie tout les cours d'une periode donnee
     *
     * @param string $dateStart la date de debut de la periode
     * @param $dateEnd la date de debut de fin de la periode
     * @return array
     */
    public function getPeriodClasses($dateStart, $dateEnd)
    {
        $db = Db::getInstance();
        return $db->fetchAll('SELECT * FROM cours WHERE UNIX_TIMESTAMP(date_debut) >= ' . strtotime($dateStart) . ' AND UNIX_TIMESTAMP(date_fin) < ' . strtotime($dateEnd));
    }

    /**
     * Renvoie tout les cours ayant lieu 7 jours après la date specifiee.<br/>
     * La date doit être au format d(d)-m(m)-yyyy
     *
     * @param string $date
     * @return array un tableau de cours
     */
    public function getWeekClasses($date)
    {
        $timestampEnd = strtotime('+7 days', strtotime($date));
        return $this->getPeriodClasses($date, date('d-m-Y', $timestampEnd));
    }
}