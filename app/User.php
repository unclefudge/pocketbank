<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'name', 'email', 'password', 'weekly_amount'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token',];

    protected $username = 'name';


    /**
     * A User has many transactions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trans()
    {
        return $this->hasMany('App\Transaction', 'user_id');
    }

    /**
     * Get the balance format  (getter)
     *
     * @return string;
     */
    public function getBalanceAttribute()
    {
        $balance = 0;
        foreach ($this->trans as $tran) {
            $balance = $balance + $tran->amount;
        }
        if ($balance == 0)
            return '$0';

        if ($balance < 0)
            return '<span class="text-danger">$' . substr($balance, 0, - 2) . '.' . substr($balance, - 2) . '</span>';

        return '$' . substr($balance, 0, - 2) . '.' . substr($balance, - 2);
    }


}
