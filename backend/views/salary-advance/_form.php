<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SalaryAdvance */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="salary-advance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if ($model->isNewRecord):?>
        <?= $form->field($model, 'staff_id',['options'=>['class'=>'required']])->widget(\kartik\select2\Select2::className(), ['data'=> ArrayHelper::map(\common\models\Staff::find()->all(),'id',function ($model){
            return $model->fname.' '.$model->lname;
        }),             'options'=>['placeholder'=>'--Select Staff--']]) ?>
    <?php endif;?>

    <?= $form->field($model, 'amount')->textInput(['id'=>'money-value']);?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$script=<<< JS
$(function() {
    // Get the input field by its ID
    var input = $('#money-value');

    // Set up a keyup event listener to format the input value as the user types
    input.on('keyup', function() {
        // Remove any existing commas from the input value
        var value = input.val().replace(/,/g, '');

        // Format the input value with commas every three digits
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        // Set the formatted value back into the input field
        input.val(value);
    });
});
JS;
$this->registerJs($script);
?>

