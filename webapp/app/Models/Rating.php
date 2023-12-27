<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function orderItem(){
        return $this->belongsTo(OrderItem::class);
    }
    public function booking()
    {
        return $this->belongsTo(Booking::class);

}
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getLinks(): array
    {
        $baseUri = '/api/ratings/' . $this->id;
        return [
            'self' => [
                'href' => $baseUri,
                'method' => 'GET',
                'type' => 'application/json',
                'description' => 'Get ratings details',
            ],
            'update' => [
                'href' => $baseUri . '/update',
                'method' => 'PUT',
                'type' => 'application/json',
                'description' => 'Update ratings details',
            ],
            'delete' => [
                'href' => $baseUri . '/delete',
                'method' => 'DELETE',
                'type' => 'application/json',
                'description' => 'Delete ratings',
            ],
        ];
    }
}
