<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Absentees */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="absentees-form">


    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
          <?php if ($model->isNewRecord):?>
            <?= $form->field($model, 'staff_id',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::className(), ['data'=> ArrayHelper::map(\common\models\Staff::find()->all(),'id',function ($model){
                return $model->fname.' '.$model->lname;
            }),             'options'=>['placeholder'=>'--Select Staff--']]) ?>
          <?php endif;?>
            <?= $form->field($model, 'category')->dropDownList([ 'Paid Leave' => 'Paid Leave', 'Unpaid Leave' => 'Unpaid Leave', 'Sick Leave' => 'Sick Leave', ], ['prompt' => '']) ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'days')->textInput() ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>

    </div>

    <div class="form-group" align="center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
