<?php

namespace Tests\Unit\App\Http\Services;

use App\Http\Services\RankingService;
use App\Repository\RankingRepository;
use App\Models\Movement;
use App\Models\PersonalRecord;
use Tests\TestCase;

class RankingServiceTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function whenSequencialRankingIsValid()
    {
        $repository = $this->createMock(RankingRepository::class);
        $service = new RankingService($repository);

        $arrProvider = [
            ['value' => 100,'expectedResult' => 1],
            ['value' => 90,'expectedResult' => 2],
            ['value' => 90,'expectedResult' => 2],
            ['value' => 80,'expectedResult' => 3],
            ['value' => 70,'expectedResult' => 4]
        ];

        foreach($arrProvider as $itemTest) {
            $obj = new \stdClass();
            $obj->value = $itemTest['value'];
            $this->assertEquals($itemTest['expectedResult'],$service->getRanking($obj));
        }

    }

    /**
     * @test
     * @return void
     */
    public function whenShowThenReturnModelWithRanking()
    {
        $personalRecord = PersonalRecord::factory(random_int(2,5))->make();
        $movementModel = Movement::factory()->make();
        $movementModel->personalRecord = $personalRecord->sortByDesc('value');
        
        $repository = $this->createMock(RankingRepository::class);
        $repository->method('getRelations')->willReturn([]);
        $repository->method('show')->with(1)->willReturn($movementModel);
        
        $service = new RankingService($repository);

        $result = $service->show(1);

        $this->assertInstanceOf(Movement::class, $result);
        $this->assertContainsOnlyInstancesOf(PersonalRecord::class,$result->personalRecord);

        foreach($result->personalRecord as $record) {
            $this->assertTrue(array_key_exists('ranking',$record->getAttributes()));
        }

        $this->assertEquals(1,$result->personalRecord->first()->ranking);
    }

    /**
     * @test
     * @return void
     */
    public function whenIndexThenReturnCollectionWithRanking()
    {
        $stubClass = new class{
            public function get(){
                $collectionMovement = Movement::factory(random_int(2,6))->make();
                $collectionMovement->map(function($movement){
                    $personalRecord = PersonalRecord::factory(random_int(2,5))->make();
                    $movement->personalRecord = $personalRecord->sortByDesc('value');
                });
                return $collectionMovement;
            }
        };


        $repository = $this->createMock(RankingRepository::class);
        $repository->method('index')->willReturn($stubClass);

        $service = new RankingService($repository);

        $result = $service->index($this->any());

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $result);
        $this->assertContainsOnlyInstancesOf(Movement::class, $result);

        foreach($result as $movement) {
            foreach($movement->personalRecord as $record) {
                $this->assertTrue(array_key_exists('ranking',$record->getAttributes()));
            }
            $this->assertEquals(1,$movement->personalRecord->first()->ranking);
        }
    }
}
