<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Transaction extends Model {

    protected $table = 'transactions';
    protected $fillable = ['user_id', 'name', 'amount', 'created_by'];

    /**
     * A Notify belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * Get the Amount format  (getter)
     *
     * @return string;
     */
    public function getAmountFormatAttribute()
    {
        if ($this->amount < 0)
            return '<span class="text-danger">$' . substr($this->amount, 0, - 2) . '.' . substr($this->amount, - 2) . '</span>';

        return '$' . substr($this->amount, 0, - 2) . '.' . substr($this->amount, - 2);
    }
}
