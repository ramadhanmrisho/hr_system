<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "a_level_information".
 *
 * @property int $id
 * @property string $name_of_school
 * @property string $index_number
 * @property int $student_id
 * @property string $Physics
 * @property string $Mathematics
 * @property string $Chemistry
 * @property string $Biology
 * @property int $year_of_complition
 * @property string $division
 * @property string $a_level_certificate
 * @property string $created_at
 * @property string $updated_at
 */
class ALevelInformation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'a_level_information';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_of_school', 'index_number', 'Physics', 'Mathematics', 'Chemistry', 'Biology', 'year_of_complition', 'division', 'a_level_certificate'], 'safe'],
            [['student_id', 'year_of_complition'], 'integer'],
            [['Physics', 'Mathematics', 'Chemistry', 'Biology', 'division'], 'string'],
            [['created_at', 'updated_at', 'student_id'], 'safe'],
            [['name_of_school', 'index_number'], 'string', 'max' => 100],
            [['a_level_certificate'], 'string', 'max' => 30],
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
            'year_of_complition' => 'Year Of Completion',
            'division' => 'Division',
            'a_level_certificate' => 'A Level Certificate',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
