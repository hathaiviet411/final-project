<?php
/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace Repository;

use App\Models\Position;
use App\Repositories\Contracts\PositionRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class PositionRepository extends BaseRepository implements PositionRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Position $model
       */

    public function model()
    {
        return Position::class;
    }


}
