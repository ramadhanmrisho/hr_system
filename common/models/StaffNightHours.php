<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "staff_night_hours".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $days
 * @property string $description
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 *
 * @property Staff $staff
 */
class StaffNightHours extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff_night_hours';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'days', 'description', 'created_by'], 'required'],
            [['staff_id', 'days', 'created_by'], 'integer'],
            [['description', 'status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
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
            'days' => 'Night Hours',
            'description' => 'Description',
            'status' => 'Status',
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
}
