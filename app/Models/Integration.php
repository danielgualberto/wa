<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integration extends Model
{
    use HasFactory;
    // protected $guarded = ['id'];
    
    // Nome da tabela
    protected $table = 'integrations';
    protected $fillable = [
        'user_id', 'user_sender', 'manage_integration_id', 'token', 'data'
    ];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    // public function integrations(){
    //     return $this->hasMany(ManageIntegration::class);
    // }
}
