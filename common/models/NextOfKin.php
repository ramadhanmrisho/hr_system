<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "next_of_kin".
 *
 * @property int $id
 * @property string $name
 * @property string $relationship
 * @property string $phone_number
 * @property string $physical_address
 * @property int $staff_id
 * @property string $created_at
 * @property string $updated_at
 */
class NextOfKin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'next_of_kin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'relationship', 'phone_number', 'physical_address', 'staff_id'], 'required'],
            [['staff_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'relationship', 'phone_number', 'physical_address'], 'string', 'max' => 100],
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
            'relationship' => 'Relationship',
            'phone_number' => 'Phone Number',
            'physical_address' => 'Physical Address',
            'staff_id' => 'Staff ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
