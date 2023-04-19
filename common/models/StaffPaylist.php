<?php

namespace common\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "staff_paylist".
 *
 * @property int $id
 * @property string $month
 * @property string $paylist
 * @property float $total_amount
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 */
class StaffPaylist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff_paylist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month', 'created_by'], 'required'],
            [['total_amount'], 'number'],
            [['created_by'], 'integer'],
            [['created_at', 'updated_at','paylist','total_amount'], 'safe'],
            [['month'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month' => 'Month',
            'total_amount' => 'Total Amount',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    /**
     * @param $slip
     * @param string $height
     * @param string $width
     * @return string
     */
    function pdfViewer($paylist,$height='800px',$width='100%')
    {
        if (!empty($paylist)){

            return Html::tag('iframe','', ['src'=>Url::to(['staff-paylist/pdf-viewer','id'=>$this->id]),'style'=>"width: $width; height: $height;",'name'=>'pdf-viewer-iframe']);
        }

        else{
            return Html::tag('h3','nipo hapa',['class'=>'text-danger text-center','style'=>'width:100%; height:300px; background:white;padding-top:100px']);
        }
    }
}
