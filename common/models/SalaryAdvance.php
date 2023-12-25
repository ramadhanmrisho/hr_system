<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "salary_advance".
 *
 * @property int $id
 * @property int $staff_id
 * @property float $amount
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 */
class SalaryAdvance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'salary_advance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'created_by'], 'required'],
            [['staff_id', 'created_by'], 'integer'],
            [['status'], 'string'],
            [['created_at', 'updated_at', 'amount'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff Name',
            'amount' => 'Amount',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }
}
