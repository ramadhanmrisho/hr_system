<?php

use fedemotta\datatables\DataTables;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ModuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$title=Yii::$app->request->get('authorization');

if ($title=='clinical_1'){
    $module_tittle='BASIC TECHNICIAN CERTIFICATE IN CLINICAL MEDICINE MODULES';
}
if ($title=='clinical_2'){
    $module_tittle='TECHNICIAN CERTIFICATE IN CLINICAL MEDICINE MODULES';
}
if ($title=='clinical_3'){
    $module_tittle='DIPLOMA IN CLINICAL MEDICINE MODULES';
}
if ($title=='nursing_1'){
    $module_tittle='BASIC TECHNICIAN CERTIFICATE IN NURSING AND MIDWIFERY MODULES';
}
if ($title=='nursing_2'){
    $module_tittle='TECHNICIAN CERTIFICATE IN NURSING AND MIDWIFERY MODULES';
}
if ($title=='nursing_3'){
    $module_tittle='ORDINARY DIPLOMA IN NURSING AND MIDWIFERY MODULES';
}

$this->params['breadcrumbs'][] = $this->title;
?>

<h4><?= Html::encode($module_tittle)?></h4>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="module-index">
<?php if (\common\models\UserAccount::userHas(['HOD'])){?>
    <p>
        <?= Html::a('<span class="fa fa-plus">Add New Module</span>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php }?>
    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'module_name',
            'module_code',
            'nta_level',
            ['attribute'=>'semester_id','value'=>function($model){
                return $model->semester->name;
            }],


            'module_credit',
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'contentOptions' =>['style' => 'width:100px;'],
                'header'=>"ACTION",
                'headerOptions' => [
                    'style' => 'color:red'
                ],
                'buttons' => [
                    //view button
                    'view' => function ($url, $model) {
                        return Html::a('<span class="fa fa-open-eye"></span>View More', $url, [
                            'title' => Yii::t('app', 'View'),
                            'class'=>'btn btn-primary btn-xs',]);
                    },

                    'urlCreator' => function($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url = 'index.php?r=staff/view&id='.$model->id;
                            return $url;
                        }

                    } ,
                ],
            ],
        ],
    ]); ?>
</div>
