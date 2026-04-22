<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'code',
        'type',
        'used',
        'expires_at',
    ];

    protected $casts = [
        'used' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Generate a new OTP code
     */
    public static function generateCode()
    {
        return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Create a new OTP for the given email and type
     */
    public static function createOtp($email, $type)
    {
        // Mark any existing unused OTPs for this email and type as used
        self::where('email', $email)
            ->where('type', $type)
            ->where('used', false)
            ->update(['used' => true]);

        // Create new OTP
        return self::create([
            'email' => $email,
            'code' => self::generateCode(),
            'type' => $type,
            'expires_at' => Carbon::now()->addMinutes(10), // 10 minutes expiry
        ]);
    }

    /**
     * Verify an OTP code
     */
    public static function verifyCode($email, $code, $type)
    {
        $otp = self::where('email', $email)
            ->where('code', $code)
            ->where('type', $type)
            ->where('used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($otp) {
            $otp->update(['used' => true]);

            return true;
        }

        return false;
    }

    /**
     * Clean up expired OTPs
     */
    public static function cleanup()
    {
        self::where('expires_at', '<', Carbon::now())->delete();
    }
}
