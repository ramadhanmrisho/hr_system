<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "attendance".
 *
 * @property int $id
 * @property int $staff_id
 * @property string $date
 * @property string $signin_at
 * @property string $singout_at
 * @property int|null $hours_per_day
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 */
class Attendance extends \yii\db\ActiveRecord
{
    public $attached_file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'date', 'signin_at', 'singout_at', 'created_by'], 'required'],
            [['staff_id', 'hours_per_day', 'created_by'], 'integer'],
            [['date', 'signin_at', 'singout_at', 'created_at', 'updated_at','normal_ot_hours','night_hours','special_ot_hours','attached_file','status'], 'safe'],
            [['attached_file'],'file','extensions' => ['csv'],'checkExtensionByMimeType'=>true],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff Name',
            'date' => 'Date',
            'signin_at' => 'Sign In ',
            'singout_at' => 'Sing Out',
            'hours_per_day' => 'Hours Per Day',
            'normal_ot_hours' => 'Normal OT Hours Per Day',
            'created_at' => 'Generated At',
            'updated_at' => 'Updated At',
            'created_by' => 'Uploaded By',
        ];
    }
}
