<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "assessment_method".
 *
 * @property int $id
 * @property string $name
 * @property int $nta_level
 * @property int $course_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Course $course
 */
class AssessmentMethod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assessment_method';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'nta_level', 'course_id'], 'required'],
            [[ 'course_id'], 'integer'],
            [['created_at', 'updated_at','nta_level'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
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
            'nta_level' => 'NTA Level',
            'course_id' => 'Course Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
}
