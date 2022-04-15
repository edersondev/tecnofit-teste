<?php

namespace App\Http\Services;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Service extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  protected $repository;

  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Pagination\LengthAwarePaginator
   */
  public function index($request)
  {
    $per_page = ($request->has('per_page') ? $request->per_page : 10);
    if($per_page > 100) {$per_page = 100;}
    return $this->repository->index($request)->paginate($per_page);
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Database\Eloquent\Model
   */
  public function store($request)
  {
    return $this->repository->store($request);
  }

  /**
   * @param int $id
   * @param \Illuminate\Http\Request $request
   * @return void
   */
  public function update(int $id, $request)
  {
    $this->repository->update($id,$request);
  }

  /**
   * @param int $id
   * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\ModelNotFoundException
   */
  public function show(int $id, array $relations = [])
  {
    return $this->repository->show($id, $relations);
  }

  /**
   * @param int $id
   * @return void
   */
  public function destroy(int $id)
  {
    $this->repository->destroy($id);
  }

}
