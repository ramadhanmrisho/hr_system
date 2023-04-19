<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "time_table".
 *
 * @property int $id
 * @property int $course_id
 * @property string $time_table
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Course $course
 * @property UserAccount $createdBy
 */
class TimeTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'time_table';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_id', 'time_table', 'created_by'], 'required'],
            [['course_id', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['time_table'], 'string', 'max' => 255],
            ['time_table','file','extensions' => ['pdf'],'checkExtensionByMimeType'=>false],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => UserAccount::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => 'Course Name',
            'time_table' => 'Time Table',
            'created_by' => 'Uploaded By',
            'created_at' => 'Created At',
            'updated_at' => 'Uploaded at',
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

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(UserAccount::className(), ['id' => 'created_by']);
    }
}
