<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "salary_adjustments".
 *
 * @property int $id
 * @property int $staff_id
 * @property float $amount
 * @property string $description
 * @property string $category 1- individually 2- all
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 *
 * @property User $createdBy
 * @property User $staff
 */
class SalaryAdjustments extends \yii\db\ActiveRecord
{
    public $staff_ids;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'salary_adjustments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'amount', 'description', 'category', 'created_by','staff_ids'], 'required'],
            [['staff_id', 'status', 'created_by'], 'integer'],
            [['amount'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['description'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['staff_id' => 'id']],
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
            'staff_ids' => 'Staff Names',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Staff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(User::className(), ['id' => 'staff_id']);
    }
}
