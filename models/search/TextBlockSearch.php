<?php

namespace webvimark\modules\content\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use webvimark\modules\content\models\TextBlock;

/**
 * TextBlockSearch represents the model behind the search form about `webvimark\modules\content\models\TextBlock`.
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
			$query->orderBy('text_block.sorter');
		}

		$query->joinWith(['textBlockPlace']);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => \Yii::$app->request->cookies->getValue('_grid_page_size', 20),
			],
			'sort'=>[
				'defaultOrder'=>['id'=> SORT_DESC],
			],
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			'text_block.id' => $this->id,
			'text_block.active' => $this->active,
			'text_block.text_block_place_id' => $this->text_block_place_id,
			'text_block.sorter' => $this->sorter,
			'text_block.created_at' => $this->created_at,
			'text_block.updated_at' => $this->updated_at,
		]);

        	$query->andFilterWhere(['like', 'text_block.name', $this->name]);

		return $dataProvider;
	}
}
