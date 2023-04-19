<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AssignedModule;
use common\models\UserAccount;

/**
 * AssignedModuleSearch represents the model behind the search form of `common\models\AssignedModule`.
 */
class AssignedModuleSearch extends AssignedModule
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'staff_id', 'module_id', 'course_id', 'semester_id', 'academic_year_id', 'year_of_study_id', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AssignedModule::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'staff_id' => $this->staff_id,
            'module_id' => $this->module_id,
            'course_id' => $this->course_id,
            'semester_id' => $this->semester_id,
            'department_id' => $this->department_id,
            'academic_year_id' => $this->academic_year_id,
            'year_of_study_id' => $this->year_of_study_id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $staff_department_id=\common\models\Staff::find()->where(['id'=>Yii::$app->user->identity->user_id])->one()->department_id;


        if(!UserAccount::userHas(['HR','ACC','ADMIN','PR'])){
            $query->andFilterWhere(['like','department_id',$staff_department_id]);
        }







        return $dataProvider;
    }
}
