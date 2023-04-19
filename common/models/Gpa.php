<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gpa".
 *
 * @property int $id
 * @property int $student_id
 * @property int $academic_year_id
 * @property int $exam_result_id
 * @property int $semester_id
 * @property float $gpa
 * @property int $gpa_class_id
 * @property string $remark
 * @property int $created_by
 * @property string|null $created_at
 * @property string $updated_at
 *
 * @property AcademicYear $academicYear
 * @property UserAccount $createdBy
 * @property ExamResult $examResult
 * @property GpaClass $gpaClass
 * @property Semester $semester
 * @property Student $student
 */
class Gpa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gpa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'academic_year_id', 'exam_result_id', 'semester_id', 'gpa', 'gpa_class_id', 'remark', 'created_by'], 'required'],
            [['student_id', 'academic_year_id', 'exam_result_id', 'semester_id', 'gpa_class_id', 'created_by'], 'integer'],
            [['gpa'], 'number'],
            [['remark'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['exam_result_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExamResult::className(), 'targetAttribute' => ['exam_result_id' => 'id']],
            [['gpa_class_id'], 'exist', 'skipOnError' => true, 'targetClass' => GpaClass::className(), 'targetAttribute' => ['gpa_class_id' => 'id']],
            [['semester_id'], 'exist', 'skipOnError' => true, 'targetClass' => Semester::className(), 'targetAttribute' => ['semester_id' => 'id']],
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
            'student_id' => 'Student ID',
            'academic_year_id' => 'Academic Year ID',
            'exam_result_id' => 'Exam Result ID',
            'semester_id' => 'Semester ID',
            'gpa' => 'Gpa',
            'gpa_class_id' => 'Gpa Class ID',
            'remark' => 'Remark',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[AcademicYear]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAcademicYear()
    {
        return $this->hasOne(AcademicYear::className(), ['id' => 'academic_year_id']);
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

    /**
     * Gets query for [[ExamResult]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamResult()
    {
        return $this->hasOne(ExamResult::className(), ['id' => 'exam_result_id']);
    }

    /**
     * Gets query for [[GpaClass]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGpaClass()
    {
        return $this->hasOne(GpaClass::className(), ['id' => 'gpa_class_id']);
    }

    /**
     * Gets query for [[Semester]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSemester()
    {
        return $this->hasOne(Semester::className(), ['id' => 'semester_id']);
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
