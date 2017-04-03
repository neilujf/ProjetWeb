<?php

class Session
{

    /**
     * Pour verifier si un utilisateur est logge, et si c'est bien un enseignant
     */
    public static function isTeacherLogged()
    {
        // C'est pas moi qui gere les sessions, haha !
        return true;
    }

    public static function getTeacherId()
    {

    }

}