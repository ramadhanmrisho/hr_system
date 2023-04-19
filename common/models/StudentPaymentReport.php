<?php

namespace common\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "student_payment_report".
 *
 * @property int $id
 * @property int $academic_year_id
 * @property int $course_id
 * @property int $semester_id
 * @property string $file_name
 * @property string $created_at
 * @property string $updated_at
 */
class StudentPaymentReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_payment_report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['academic_year_id', 'course_id', 'semester_id', 'file_name'], 'required'],
            [['academic_year_id', 'course_id', 'semester_id'], 'integer'],
            [['created_at', 'updated_at','status'], 'safe'],
            [['file_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'academic_year_id' => 'Academic Year ',
            'course_id' => 'Course ',
            'semester_id' => 'Semester',
            'file_name' => 'File Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }



    function pdfViewer($paylist,$height='800px',$width='100%')
    {
        if (!empty($paylist)){

            return Html::tag('iframe','', ['src'=>Url::to(['student-payment-report/pdf-viewer','id'=>$this->id]),'style'=>"width: $width; height: $height;",'name'=>'pdf-viewer-iframe']);
        }

        else{
            return Html::tag('h3','nipo hapa',['class'=>'text-danger text-center','style'=>'width:100%; height:300px; background:white;padding-top:100px']);
        }
    }

}
