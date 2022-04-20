<?php

namespace App\Providers;


use App\Repositories\Contracts\BaseRepositoryInterface;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Repositories\Contracts\NoticesRepositoryInterface;
use App\Repositories\Contracts\NoticeViewerRepositoryInterface;
use App\Repositories\Contracts\GroupChatRepositoryInterface;
use App\Repositories\Contracts\GroupChatUserRepositoryInterface;
use App\Repositories\Contracts\MessageRepositoryInterface;
use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use Repository\BaseRepository;
use Repository\AuthRepository;

use Repository\RoleRepository;
use Repository\DepartmentRepository;
use Repository\NoticesRepository;
use Repository\NoticeViewerRepository;
use Repository\GroupChatRepository;
use Repository\GroupChatUserRepository;
use Repository\MessageRepository;
use Repository\TaskRepository;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);

        //Customer
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
//        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(NoticesRepositoryInterface::class, NoticesRepository::class);
        $this->app->bind(NoticeViewerRepositoryInterface::class, NoticeViewerRepository::class);
        $this->app->bind(GroupChatRepositoryInterface::class, GroupChatRepository::class);
        $this->app->bind(GroupChatUserRepositoryInterface::class, GroupChatUserRepository::class);
        $this->app->bind(MessageRepositoryInterface::class, MessageRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
