<?php

namespace App\Providers;

use App\Models\Ward;
use App\Repositories\DistrictRepository;
use App\Repositories\Interfaces\DistrictRepositoryInterface;
use App\Repositories\Interfaces\ProvinceRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\WardRepositoryInterface;
use App\Repositories\WardRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\UserCatelogueRespositoryInterface;
use App\Repositories\UserCatelogueRespository;
use App\Repositories\PostRepository;
use App\Repositories\Interfaces\AttributeRepositoryInterface ;
use App\Repositories\AttributeRepository;
use App\Repositories\AttributeValueRepository;
use App\Repositories\Interfaces\AttributeValueRepositoryInterface;
use App\Repositories\Interfaces\ProductCatelogueRepositoryInterface;
use App\Repositories\ProductCatelogueRepository;

// Service
use App\Services\UserService;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\UserCatelogueService;
use App\Services\Interfaces\UserCatelogueServiceInterface;
use App\Repositories\Interfaces\PostCatelogueRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\PostCatelogueRespository;
use App\Services\Interfaces\PostCatelogueServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\PostCatelogueService;
use App\Services\PostService;
use App\Services\Interfaces\AttributeServiceInterface;
use App\Services\AttributeService;
use App\Services\Interfaces\AttributeValueServiceInterface;
use App\Services\AttributeValueService;
use App\Services\Interfaces\ProductCatelogueServiceInterface;
use App\Services\ProductCatelogueService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
   protected $binding  = [
    ProvinceRepositoryInterface::class => ProvinceRepository::class,
    DistrictRepositoryInterface::class => DistrictRepository::class,
    WardRepositoryInterface::class => WardRepository::class,
    UserServiceInterface::class => UserService::class,
    UserCatelogueRespositoryInterface::class => UserCatelogueRespository::class,
    UserCatelogueServiceInterface::class => UserCatelogueService::class,
    PostCatelogueRepositoryInterface::class => PostCatelogueRespository::class,
    PostCatelogueServiceInterface::class => PostCatelogueService::class,
    PostRepositoryInterface::class =>PostRepository::class ,
    PostServiceInterface::class=> PostService::class,
    AttributeRepositoryInterface::class => AttributeRepository::class,  
    AttributeServiceInterface::class => AttributeService::class,
    AttributeValueRepositoryInterface::class => AttributeValueRepository::class,  
    AttributeValueServiceInterface::class => AttributeValueService::class,
    ProductCatelogueRepositoryInterface::class => ProductCatelogueRepository::class,
    ProductCatelogueServiceInterface::class => ProductCatelogueService::class,

   ];
    public function register(): void
    {
        $this->app->singleton(UserRepositoryInterface::class,UserRepository::class);
        foreach($this->binding as $interface => $intance){
            $this->app->bind($interface, $intance);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
      
    }
}
