<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "final_exam".
 *
 * @property int $id
 * @property int $student_id
 * @property string $registration_number
 * @property int $academic_year_id
 * @property int $year_of_study_id
 * @property int $course_id
 * @property int $module_id
 * @property int $semester_id
 * @property string $nta_level
 * @property float $written_exam
 * @property float $practical
 * @property float $total_score
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ExamResult[] $examResults
 * @property AcademicYear $academicYear
 * @property Course $course
 * @property UserAccount $createdBy
 * @property Module $module
 * @property Student $student
 * @property YearOfStudy $yearOfStudy
 * @property Semester $semester
 */
class FinalExam extends \yii\db\ActiveRecord
{

    public  $csv_file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'final_exam';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'registration_number', 'academic_year_id', 'nta_level', 'course_id', 'module_id', 'semester_id', 'written_exam', 'practical','csv_file','created_by'], 'required'],
            [['student_id', 'academic_year_id', 'nta_level', 'course_id', 'module_id', 'semester_id', 'created_by'], 'integer'],
            [['written_exam', 'practical', 'total_score'], 'number'],
            [['created_at', 'updated_at', 'total_score','project_work'], 'safe'],
            [['registration_number'], 'string', 'max' => 100],
            ['csv_file','file','extensions' => ['csv'],'checkExtensionByMimeType'=>false],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['semester_id'], 'exist', 'skipOnError' => true, 'targetClass' => Semester::className(), 'targetAttribute' => ['semester_id' => 'id']],
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
            'registration_number' => 'Registration Number',
            'academic_year_id' => 'Academic Year',
            'nta_level' => 'NTA Level',
            'course_id' => 'Course ',
            'module_id' => 'Module Name',
            'semester_id' => 'Semester',
            'nta_level' => 'NTA Level',
            'written_exam' => 'Written Exam',
            'practical' => 'Practical Exam/OSPE/Oral Exam/Clinical',
            'project_work'=>'Project Work',
            'total_score' => 'Total Score/60',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ExamResults]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExamResults()
    {
        return $this->hasMany(ExamResult::className(), ['final_exam_id' => 'id']);
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
     * Gets query for [[Module]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Module::className(), ['id' => 'module_id']);
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
     * Gets query for [[Semester]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSemester()
    {
        return $this->hasOne(Semester::className(), ['id' => 'semester_id']);
    }
}
