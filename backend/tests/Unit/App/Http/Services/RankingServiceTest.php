<?php

namespace Tests\Unit\App\Http\Services;

use App\Http\Services\RankingService;
use App\Repository\RankingRepository;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class RankingServiceTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function whenGetRankingThenReturnANumber()
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
}
