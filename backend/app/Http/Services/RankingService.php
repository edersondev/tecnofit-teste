<?php

namespace App\Http\Services;

use App\Repository\RankingRepository;

class RankingService extends Service
{
  public function __construct(RankingRepository $repository)
  {
    $this->repository = $repository;
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function index($request)
  {
    return $this->repository->index($request)->get();
  }
}