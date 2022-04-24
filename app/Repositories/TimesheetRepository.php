<?php
/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace Repository;

use App\Models\Timesheet;
use App\Repositories\Contracts\TimesheetRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class TimesheetRepository extends BaseRepository implements TimesheetRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Timesheet $model
       */

    public function model()
    {
        return Timesheet::class;
    }


}
