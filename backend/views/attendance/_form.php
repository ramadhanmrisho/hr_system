<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Attendance */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="attendance-form">


    <div class="card card-default">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            <span class="fa fa-file-excel-o"> View Sample Template Attendance</span>
        </button>
        <div class="card-body" style="padding:40px;">
            <center>
                <div class="col-sm-6 text-left" style="float:none;">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'] ]); ?>

                    <p>Select attendance file  to upload</p>

                    <div class="row">
                        <div class="col-sm-6"><?= $form->field($model, 'attached_file')->fileInput()->label(false)?></div>
                        <div class="col-sm-6 text-right">
                            <?=  Html::submitButton('<i class="glyphicon glyphicon-cloud-upload"></i> '.Yii::t('app','Click to attach'),['class'=>'btn btn-success'])?>
                            <?= Html::a('<i class="glyphicon glyphicon-ban-circle"></i> '.Yii::t('app', 'Cancel'),['attendance/index'],['class' => 'btn btn-danger'])?>&emsp;
                        </div>
                    </div>



                    <?php ActiveForm::end(); ?>
                </div>
            </center>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sample Template Attendance</h5>
                    <button type="button" class="fa fa-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Embedding a sample table representing the Excel file -->
                    <div class="modal-body text-center">
                        <img src="/images/sample.png" class="" alt="User Image" height="300px" width="600px">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



</div>
