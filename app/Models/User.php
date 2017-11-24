<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 14:46
 */
namespace App\Models;

use Laravue\Database\Model;

class User extends Model
{
    public static function tableName()
    {
        return 'user';
    }
}