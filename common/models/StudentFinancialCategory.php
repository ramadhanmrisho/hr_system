<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student_financial_category".
 *
 * @property int $id
 * @property int $student_id
 * @property string $category
 * @property int $academic_year_id
 * @property int $year_of_study
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AcademicYear $academicYear
 * @property UserAccount $createdBy
 * @property Student $student
 * @property YearOfStudy $yearOfStudy
 */
class StudentFinancialCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_financial_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'category', 'academic_year_id', 'year_of_study', 'created_by'], 'required'],
            [['student_id', 'academic_year_id', 'year_of_study', 'created_by'], 'integer'],
            [['category'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['year_of_study'], 'exist', 'skipOnError' => true, 'targetClass' => YearOfStudy::className(), 'targetAttribute' => ['year_of_study' => 'id']],
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
            'category' => 'Category',
            'academic_year_id' => 'Academic Year ID',
            'year_of_study' => 'Year Of Study',
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
     * Gets query for [[Student]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }

    /**
     * Gets query for [[YearOfStudy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getYearOfStudy()
    {
        return $this->hasOne(YearOfStudy::className(), ['id' => 'year_of_study']);
    }
}
