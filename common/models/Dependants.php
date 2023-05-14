<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dependants".
 *
 * @property int $id
 * @property int $name
 * @property string $gender
 * @property string $dob
 * @property int $staff_id
 * @property string $created_at
 * @property string $updated_at
 */
class Dependants extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dependants';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'gender', 'dob', 'staff_id'], 'required'],
            [['name', 'staff_id'], 'integer'],
            [['gender'], 'string'],
            [['dob', 'created_at', 'updated_at'], 'safe'],
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
            'gender' => 'Gender',
            'dob' => 'Dob',
            'staff_id' => 'Staff ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
