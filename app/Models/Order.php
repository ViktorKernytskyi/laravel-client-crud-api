<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
use HasFactory;

    protected $fillable = ['client_id', 'description', 'status'];

    public function client()
    {
        /** we use belongsTo in Order this indicates that each order is associated with one specific customer.
         * This will help identify who created a particular order.
         */
        return $this->belongsTo(Client::class); // Each order belongs to a specific customer.
    }
}
