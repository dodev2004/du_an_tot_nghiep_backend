<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
/**
 * Class UserService
 * @package App\Services
 */
class BaseRespository implements BaseRepositoryInterface
{
    protected $model;
    public function __construct(
        Model $model
    )
    {
        $this->model = $model;
    }
    public function all(){
        return $this->model->all();
    }
    public function findId($id)
    {
        return $this->model->find($id);
    }
  
}
