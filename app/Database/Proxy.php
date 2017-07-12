<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 15:06
 */
namespace App\Database;

use App\Factory;

class Proxy
{
    /**
     * @param $sql
     * @return bool|\mysqli_result
     */
    function query($sql)
    {
        if (substr($sql, 0, 6) == 'select') {
            return Factory::getDatabase('slave')->query($sql);
        } else {
            return Factory::getDatabase('master')->query($sql);
        }
    }
}