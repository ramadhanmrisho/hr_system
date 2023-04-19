<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "staff_allowance".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $allowance_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 *
 * @property Staff $staff
 * @property Allowance $allowance
 * @property UserAccount $createdBy
 */
class StaffAllowance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff_allowance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'allowance_id', 'created_by'], 'required'],
            [['staff_id', 'allowance_id', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
            [['allowance_id'], 'exist', 'skipOnError' => true, 'targetClass' => Allowance::className(), 'targetAttribute' => ['allowance_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'allowance_id' => 'Allowance ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[Staff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }

    /**
     * Gets query for [[Allowance]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAllowance()
    {
        return $this->hasOne(Allowance::className(), ['id' => 'allowance_id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(UserAccount::className(), ['id' => 'created_by']);
    }
}
