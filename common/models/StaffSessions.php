<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "staff_sessions".
 *
 * @property int $id
 * @property int $staff_id
 * @property string $time
 * @property string|null $client
 * @property string|null $ip
 * @property string|null $tgt
 * @property string|null $sid
 *
 * @property Staff $staff
 * @property SystemAudit[] $systemAudits
 */
class StaffSessions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff_sessions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id'], 'required'],
            [['staff_id'], 'integer'],
            [['time'], 'safe'],
            [['client', 'tgt'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 20],
            [['sid'], 'string', 'max' => 256],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'time' => 'Time',
            'client' => 'Client',
            'ip' => 'Ip',
            'tgt' => 'Tgt',
            'sid' => 'Sid',
        ];
    }

    /**
     * Gets query for [[Staff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }

    /**
     * Gets query for [[SystemAudits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSystemAudits()
    {
        return $this->hasMany(SystemAudit::className(), ['session_id' => 'id']);
    }
}
