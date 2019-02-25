<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class Token extends Model
{
    const EXPIRATION_TIME = 15; // minutes

    protected $fillable = [
        'code',
        'customer_id',
        'used'
    ];

    public function __construct(array $attributes = [])
    {
        if (! isset($attributes['code'])) {
            $attributes['code'] = $this->generateCode();
        }

        parent::__construct($attributes);
    }
    /**
     * send sms code for login and register user
     */
    public function SendCode($customer_id,$phone)
    {
        $code=$this->generateCode();
        //Smsirlaravel::ultraFastSend(['VerificationCode'=> $code],915,$phone);
        $token=new Token();
        $token->code=$code;
        $token->customer_id=$customer_id;
        $token->save();
        return true;
    }

    /**
     * Generate a six digits code
     *
     * @param int $codeLength
     * @return string
     */
    public function generateCode($codeLength = 4)
    {
        $min = pow(10, $codeLength);
        $max = $min * 10 - 1;
        $code = mt_rand($min, $max);

        return $code;
    }



    /**
     * True if the token is not used nor expired
     *
     * @return bool
     */
    public function isValid()
    {
        return ! $this->isUsed() && ! $this->isExpired();
    }

    /**
     * Is the current token used
     *
     * @return bool
     */
    public function isUsed()
    {
        return $this->used;
    }

    /**
     * Is the current token expired
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->created_at->diffInMinutes(Carbon::now()) > static::EXPIRATION_TIME;
    }
}
