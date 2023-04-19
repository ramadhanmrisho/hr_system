<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nta_level".
 *
 * @property int $id
 * @property string $name
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Course[] $courses
 * @property UserAccount $createdBy
 */
class NtaLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nta_level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', ], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 30],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Courses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Course::className(), ['level_id' => 'id']);
    }


}
