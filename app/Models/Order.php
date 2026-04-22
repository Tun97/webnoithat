<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'phone',
        'address',
        'address_line',
        'province_id',
        'province_name',
        'district_id',
        'district_name',
        'ward_code',
        'ward_name',
        'note',
        'total_amount',
        'payment_method',
        'payment_status',
        'paid_at',
        'momo_order_id',
        'momo_request_id',
        'momo_trans_id',
        'momo_pay_url',
        'momo_qr_code',
        'momo_response',
        'bank_transfer_receipt_path',
        'bank_transfer_receipt_original_name',
        'bank_transfer_receipt_uploaded_at',
        'order_status',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'momo_response' => 'array',
        'bank_transfer_receipt_uploaded_at' => 'datetime',
    ];

    public const STATUS_LABELS = [
        'pending' => 'Chờ xử lý',
        'shipping' => 'Đang giao',
        'completed' => 'Hoàn tất',
        'cancelled' => 'Đã hủy',
    ];

    public const PAYMENT_METHOD_LABELS = [
        'cod' => 'Thanh toán khi nhận hàng',
        'bank_transfer' => 'Chuyển khoản ngân hàng',
        'momo' => 'Ví MoMo',
    ];

    public const PAYMENT_STATUS_LABELS = [
        'pending' => 'Chờ thanh toán',
        'paid' => 'Đã thanh toán',
        'failed' => 'Thanh toán lỗi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class)->latest();
    }

    public function scopePending($query)
    {
        return $query->where('order_status', 'pending');
    }

    public function statusLabel(): string
    {
        return self::STATUS_LABELS[$this->order_status] ?? $this->order_status;
    }

    public function paymentMethodLabel(): string
    {
        return self::PAYMENT_METHOD_LABELS[$this->payment_method] ?? $this->payment_method;
    }

    public function paymentStatusLabel(): string
    {
        return self::PAYMENT_STATUS_LABELS[$this->payment_status] ?? $this->payment_status;
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }
}
