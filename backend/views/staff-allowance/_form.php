<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StaffAllowance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staff-allowance-form">

    <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model, 'allowance_id',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::className(), ['data'=> ArrayHelper::map(\common\models\Allowance::find()->all(),'id',function($model){
                        return $model['name'].' ['.Yii::$app->formatter->asDecimal($model['amount'],0).' Tsh]';
    }),             'options'=>['placeholder'=>'--Select ---']]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
