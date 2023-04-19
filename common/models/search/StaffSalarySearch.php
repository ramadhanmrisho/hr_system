<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StaffSalary;

/**
 * StaffSalarySearch represents the model behind the search form of `common\models\StaffSalary`.
 */
class StaffSalarySearch extends StaffSalary
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'staff_id', 'created_by'], 'integer'],
            [['month', 'created_at','salary_slip'], 'safe'],
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
        $query = StaffSalary::find();

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
            'month' => $this->month,
            'salary_slip' => $this->salary_slip,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
        ])->orderBy(['created_at'=>SORT_DESC]);

        return $dataProvider;
    }
}
