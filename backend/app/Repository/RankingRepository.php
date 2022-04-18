<?php

namespace App\Repository;

use App\Models\Movement;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RankingRepository extends Repository
{
  public function __construct(Movement $entity)
  {
    $this->entity = $entity;
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @return Illuminate\Database\Eloquent\Builder
   */
  public function index($request)
  {
    return $this->entity::with($this->getRelations());
  }

  public function getRelations()
  {
    return [
      'personalRecord' => function(HasMany $query){
        $query->orderBy('value','desc');
      },
      'personalRecord.user'
    ];
  }
}