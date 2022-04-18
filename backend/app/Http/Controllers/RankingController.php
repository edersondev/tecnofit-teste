<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\RankingService;
use App\Http\Resources\MovementCollection;
use App\Http\Resources\MovementResource;

class RankingController extends Controller
{

	protected $service;

	public function __construct(RankingService $service)
	{
		$this->service = $service;
	}

  /**
   * Exibe a lista de movimentos
   *
   * @return \App\Http\Resources\MovementCollection
   */
  public function index(Request $request)
  {
    return new MovementCollection($this->service->index($request));
  }

	/**
	 * Exibe detalhes do movimento
	 * @param int $id
	 * @return \App\Http\Resources\MovementResource
	 */
	public function show(int $id)
	{
		return MovementResource::make($this->service->show($id));
	}

}
