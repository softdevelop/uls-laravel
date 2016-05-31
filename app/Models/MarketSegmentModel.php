<?php namespace App\Models;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class MarketSegmentModel extends Model
{
	protected $table = 'marketsegments';

	protected $fillable = ['name', 'active', 'alias_name'];

	/**
	 * get list maket segment
	 * @return object market segments
	 */
	public function listMarketSegments()
	{
		return $this->where('active',1)->lists('name', 'id');
	}

	/**
	 * create new market segment
	 * @param  object $data data
	 * @return array       status, maket segment
	 */
	public function createNewmarketSegment($data)
	{
		$data['alias_name'] = str_replace(" ", "_", strtolower($data['name']));
		$marketSegment = $this->create($data);
		return ['marketSegment' => $marketSegment];
	}

	/**
	 * update a market segment
	 * @param  int $id   id of maket segment
	 * @param  object $data data
	 * @return array       status, maket segments
	 */
	public function updatemarketSegmentById($id, $data)
	{
		$marketSegment = $this->find($id);
		$data['alias_name'] = str_replace(" ", "_", strtolower($data['name']));
		$marketSegment->update($data);
		return ['marketSegment' => $marketSegment];
	}
}