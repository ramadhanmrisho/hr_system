<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "postponed_student".
 *
 * @property int $id
 * @property int $student_id
 * @property int $postone_to academic year
 * @property int $academic_year_id
 * @property string $reason
 * @property string $status
 * @property string $duration
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AcademicYear $academicYear
 * @property UserAccount $createdBy
 * @property AcademicYear $postoneTo
 * @property Student $student
 */
class PostponedStudent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'postponed_student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'postone_to', 'academic_year_id', 'reason', 'status', 'duration', 'created_by'], 'required'],
            [['student_id', 'postone_to', 'academic_year_id', 'created_by'], 'integer'],
            [['reason', 'status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['duration'], 'string', 'max' => 30],
            [['academic_year_id'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['academic_year_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['postone_to'], 'exist', 'skipOnError' => true, 'targetClass' => AcademicYear::className(), 'targetAttribute' => ['postone_to' => 'id']],
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
            'postone_to' => 'Postone To',
            'academic_year_id' => 'Academic Year ID',
            'reason' => 'Reason',
            'status' => 'Status',
            'duration' => 'Duration',
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
     * Gets query for [[PostoneTo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPostoneTo()
    {
        return $this->hasOne(AcademicYear::className(), ['id' => 'postone_to']);
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
