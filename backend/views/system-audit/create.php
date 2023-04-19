<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SystemAudit */

$this->title = 'Create System Audit';
$this->params['breadcrumbs'][] = ['label' => 'System Audits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-audit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
