<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "roster".
 *
 * @property int $id
 * @property int $working_days
 * @property int $working_hours
 * @property string $status 1-Active 2-Inactive
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 */
class Roster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roster';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['working_days', 'working_hours', 'created_by'], 'required'],
            [['working_days', 'working_hours', 'created_by'], 'integer'],
            [['status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'working_days' => 'Working Days',
            'working_hours' => 'Working Hours',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }
}
