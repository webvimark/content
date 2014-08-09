<?php

namespace webvimark\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use webvimark\modules\content\models\Page;

/**
 * PageSearch represents the model behind the search form about `webvimark\modules\content\models\Page`.
 */
class PageSearch extends Page
{
	public function rules()
	{
		return [
			[['id', 'active', 'sorter', 'parent_id', 'page_place_id', 'page_layout_id', 'created_at', 'updated_at'], 'integer'],
			[['name', 'url', 'meta_title', 'meta_keywords', 'meta_description'], 'safe'],
		];
	}

	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = Page::find();

		if ( ! \Yii::$app->request->get('sort') )
		{
			$query->orderBy('page.sorter');
		}

		$query->joinWith(['pagePlace', 'pageLayout']);

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
			'page.id' => $this->id,
			'page.active' => $this->active,
			'page.sorter' => $this->sorter,
			'page.parent_id' => $this->parent_id,
			'page.page_place_id' => $this->page_place_id,
			'page.page_layout_id' => $this->page_layout_id,
			'page.created_at' => $this->created_at,
			'page.updated_at' => $this->updated_at,
		]);

        	$query->andFilterWhere(['like', 'page.name', $this->name])
			->andFilterWhere(['like', 'page.url', $this->url])
			->andFilterWhere(['like', 'page.meta_title', $this->meta_title])
			->andFilterWhere(['like', 'page.meta_keywords', $this->meta_keywords])
			->andFilterWhere(['like', 'page.meta_description', $this->meta_description]);

		return $dataProvider;
	}
}
