<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "a_level_grade_score".
 *
 * @property int $id
 * @property int|null $student_id
 * @property int|null $subject_id
 * @property string|null $grade
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Student $student
 * @property OlevelAndAlevelSubject $subject
 */
class ALevelGradeScore extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'a_level_grade_score';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'subject_id'], 'integer'],
            [['grade'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => OlevelAndAlevelSubject::className(), 'targetAttribute' => ['subject_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student ID',
            'subject_id' => 'Subject ID',
            'grade' => 'Grade',
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

    /**
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(OlevelAndAlevelSubject::className(), ['id' => 'subject_id']);
    }
}
