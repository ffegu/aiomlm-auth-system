<?php

namespace Aiomlm\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'city',
        'pin',
        'district',
        'state',
        'counrty',
        'address',
        'phonepe',
        'gpay',
        'paytm',
        'paypal',
        'cashapp',
        'applepay',
        'venmo',
        'btc_address',
        'bank_ac_no',
        'bank_ac_holder',
        'bank_ac_ifsc',
        'bank_ac_branch',
        'pan_no',
        'pan_name',
        'aadhar_no',
        'dob',
        'gstin',
        'tax_no',
        'id_proof_pic',
        'address_proof_pic',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(\Aiomlm\Auth\Models::class);
    }
}
