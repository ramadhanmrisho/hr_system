<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "exam_result".
 *
 * @property int $id
 * @property int $student_id
 * @property int $academic_year_id
 * @property int $year_of_study_id
 * @property int $course_id
 * @property int $semester_id
 * @property int $module_id
 * @property float $coursework
 * @property int $final_exam_id
 * @property float $total_score
 * @property int $grade_id
 * @property string $remarks
 * @property string $category
 * @property string $status
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AcademicYear $academicYear
 * @property Grade $grade
 * @property Course $course
 * @property UserAccount $createdBy
 * @property FinalExam $finalExam
 * @property Module $module
 * @property Semester $semester
 * @property Student $student
 * @property YearOfStudy $yearOfStudy
 * @property Gpa[] $gpas
 */
class ExamResult extends \yii\db\ActiveRecord
{
    
    public $total_sup;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exam_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'academic_year_id', 'nta_level', 'course_id', 'semester_id', 'module_id', 'coursework', 'final_exam_id', 'total_score', 'grade_id', 'remarks', 'category', 'status', 'created_by','final_exam_score'], 'required'],
            [['student_id', 'academic_year_id', 'course_id', 'semester_id', 'module_id', 'final_exam_id', 'grade_id', 'created_by'], 'integer'],
            [['coursework', 'total_score','final_exam_score'], 'number'],
            [['remarks', 'category', 'status'], 'string'],
            [['created_at', 'updated_at','points','total_sup'], 'safe'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'id']],
            [['grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grade::className(), 'targetAttribute' => ['grade_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['final_exam_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinalExam::className(), 'targetAttribute' => ['final_exam_id' => 'id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
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
            'student_id' => 'Student Name',
            'academic_year_id' => 'Academic Year ',
            'nta_level' => 'NTA Level ',
            'course_id' => 'Course ',
            'semester_id' => 'Semester ',
            'module_id' => 'Module Name',
            'coursework' => 'Coursework',
            'final_exam_score' => 'Semester Exam score',
            'final_exam_id' => 'Final Exam ',
            'total_score' => 'Total Score',
            'grade_id' => 'Grade',
            'points' => 'Points',
            'remarks' => 'Remarks',
            'category' => 'Category',
            'status' => 'Status',
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
     * Gets query for [[Grade]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrade()
    {
        return $this->hasOne(Grade::className(), ['id' => 'grade_id']);
    }

    /**
     * Gets query for [[Course]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
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
     * Gets query for [[FinalExam]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFinalExam()
    {
        return $this->hasOne(FinalExam::className(), ['id' => 'final_exam_id']);
    }

    /**
     * Gets query for [[Module]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Module::className(), ['id' => 'module_id']);
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




    /**
     * Gets query for [[Gpas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGpas()
    {
        return $this->hasMany(Gpa::className(), ['exam_result_id' => 'id']);
    }
}
