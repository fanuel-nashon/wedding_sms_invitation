<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Contributor extends Model
{
    use SoftDeletes;

    protected $table = 'contributors';

    protected $fillable = [
        'name',
        'phone_no',
        'assigned_seats',
        'status',
        'qr_code',
        'text_code',
        'sms_message_id',
        'sms_delivery_status',
        'sms_delivery_updated_at',
        'sms_resent_at',
    ];

    protected $casts = [
        'sms_delivery_updated_at' => 'datetime',
        'sms_resent_at' => 'datetime',
    ];

    public function ensureInvitationCode(): string
    {
        if ($this->text_code) {
            return $this->text_code;
        }

        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        do {
            $code = $letters[random_int(0, 25)]
                . $letters[random_int(0, 25)]
                . random_int(0, 9)
                . $letters[random_int(0, 25)];
        } while (self::where('text_code', $code)->exists());

        $this->text_code = $code;
        $this->qr_code = $code;
        $this->save();

        return $code;
    }

    public function qrCodeSvg(): string
    {
        $code = $this->qr_code ?? $this->ensureInvitationCode();

        return QrCode::size(200)->generate(route('invitations.verify', $code));
    }
}