<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	use HasFactory;
	protected $fillable = [
		'user_id',
		'capture_id',
		'payment_id',
		'payer_id',
		'amount',
		'currency',
		'refund_url',
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
