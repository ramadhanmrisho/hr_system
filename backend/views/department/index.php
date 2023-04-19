<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\DepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Departments';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="department-index">

    <?php Pjax::begin(); ?>


    <p>
        <?= Html::a('<span class="fa fa-plus"></span> Add New Department', ['create'], ['class' => 'btn btn-success ']) ?>
    </p>

    <?= \fedemotta\datatables\DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'abbreviation',
              ['attribute'=>'created_by','value'=>function($model){

            $staff_id=\common\models\UserAccount::find()->where(['id'=>$model->created_by])->one()->user_id;
          
            $staff=\common\models\Staff::find()->where(['id'=>$staff_id])->one();

                return $staff->fname.' '. $staff->lname;
            },'label'=>'Created by'],
            'created_at',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
