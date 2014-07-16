<?php

namespace app\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\content\models\TextBlock;

/**
 * TextBlockSearch represents the model behind the search form about `app\modules\content\models\TextBlock`.
 */
class TextBlockSearch extends TextBlock
{
	public function rules()
	{
		return [
			[['id', 'active', 'text_block_place_id', 'sorter', 'created_at', 'updated_at'], 'integer'],
			[['name', 'body'], 'safe'],
		];
	}

	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = TextBlock::find();

		if ( ! \Yii::$app->request->get('sort') )
		{
			$query->orderBy('sorter');
		}

		$query->joinWith(['textBlockPlace']);

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
			'id' => $this->id,
			'active' => $this->active,
			'text_block_place_id' => $this->text_block_place_id,
			'sorter' => $this->sorter,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		]);

        	$query->andFilterWhere(['like', 'name', $this->name]);

		return $dataProvider;
	}
}
