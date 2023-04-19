<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-account-index">


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= fedemotta\datatables\DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],



            ['attribute'=>'user_id','value'=>function($model){

            if($model->category=='staff'){
                $staff=\common\models\Staff::find()->where(['id'=>$model->user_id])->one();
                return  $staff->fname.' '.$staff->lname;
            }
            else{
                $student=\common\models\Student::find()->where(['id'=>$model->user_id])->one();

                return  $student->fname.' '.$student->lname;
            }

            },'label'=>'Name'],

            'username',

            //'password_reset_token',
            //'email:email',
            ['attribute'=>'status','value'=>function($model){

               if($model->status==10){
                   return 'Active';
               }
               else{
                   return  'InActive';
               }
            }],
            //'verification_token',
            //'category',
            //'designation_abbr',
            //'created_by',
            //'created_at',
            //'updated_at',

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
                            $url = 'index.php?r=user-account/view&id='.$model->id;
                            return $url;
                        }

                    } ,


                ],

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
