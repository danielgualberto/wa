<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageIntegration extends Model
{
    use HasFactory;
    // protected $guarded = ['id'];
    
    // Nome da tabela
    protected $table = 'manage_integrations';
    protected $fillable = [
        'user_id', 'user_level', 'data'
    ];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
