<?php

namespace App\Http\Services;

use App\Repository\RankingRepository;

class RankingService extends Service
{

  protected $_listRecord = [];
  protected $_rank = 0;

  public function __construct(RankingRepository $repository)
  {
    $this->repository = $repository;
  }

  /**
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function index($request)
  {
    $collection = $this->repository->index($request)->get();

    $collection->map(function($movement){
      $movement->personalRecord->map(function($record){
        $this->setRanking($record->value);
        $record->ranking = $this->getRanking();
        return $record;
      });
      $this->resetVariables();
      return $movement;
    });
    
    return $collection;
  }

  public function show(int $id, array $relations = [])
  {
    $objModel = $this->repository->show($id,$this->repository->getRelations());
    $objModel->personalRecord->map(function($record){
      $this->setRanking($record->value);
      $record->ranking = $this->getRanking();
      return $record;
    });
    
    return $objModel;
  }

  /**
   * @param int $recordValue
   * @return void
   */
  public function storeValueRecord($recordValue)
  {
    if(!in_array($recordValue,$this->_listRecord,true)){
      array_push($this->_listRecord,$recordValue);
    }
  }

  /**
   * @param int $recordValue
   * @return void
   */
  public function setRanking($recordValue)
  {
    if(!in_array($recordValue,$this->_listRecord,true)){
      $this->_rank++;
    }
    $this->storeValueRecord($recordValue);
  }

  /**
   * @return int
   */
  public function getRanking()
  {
    return $this->_rank;
  }

  /**
   * @return void
   */
  public function resetVariables()
  {
    $this->_listRecord = [];
    $this->_rank = 0;
  }
}