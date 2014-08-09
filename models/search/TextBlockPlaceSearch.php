<?php

namespace webvimark\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use webvimark\modules\content\models\TextBlockPlace;

/**
 * TextBlockPlaceSearch represents the model behind the search form about `webvimark\modules\content\models\TextBlockPlace`.
 */
class TextBlockPlaceSearch extends TextBlockPlace
{
	public function rules()
	{
		return [
			[['id', 'active', 'one_record', 'created_at', 'updated_at'], 'integer'],
			[['name', 'code'], 'safe'],
		];
	}

	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = TextBlockPlace::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => \Yii::$app->request->cookies->getValue('_grid_page_size', 20),
			],
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			'text_block_place.id' => $this->id,
			'text_block_place.active' => $this->active,
			'text_block_place.one_record' => $this->one_record,
			'text_block_place.created_at' => $this->created_at,
			'text_block_place.updated_at' => $this->updated_at,
		]);

        	$query->andFilterWhere(['like', 'text_block_place.name', $this->name])
			->andFilterWhere(['like', 'text_block_place.code', $this->code]);

		return $dataProvider;
	}
}
