<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "parent_information".
 *
 * @property int $id
 * @property int $full_name
 * @property int $phone_number
 * @property string $email
 * @property string $gender
 * @property int $nationality_id
 * @property string $relationship
 * @property string $occupation
 * @property string $physical_address
 * @property int $student_id
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $altenate_phone_number
 *
 * @property UserAccount $createdBy
 * @property Nationality $nationality
 * @property Student $student
 */
class ParentInformation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parent_information';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name','phone_number', 'gender', 'nationality_id', 'relationship', 'occupation', 'physical_address' ], 'required'],
            [[ 'phone_number', 'nationality_id', 'student_id',  'altenate_phone_number'], 'integer'],
            [['gender'], 'string'],
            [['created_at', 'updated_at','email', 'student_id'], 'safe'],
            [['email', 'relationship', 'occupation', 'physical_address'], 'string', 'max' => 30],
            [['nationality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nationality::className(), 'targetAttribute' => ['nationality_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'phone_number' => 'Phone Number',
            'email' => 'Email',
            'gender' => 'Gender',
            'nationality_id' => 'Nationality ',
            'relationship' => 'Relationship',
            'occupation' => 'Occupation',
            'physical_address' => 'Physical Address',
            'student_id' => 'Student ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'altenate_phone_number' => 'Alternate Phone Number',
        ];
    }



    /**
     * Gets query for [[Nationality]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNationality()
    {
        return $this->hasOne(Nationality::className(), ['id' => 'nationality_id']);
    }

    /**
     * Gets query for [[Student]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }
}
