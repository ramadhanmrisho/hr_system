<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "overtime_amount".
 *
 * @property int $id
 * @property float $special_ot_amount per hour
 * @property float $normal_ot_amount per hour
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property string $status
 *
 * @property User $createdBy
 */
class OvertimeAmount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'overtime_amount';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['special_ot_amount', 'normal_ot_amount', 'created_at', 'updated_at', 'created_by'], 'required'],
            [['special_ot_amount', 'normal_ot_amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by'], 'integer'],
            [['status'], 'string'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'special_ot_amount' => 'Special OT Amount',
            'normal_ot_amount' => 'Normal OT Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'status' => 'Status',
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
}
