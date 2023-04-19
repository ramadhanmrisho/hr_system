<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\YearOfStudy */

$this->title = 'Add Year Of Study';
$this->params['breadcrumbs'][] = ['label' => 'Year Of Studies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="year-of-study-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
