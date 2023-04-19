<?php
namespace common\models;

use common\models\Staff;
use Yii;
use yii\base\Model;
class ChangeNywila extends Model
{
    public $oldpass;
    public $newpass;
    public $repeatnewpass;

    public function rules()
    {
        return [
            [['newpass','repeatnewpass'],'required'],
            ['repeatnewpass','compare','compareAttribute'=>'newpass'],

        ];
    }



    public function findPasswords($attribute, $params)
    {
        $user = Staff::find()->where([
            'phone_number'=>Yii::$app->user->identity->phone_number])->one();

        $password = $user->password;
        if(!Yii::$app->security->validatePassword($this->oldpass, $password))
            $this->addError($attribute,'Current password is incorrect');
    }



    public function attributeLabels()
    {
        return [
            'newpass'=>'New Password',
            'repeatnewpass'=>'Confirm New Password',
        ];
    }


    public function passwordStrength($attribute,$params)
    {
        $pattern = '((?=.*\\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{6,20})';
        if(!preg_match($pattern, $this->$attribute))
            $this->addError($attribute, 'Your password is not strong enough (Should be 6 characters long or more and contain at least 1 upper case letter, 1 lower case letter,1 special symbol(@#$%) and at least 1 number )');
    }

}