<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\StaffSalarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employee Salary Slip';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="staff-salary-index">


    <?php Pjax::begin(); ?>
    <?php if (\common\models\UserAccount::userHas(['HR','ACC','ADMIN'])){?>

    <p>
        <?= Html::a('<span class="fa fa-file-text-o"> Generate Salary Slip</span>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php }?>
    <?= \fedemotta\datatables\DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],



            ['attribute'=>'staff_id','value'=>function($model){

                $staff=\common\models\Staff::find()->where(['id'=>$model->staff_id])->one();
                return  $staff->fname.' '.$staff->lname;
            }],
            'month',
            'created_at',
            ['class' => 'yii\grid\ActionColumn',

                'template'=>'{view}',
                'contentOptions' => ['style' => 'width:100px;'],
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

                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url = 'index.php?r=staff-salary/view&id='.$model->id;
                            return $url;
                        }

                    } ,


                ],



            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
