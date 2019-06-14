<?php

namespace App\Http\Controllers;

use App\InMemoryPersistence;
use App\NanoBotRepository;

class AdventController extends Controller
{
    /**
     * Day TwentyThree Advent of Code.
     * See readme.MD for problem and proposed solution and code.
     */
    public function dayTwentyThree()
    {
        $repository  = NanoBotRepository::loadFromFile(
            app_path('../database/nanobots.data'),
            new InMemoryPersistence()
        );
        $topNano = $repository->findTopNanoBot();
        $inRange = $topNano->inRange($repository);
        return view('advent', ['nano'=>$topNano, 'inRange'=>$inRange]);
    }
}
