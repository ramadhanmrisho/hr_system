<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\StaffPaylist */

$this->title = 'Paylist :'.$model->month.' '.date_format(new DateTime($model->created_at),'Y');
$this->params['breadcrumbs'][] = ['label' => 'Staff Paylists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="staff-paylist-view">




    <div >

        <?php
        $completePath = Yii::getAlias('@web/paylist/'.$model->paylist);
        // $completePath='/slips';
        $filename="Paylist";


        echo $model->pdfViewer($completePath);

        ?>



    </div>
</div>
