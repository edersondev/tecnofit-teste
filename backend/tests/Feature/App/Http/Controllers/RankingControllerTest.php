<?php

namespace Tests\Feature\App\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use App\Models\Movement;
use App\Models\PersonalRecord;
use Tests\TestCase;

class RankingControllerTest extends TestCase
{
  use RefreshDatabase;

  /**
   * @test
   * @return void
   */
  public function whenIndexThenReturnSuccess()
  {
    $countMovement = 4;
    Movement::factory($countMovement)->has(PersonalRecord::factory(6))->create();
    
    $response = $this->get('/api/ranking');
    
    $response->assertStatus(200);

    $response->assertJson(fn (AssertableJson $json) =>
      $json->has('data')
        ->has('data',$countMovement)
        ->has('data.0', fn ($json) => 
          $json->has('users')
            ->has('users.0', fn ($json) => 
              $json->has('ranking')->where('ranking',1)
              ->etc()
            )
            ->etc()
        )
    );

    $response->assertJsonCount($countMovement, 'data');
  }

  /**
   * @test
   * @return void
   */
  public function whenIndexThenReturnEmpty()
  {
    $response = $this->get('/api/ranking');
    $response->assertStatus(200);

    $response->assertJson(fn (AssertableJson $json) =>
      $json->has('data')
    );
    $response->assertJsonCount(0, 'data');
  }

  /**
   * @test
   * @return void
   */
  public function whenShowThenReturnSuccess()
  {
    Movement::factory(1)->has(PersonalRecord::factory(2))->create();

    $response = $this->get('/api/ranking/1');
    $response->assertStatus(200);

    $response->assertJson(fn (AssertableJson $json) =>
      $json->has('data',3)
        ->first(fn ($json) => 
          $json->has('users')
            ->has('users.0', fn ($json) => 
              $json->has('ranking')
                ->has('value')
                ->where('ranking',1)
                ->etc()
            )
            ->etc()
        )
    );
  }

  /**
   * @test
   * @return void
   */
  public function whenShowThenReturnNotFound()
  {
    $response = $this->get('/api/ranking/1');
    $response->assertStatus(404);
  }
}
