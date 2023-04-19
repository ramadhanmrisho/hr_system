<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Student */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fname',
            'mname',
            'lname',
            'dob',
            'place_of_birth',
            'phone_number',
           ['attribute':'identity_type_id','value':'identityType.name']
            'id_number',
            'marital_status',
            'email:email',
            'gender',
            'passport_size',
            'registration_number',
           ['attribute':'nationality_id','value':'nationality.name']
           ['attribute':'region_id','value':'region.name']
           ['attribute':'district_id','value':'district.name']
            'village',
           ['attribute':'academic_year_id','value':'academicYear.name']
            'home_address',
            'course_id',
           ['attribute':'year_of_study_id','value':'yearOfStudy.name']
            'sponsorship',
            'status',
            'date_of_admission',
            'college_residence',
           ['attribute':'department_id','value':'department.name']
            'intake_type',
            'createdBy.fullName',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
