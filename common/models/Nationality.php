<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nationality".
 *
 * @property int $id
 * @property string $name
 *
 * @property ParentInformation[] $parentInformations
 * @property Student[] $students
 */
class Nationality extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nationality';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
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
        ];
    }

    /**
     * Gets query for [[ParentInformations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentInformations()
    {
        return $this->hasMany(ParentInformation::className(), ['nationality_id' => 'id']);
    }

    /**
     * Gets query for [[Students]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['nationality_id' => 'id']);
    }
}
