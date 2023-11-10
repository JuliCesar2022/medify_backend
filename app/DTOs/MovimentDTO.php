<?php

namespace App\DTOs;

class MovimentDTO
{
    public $amount;
    public $type;
    public $table_ref;

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getTableRef()
    {
        return $this->table_ref;
    }

    /**
     * @param mixed $table_ref
     */
    public function setTableRef($table_ref): void
    {
        $this->table_ref = $table_ref;
    }


}
