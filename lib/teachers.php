<?php

require_once dirname(__FILE__) . '/../Tools/Db.php';

class Teachers
{

    public function getTeacherById($id_teacher)
    {
        return Db::getInstance()->fetchRow("SELECT * FROM professeurs WHERE id = " . (int)$id_teacher);
    }

}