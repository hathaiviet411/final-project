<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;

class FeedbackSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Feedback::create([
      'feedback_title' => 'Sếp chửi nhân viên như hát hay',
      'feedback_content' => 'Ngồi chơi tí mà Sếp chửi em trời đất quay cuồng',
      'upload_date' => '2022-04-18',
      'subject' => 'Tố cáo',
      'status' => 1,
      'user_id' => 1,
      'department_id' => 1,
      'position_id' => 1,
    ]);

    Feedback::create([
      'feedback_title' => 'Tăng lương hoặc đốt homestay',
      'feedback_content' => 'Nhà nhiều miệng ăn, vui lòng tăng lương hoặc xây lại homestay mới',
      'upload_date' => '2022-04-18',
      'subject' => 'Khác',
      'status' => 2,
      'user_id' => 1,
      'department_id' => 1,
      'position_id' => 1,
    ]);

    Feedback::create([
      'feedback_title' => 'Đòng phục xấu quá đê',
      'feedback_content' => 'Em mặc đồng phục của nhà mình mà ra đời bị bọn trẻ con ở xóm chế xấu như ma chê quỷ hờn',
      'upload_date' => '2022-04-18',
      'subject' => 'Đề nghị',
      'status' => 3,
      'user_id' => 1,
      'department_id' => 1,
      'position_id' => 1,
    ]);
  }
}
