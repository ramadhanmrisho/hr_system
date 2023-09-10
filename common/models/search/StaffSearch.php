<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Staff;

/**
 * StaffSearch represents the model behind the search form of `common\models\Staff`.
 */
class StaffSearch extends Staff
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'identity_type_id', 'region_id', 'district_id', 'designation_id', 'department_id', 'allowance_id','bank_account_number', 'alternate_phone_number', 'created_by'], 'integer'],
            [[ 'helsb', 'paye', 'nssf', 'nhif'], 'safe'],
            [['fname', 'mname', 'lname', 'dob', 'place_of_birth', 'phone_number', 'id_number', 'marital_status', 'email', 'gender', 'employee_number', 'category',  'village', 'programme_pursued', 'home_address', 'name_of_high_education_level','date_employed', 'account_name', 'created_at', 'updated_at','contract_end_date','contract_termination_date'], 'safe'],
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
        $query = Staff::find();

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
            'dob' => $this->dob,
            'identity_type_id' => $this->identity_type_id,
            'region_id' => $this->region_id,
            'district_id' => $this->district_id,

            'designation_id' => $this->designation_id,
            'department_id' => $this->department_id,
            'basic_salary' => $this->basic_salary,
            'allowance_id' => $this->allowance_id,

            'date_employed' => $this->date_employed,
            'bank_account_number' => $this->bank_account_number,
            'alternate_phone_number' => $this->alternate_phone_number,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        

        $query->andFilterWhere(['like', 'fname', $this->fname])
            ->andFilterWhere(['like', 'mname', $this->mname])
            ->andFilterWhere(['like', 'lname', $this->lname])
            ->andFilterWhere(['like', 'place_of_birth', $this->place_of_birth])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'id_number', $this->id_number])
            ->andFilterWhere(['like', 'marital_status', $this->marital_status])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'employee_number', $this->employee_number])
            ->andFilterWhere(['like', 'category', $this->category])

            ->andFilterWhere(['like', 'village', $this->village])
            ->andFilterWhere(['like', 'home_address', $this->home_address])
            ->andFilterWhere(['like', 'name_of_high_education_level', $this->name_of_high_education_level])
            ->andFilterWhere(['like', 'account_name', $this->account_name]);

        return $dataProvider;
    }
}
