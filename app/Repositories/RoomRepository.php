<?php
/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace Repository;

use App\Models\Room;
use App\Repositories\Contracts\RoomRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param Room $model
       */

    public function model()
    {
        return Room::class;
    }


}
