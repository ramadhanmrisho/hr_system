<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UnionContribution */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>

<div class="union-contribution-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($model->isNewRecord):?>
        <?= $form->field($model, 'staff_id',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::className(), ['data'=> ArrayHelper::map(\common\models\Staff::find()->all(),'id',function ($model){
            return $model->fname.' '.$model->lname;
        }),             'options'=>['placeholder'=>'--Select Staff--']]) ?>
    <?php endif;?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
 <?php
 if(!$model->isNewRecord):?>
   <?=  $form->field($model, 'status')->dropDownList(['active' => 'Active', 'inactive' => 'Inactive',], ['prompt' => '']) ?>
   <?php endif;?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
