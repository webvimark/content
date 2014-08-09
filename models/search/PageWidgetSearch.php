<?php

namespace webvimark\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use webvimark\modules\content\models\PageWidget;

/**
 * PageWidgetSearch represents the model behind the search form about `webvimark\modules\content\models\PageWidget`.
 */
class PageWidgetSearch extends PageWidget
{
	public function rules()
	{
		return [
			[['id', 'active', 'sorter', 'position', 'has_settings', 'created_at', 'updated_at'], 'integer'],
			[['name', 'description', 'class', 'options', 'settings_url'], 'safe'],
		];
	}

	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = PageWidget::find();

		if ( ! \Yii::$app->request->get('sort') )
		{
			$query->orderBy('page_widget.sorter');
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
			'page_widget.id' => $this->id,
			'page_widget.active' => $this->active,
			'page_widget.sorter' => $this->sorter,
			'page_widget.position' => $this->position,
			'page_widget.has_settings' => $this->has_settings,
			'page_widget.created_at' => $this->created_at,
			'page_widget.updated_at' => $this->updated_at,
		]);

        	$query->andFilterWhere(['like', 'page_widget.name', $this->name])
			->andFilterWhere(['like', 'page_widget.description', $this->description])
			->andFilterWhere(['like', 'page_widget.class', $this->class])
			->andFilterWhere(['like', 'page_widget.options', $this->options])
			->andFilterWhere(['like', 'page_widget.settings_url', $this->settings_url]);

		return $dataProvider;
	}
}
