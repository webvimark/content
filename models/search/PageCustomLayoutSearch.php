<?php

namespace webvimark\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use webvimark\modules\content\models\PageCustomLayout;

/**
 * PageCustomLayoutSearch represents the model behind the search form about `webvimark\modules\content\models\PageCustomLayout`.
 */
class PageCustomLayoutSearch extends PageCustomLayout
{
	public function rules()
	{
		return [
			[['id', 'active', 'type', 'created_at', 'updated_at'], 'integer'],
			[['name', 'path'], 'safe'],
		];
	}

	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = PageCustomLayout::find();

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
			'page_custom_layout.id' => $this->id,
			'page_custom_layout.active' => $this->active,
			'page_custom_layout.type' => $this->type,
			'page_custom_layout.created_at' => $this->created_at,
			'page_custom_layout.updated_at' => $this->updated_at,
		]);

        	$query->andFilterWhere(['like', 'page_custom_layout.name', $this->name])
			->andFilterWhere(['like', 'page_custom_layout.path', $this->path]);

		return $dataProvider;
	}
}
