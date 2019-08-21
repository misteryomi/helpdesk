<?php

namespace App;
use \Carbon\Carbon;

trait ModelTrait
{
    public function getFormatedDateAttribute() {
        return $this->created_at ? $this->created_at->isoFormat('MMMM Do YYYY, h:mm:ss a') : null;
    }        

    public function formatDate($date) {
        return Carbon::parse($date)->isoFormat('MMMM Do YYYY, h:mm:ss a');
    }        
}
