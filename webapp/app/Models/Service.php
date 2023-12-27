<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function booking()
    {
        return $this->hasMany(Booking::class, 'service_id');
    }

    public function getLinks(): array
    {
    $baseUri = '/api/services/' . $this->id;
    return [
        'self' => [
            'href' => $baseUri,
            'method' => 'GET',
            'type' => 'application/json',
            'description' => 'Get service details',
        ],
        'update' => [
            'href' => $baseUri . '/update',
            'method' => 'PUT',
            'type' => 'application/json',
            'description' => 'Update service details',
        ],
        'delete' => [
            'href' => $baseUri . '/delete',
            'method' => 'DELETE',
            'type' => 'application/json',
            'description' => 'Delete service',
        ],
    ];
}
}
