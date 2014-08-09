<?php

namespace webvimark\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use webvimark\modules\content\models\PagePlace;

/**
 * PagePlaceSearch represents the model behind the search form about `webvimark\modules\content\models\PagePlace`.
 */
class PagePlaceSearch extends PagePlace
{
	public function rules()
	{
		return [
			[['id', 'active', 'sorter', 'created_at', 'updated_at'], 'integer'],
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
		$query = PagePlace::find();

		if ( ! \Yii::$app->request->get('sort') )
		{
			$query->orderBy('page_place.sorter');
		}

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
			'page_place.id' => $this->id,
			'page_place.active' => $this->active,
			'page_place.sorter' => $this->sorter,
			'page_place.created_at' => $this->created_at,
			'page_place.updated_at' => $this->updated_at,
		]);

        	$query->andFilterWhere(['like', 'page_place.name', $this->name])
			->andFilterWhere(['like', 'page_place.code', $this->code]);

		return $dataProvider;
	}
}
