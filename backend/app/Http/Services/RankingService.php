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
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function index($request)
  {
    $collection = $this->repository->index($request)->get();

    $collection->map(function($movement){
      $movement->personalRecord->map(function($record){
        $record->ranking = $this->getRanking($record);
        return $record;
      });
      $this->resetVariables();
      return $movement;
    });
    
    return $collection;
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
   * @param App\Models\PersonalRecord $record
   * @return int
   */
  public function getRanking($record)
  {
    if(!in_array($record->value,$this->_listRecord,true)){
      $this->_rank++;
    }
    $this->storeValueRecord($record->value);
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