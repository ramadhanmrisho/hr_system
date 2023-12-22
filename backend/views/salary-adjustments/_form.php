<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SalaryAdjustments */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="salary-adjustments-form">


<!--    --><?php //= $form->field($model, 'staff_ids')->checkboxList(
//        \yii\helpers\ArrayHelper::merge(['all' => 'All Staff'], \yii\helpers\ArrayHelper::map(\common\models\Staff::find()->all(), 'id', function ($model){
//            return $model->fname.'  '.$model->lname;
//        })),
//        [
//            'separator' => '<p>',
//            'item' => function ($index, $label, $name, $checked, $value) {
//                $checked = $value === 'all' ? false : $checked; // Uncheck the "All" option
//                return Html::checkbox($name, $checked, [
//                    'value' => $value,
//                    'label' => $label,
//                    'labelOptions' => ['class' => 'checkbox-inline'],
//                ]);
//            },
//        ]
//    )->label('Select Staff'); ?>

    <?php
    // Fetch staff names from the Staff model
    $staff = \common\models\Staff::find()->all();
    $staffNames = \yii\helpers\ArrayHelper::map($staff, 'id', function ($model) {
        return $model->fname . ' ' . $model->lname;
    });

    $staffNames['all'] = 'All Staff';
?>

  <?php  $form = ActiveForm::begin();?>

   <?php if ($model->isNewRecord):?>
    <?= $form->field($model, 'staff_ids')->widget(Select2::class, [
        'data' => $staffNames,
        'options' => [
            'placeholder' => 'Select Staff Names...',
            'multiple' => true,
        ],
    ])->label('Select Staff'); ?>
<?php endif;?>

   <div class="row">
       <div class="col-md-6">
           <?= $form->field($model, 'amount')->textInput(['id'=>'money-value']);?>
       </div>
       <div class="col-md-6">
           <?= $form->field($model, 'description')->textInput(['maxlength' => true]);?>

       </div>
   </div>

    <p align="center">
        <?= Html::submitButton('Save Details', ['class' => 'btn btn-success']);?>
    </p>

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
