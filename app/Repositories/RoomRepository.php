<?php

/**
 * Created by VeHo.
 * Year: 2022-04-21
 */

namespace Repository;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Repositories\Contracts\RoomRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

  public function getAll()
  {
      return $this->model->select('id', 'room_name')->get();
  }

  public function getPagination(RoomRequest $request)
  {
      $result = $this->paginate($request->per_page);
      return $result;
  }

  public function create(array $attribute)
  {
    $status = DB::transaction(function () use ($attribute) {
      $this->model->create([
        'room_number' => $attribute['room_number'],
        'building_id' => $attribute['building_id'],
        'room_type' => $attribute['room_type'],
        'room_capacity' => $attribute['room_capacity'],
        'level' => $attribute['level'],
        'room_information' => $attribute['room_information'],
        'room_status' => $attribute['room_status'],
        'created_by' => Auth::id(),
      ]);
    });

    return $status;
  }

  public function update(array $request, $id)
  {
      $status = DB::transaction(function () use ($request, $id) {
          $room = $this->model->where('id', $id)->first();
          $room->room_number = $request['room_number'];
          $room->building_id = $request['building_id'];
          $room->room_type = $request['room_type'];
          $room->room_capacity = $request['room_capacity'];
          $room->level = $request['level'];
          $room->room_information = $request['room_information'];
          $room->room_status = $request['room_status'];
          $room->save();
      });

      return $status;
  }

  public function getOne($id)
  {
      $room = $this->model->find($id);
      return $room;
  }
  
  public function destroy($id)
  {
      return $this->model->where('id', $id)->delete($id);
  }
}
