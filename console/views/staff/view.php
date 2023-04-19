<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Staff */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-view">

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
            'identity_type_id',
            'id_number',
            'marital_status',
            'email:email',
            'gender',
            'employee_number',
            'category',
           ['attribute':'region_id','value':'region.name']
           ['attribute':'district_id','value':'district.name']
            'ward',
            'village',
            'division',
            'home_address',
            'house_number',
            'name_of_high_education_level',
           ['attribute':'designation_id','value':'designation.name']
           ['attribute':'department_id','value':'department.name']
            'salary_scale',
            'basic_salary',
           ['attribute':'allowance_id','value':'allowance.name']
            'helsb',
            'paye',
            'nssf',
            'nhif',
            'date_employed',
            'account_name',
            'bank_account_number',
            'alternate_phone_number',
            'createdBy.fullName',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
