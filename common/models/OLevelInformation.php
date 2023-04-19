<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "o_level_information".
 *
 * @property int $id
 * @property string $name_of_school
 * @property string $index_number
 * @property int $student_id
 * @property string $Physics
 * @property string $Mathematics
 * @property string $Chemistry
 * @property string $Biology
 * @property string $English
 * @property int $year_of_complition
 * @property string $division
 * @property string $o_level_certificate
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Student $student
 */
class OLevelInformation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'o_level_information';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_of_school', 'index_number', 'Physics', 'Mathematics', 'Chemistry', 'Biology', 'English', 'year_of_complition', 'division', 'o_level_certificate'], 'required'],
            [['student_id', 'year_of_complition'], 'integer'],
            [['Physics', 'Mathematics', 'Chemistry', 'Biology', 'English', 'division'], 'string'],
            [['created_at', 'updated_at', 'student_id'], 'safe'],
            [['name_of_school', 'index_number', 'o_level_certificate'], 'string', 'max' => 100],
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
            'name_of_school' => 'Name Of School',
            'index_number' => 'Index Number',
            'student_id' => 'Student ID',
            'Physics' => 'Physics',
            'Mathematics' => 'Mathematics',
            'Chemistry' => 'Chemistry',
            'Biology' => 'Biology',
            'English' => 'English',
            'year_of_complition' => 'Year Of Completion',
            'division' => 'Division',
            'o_level_certificate' => 'O Level Certificate',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
