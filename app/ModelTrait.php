<?php

namespace App;

trait ModelTrait
{
    public function getFormatedDateAttribute() {
        return $this->created_at ? $this->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a') : null;
    }        
}
