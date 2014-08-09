<?php

namespace webvimark\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use webvimark\modules\content\models\PageLayout;

/**
 * PageLayoutSearch represents the model behind the search form about `webvimark\modules\content\models\PageLayout`.
 */
class PageLayoutSearch extends PageLayout
{
	public function rules()
	{
		return [
			[['id', 'active', 'sorter', 'created_at', 'updated_at', 'is_main', 'is_system'], 'integer'],
			[['name'], 'safe'],
		];
	}

	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = PageLayout::find();

		if ( ! \Yii::$app->request->get('sort') )
		{
			$query->orderBy('page_layout.sorter');
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
			'page_layout.id' => $this->id,
			'page_layout.active' => $this->active,
			'page_layout.sorter' => $this->sorter,
			'page_layout.created_at' => $this->created_at,
			'page_layout.updated_at' => $this->updated_at,
			'page_layout.is_main' => $this->is_main,
			'page_layout.is_system' => $this->is_system,
		]);

        	$query->andFilterWhere(['like', 'page_layout.name', $this->name]);

		return $dataProvider;
	}
}
