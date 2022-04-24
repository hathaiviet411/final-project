<?php
/**
 * Created by VeHo.
 * Year: 2022-04-24
 */

namespace Repository;

use App\Models\Schedule;
use App\Repositories\Contracts\ScheduleRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class ScheduleRepository extends BaseRepository implements ScheduleRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Schedule $model
       */

    public function model()
    {
        return Schedule::class;
    }


}
