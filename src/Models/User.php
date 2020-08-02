<?php

namespace Aiomlm\Auth\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;


    protected $guard_name = 'web';
   /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'remember_token',
        'sponsor',
        'position',
        'register_ip',
        'login_ip',
        'phone',
        'leg',
        'ref_link',
        'A',
        'B',
        'C',
        'D',
        'total_a',
        'total_b',
        'total_c',
        'total_d',
        'paid_a',
        'paid_b',
        'total_sponsored',
        'mybussiness',
        'mypv',
        'total_a_pv',
        'total_b_pv',
        'total_c_pv',
        'total_d_pv',
        'total_a_bv',
        'total_b_bv',
        'total_c_bv',
        'total_d_bv',
        'total_a_sponsored',
        'total_b_sponsored',
        'total_c_sponsored',
        'total_d_sponsored',
        'total_a_matching_income',
        'total_b_matching_income',
        'paid_a_matching_income',
        'paid_b_matching_income',
        'status',
        'topup',
        'topup_date',
        'topup_option',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'mybussiness' => 'decimal:2',
        'mypv' => 'decimal:2',
        'total_a_pv' => 'decimal:2',
        'total_b_pv' => 'decimal:2',
        'total_c_pv' => 'decimal:2',
        'total_d_pv' => 'decimal:2',
        'total_a_bv' => 'decimal:2',
        'total_b_bv' => 'decimal:2',
        'total_c_bv' => 'decimal:2',
        'total_d_bv' => 'decimal:2',
        'total_a_matching_income' => 'decimal:2',
        'total_b_matching_income' => 'decimal:2',
        'paid_a_matching_income' => 'decimal:2',
        'paid_b_matching_income' => 'decimal:2',
        'topup' => 'decimal:2',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'topup_date',
    ];


    public function profile()
    {
        return $this->hasOne(\Aiomlm\Auth\Models\Profile::class);
    }

}
