<?php

namespace Tests\Unit\App\Http\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Services\RankingService;
use App\Repository\RankingRepository;
use App\Models\Movement;
use App\Models\PersonalRecord;
use Tests\TestCase;

class RankingServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\Repository\RankingRepository&\PHPUnit\Framework\MockObject\MockObject
     */
    protected $_repository;

    /**
     * @var \App\Http\Services\RankingService
     */
    protected $_service;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->_repository = $this->createMock(RankingRepository::class);

        $this->_service = new RankingService($this->_repository);

        parent::setUp();
    }
    
    /**
     * @test
     * @dataProvider sequencialRankingDataProvider
     * @return void
     */
    public function whenSequencialRankingIsValid($expected, $arrValue)
    {
        foreach($arrValue as $value) {
            $this->_service->setRanking($value);
        }
        $this->assertEquals($expected,$this->_service->getRanking());
    }

    /**
     * @return array
     */
    public function sequencialRankingDataProvider(): array
    {
        return [
            'ranking 1' => [1,[100]],
            'ranking 2' => [2,[100,90]],
            'ranking 2 same points previous ranking' => [2,[100,90,90]],
            'ranking 3' => [3,[100,90,80]],
            'ranking 4' => [4,[100,90,80,70]]
        ];
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
        
        $this->_repository->method('getRelations')->willReturn([]);
        $this->_repository->method('show')->with(1)->willReturn($movementModel);

        $result = $this->_service->show(1);

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

        $this->_repository->method('index')->willReturn($stubClass);

        $result = $this->_service->index($this->any());

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
