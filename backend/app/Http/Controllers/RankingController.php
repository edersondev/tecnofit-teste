<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\RankingService;
use App\Http\Resources\RankingCollection;

class RankingController extends Controller
{

	protected $service;

	public function __construct(RankingService $service)
	{
		$this->service = $service;
	}

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return new RankingCollection($this->service->index($request));
  }

}
