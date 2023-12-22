<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "union_contribution".
 *
 * @property int $id
 * @property int $staff_id
 * @property float $amount
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property string $status
 */
class UnionContribution extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'union_contribution';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'amount', 'description', 'created_by'], 'required'],
            [['staff_id', 'created_by'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'string'],
            [['description'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'status' => 'Status',
        ];
    }
}
