<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserAccount;

/**
 * UserAccountSearch represents the model behind the search form of `common\models\UserAccount`.
 */
class UserAccountSearch extends UserAccount
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'created_by'], 'integer'],
            [['username', 'password', 'auth_key', 'password_reset_token', 'email', 'verification_token', 'category', 'designation_abbr','created_at','updated_at'], 'safe'],
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
        $query = UserAccount::find();

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
            'user_id' => $this->user_id,
            'status' => $this->status,
            'created_by' => $this->created_by,

        ]);

        if (\Yii::$app->request->get('authorization')=='staff'){
            $query->andFilterWhere(['like','category','staff']);
        }

        if (\Yii::$app->request->get('authorization')=='student'){
            $query->andFilterWhere(['like','category','student']);
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'verification_token', $this->verification_token])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'designation_abbr', $this->designation_abbr]);

        return $dataProvider;
    }
}
