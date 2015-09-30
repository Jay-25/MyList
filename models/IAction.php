<?php

namespace app\models;

interface IAction {
    public static function run( $paras = null );
}

?>