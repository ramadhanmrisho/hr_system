<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AttachmentsType */

$this->title = 'Add New  Attachment Type';
$this->params['breadcrumbs'][] = ['label' => 'Attachments Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attachments-type-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
