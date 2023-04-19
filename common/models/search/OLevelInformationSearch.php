<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OLevelInformation;

/**
 * OLevelInformationSearch represents the model behind the search form of `common\models\OLevelInformation`.
 */
class OLevelInformationSearch extends OLevelInformation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'student_id'], 'integer'],
            [['name_of_school', 'index_number', 'division', 'o_level_certificate', 'award', 'created_at', 'updated_at'], 'safe'],
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
        $query = OLevelInformation::find();

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
            'student_id' => $this->student_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name_of_school', $this->name_of_school])
            ->andFilterWhere(['like', 'index_number', $this->index_number])
            ->andFilterWhere(['like', 'division', $this->division])
            ->andFilterWhere(['like', 'o_level_certificate', $this->o_level_certificate])
            ->andFilterWhere(['like', 'award', $this->award]);

        return $dataProvider;
    }
}
