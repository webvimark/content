<?php
namespace webvimark\modules\content\models\search;


use webvimark\modules\content\models\PagePlace;
use webvimark\modules\content\models\PageSideMenu;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PageSideMenuSearch extends PageSideMenu
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
		$query = PageSideMenu::find();

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