<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FinalExam */

$this->title = 'Upload Final Exam Results';
$this->params['breadcrumbs'][] = ['label' => 'Final Exams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
if(Yii::$app->session->hasFlash('getWarning')):?>
    <div class="alert alert-sm alert-warning zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getWarning');?>
    </div>
<?php endif;?>
<?php
if(Yii::$app->session->hasFlash('getDanger')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getDanger');?>
    </div>
<?php endif;?>
<?= Html::a('<span class="fa fa-download"> Download CSV Template</span>', 'templates/semester_exam_template.csv', ['class' => 'btn btn-primary']) ?>
<br>
<br>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<?php \yiister\adminlte\widgets\Callout::begin(["type" => \yiister\adminlte\widgets\Callout::TYPE_SUCCESS]); ?>
<h4 style="color: red;font-family: Tahoma">NOTE:</h4>
<li style="font-family: 'Tahoma">Make sure all student scores are out of 100%.</li>
<li style="font-family: 'Tahoma'">Make sure you are excel file is a csv(comma separated value) file.</li>
<li style="font-family: Tahoma">Please! Upload a CSV with scores of all Students</li>
<?php \yiister\adminlte\widgets\Callout::end(); ?>
<div class="final-exam-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
