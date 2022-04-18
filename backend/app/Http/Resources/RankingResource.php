<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RankingResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    return [
			'id' => $this->user->id,
			'name' => $this->user->name,
			'ranking' => $this->ranking,
			'value' => $this->value,
			'date' => $this->date
		];
  }
}
