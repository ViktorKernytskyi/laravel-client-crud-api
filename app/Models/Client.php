<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
/** @var string[]
 *Why do we use fillable? This protects against bulk filling of unwanted fields by allowing only specific attributes to be changed.
 */
    protected $fillable = ['first_name', 'last_name', 'email', 'phone']; // An array of fields that are allowed to be filled in bulk.

    public function orders()
    {
        return $this->hasMany(Order::class); // Each customer can have many orders.
    }
}
