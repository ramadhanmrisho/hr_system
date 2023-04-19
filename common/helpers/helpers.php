<?php


use common\models\Attachment;
use common\models\ClientAccount;
use common\models\Staff;
use common\models\StaffSalary;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\rbac\ManagerInterface;
use yii\web\IdentityInterface;
use yii\web\NotFoundHttpException;

/**
 * @param $code
 * @param string $message
 * @param array $headers
 * @throws NotFoundHttpException
 * @throws \yii\web\HttpException
 */
function abort($code, $message = '', array $headers = [])
{
    if ($code == 404) {
        throw new NotFoundHttpException($message);
    }

    throw new \yii\web\HttpException($code, $message, null);
}


if (!function_exists('dd')) {
    function dd(...$vars)
    {
        foreach ($vars as $v) {
            VarDumper::dump($v);
        }

        exit(1);
    }
}


if (!function_exists('user')) {
    /**
     * @return IdentityInterface|Staff|ClientAccount
     */
    function user()
    {
        if(empty(Yii::$app->user->identity)){
            Yii::$app->response->redirect(['/site/login']);
            Yii::$app->response->send();
            exit();
        }
       return Yii::$app->user->identity;
    }
}


if (!function_exists('flash')) {
    /**
     * @param $key
     * @param $value
     */
    function flash($key,$value)
    {
        Yii::$app->session->setFlash($key,$value);
    }
}


/**
 * @return ManagerInterface
 */
function auth()
{
    return Yii::$app->authManager;
}

if (!function_exists('has')) {
    /**
     * @param $role
     * @return bool
     */
    function has($role)
    {
        return \common\models\UserAccount::userHas($role) || can($role);
    }
}

if (!function_exists('can')) {
    /**hp 
     * @param $privilege
     * @return bool
     */
    function can($privilege)
    {
        if (!is_array($privilege)){
            return Yii::$app->user->can($privilege);
        }
        foreach ($privilege as $prv){
            if (Yii::$app->user->can($prv)){
                return true;
            }
        }

        return false;
    }
}







if (!function_exists('str_contains')) {
    function str_contains($str,$needle){
        return preg_match("/{$needle}/i", $str);
    }
}


