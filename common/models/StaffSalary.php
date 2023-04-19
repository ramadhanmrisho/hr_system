<?php

namespace common\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "staff_salary".
 *
 * @property int $id
 * @property int $staff_id
 * @property string $month
 * @property string $created_at
 * @property int $created_by
 *
 * @property Staff $staff
 * @property UserAccount $createdBy
 */
class StaffSalary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff_salary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'month', 'created_by'], 'required'],
            [['staff_id', 'created_by'], 'integer'],
            [['month'], 'string'],
            [['created_at','salary_slip'], 'safe'],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff Name',
            'month' => 'Month',
            'salary_slip' => 'Salary Slip',
            'created_at' => 'Generated At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[Staff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(UserAccount::className(), ['id' => 'created_by']);
    }




    /**
     * @param $slip
     * @param string $height
     * @param string $width
     * @return string
     */
    function pdfViewer($slip,$height='800px',$width='100%')
    {
        if (!empty($slip)){

            return Html::tag('iframe','', ['src'=>Url::to(['staff-salary/pdf-viewer','id'=>$this->id]),'style'=>"width: $width; height: $height;",'name'=>'pdf-viewer-iframe']);
        }

        else{
            return Html::tag('h3','nipo hapa',['class'=>'text-danger text-center','style'=>'width:100%; height:300px; background:white;padding-top:100px']);
        }
    }




}
