<?php

namespace App\Repository;

use Domain\Finance\Student\PaymentStatus;
use Illuminate\Database\Eloquent\Model;

class PaymentsReadModel extends Model
{
    protected $primaryKey = 'payment_id';

    protected $keyType = 'string';

    /**
     * @var string
     */
    protected $table = 'payments';

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function student()
    {
        return $this->hasOne(StudentReadModel::class, 'id', 'student_id');
    }

    public function statusLabel()
    {
        $labels = [
            PaymentStatus::STATUS_CREATED => 'принят',
            PaymentStatus::STATUS_RETURNED => 'возвращен',
            PaymentStatus::STATUS_CANCELLED_DUE_TO_MISTAKE => 'отменен',
        ];

        return $labels[$this->status];
    }

    public function statusBadge()
    {
        $labels = [
            PaymentStatus::STATUS_CREATED => 'primary',
            PaymentStatus::STATUS_RETURNED => 'danger',
            PaymentStatus::STATUS_CANCELLED_DUE_TO_MISTAKE => 'warning',
        ];

        return $labels[$this->status];
    }
}
