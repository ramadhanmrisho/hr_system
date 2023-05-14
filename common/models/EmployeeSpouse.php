<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "employee_spouse".
 *
 * @property int $id
 * @property string $name
 * @property string $phone_number
 * @property int $staff_id
 * @property string $created_at
 * @property string $updated_at
 */
class EmployeeSpouse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_spouse';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone_number', 'staff_id'], 'required'],
            [['phone_number'], 'string'],
            [['staff_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'phone_number' => 'Phone Number',
            'staff_id' => 'Staff ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
