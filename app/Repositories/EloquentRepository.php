<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Builder;

abstract class EloquentRepository
{

    public function matching($criteria = null)
    {
        $query = $this->query();

        if ($criteria) {
            foreach ($criteria as $fieldName => $value){

                if (is_array($value)){
                    if (isset($value["min"])){
                        $query->where($fieldName, ">", $value["min"]) ;
                    }
                    if (isset($value["max"])){
                        $query->where($fieldName, "<", $value["max"]) ;
                    }
                    else{
                        $query->whereIn($fieldName, $value);
                    }
                    continue;
                }

                $query->where([$fieldName => $value]) ;
            }
        }
        return $query->get();
    }

    /**
     * @return Builder
     */
    abstract protected function query(): Builder;

}
