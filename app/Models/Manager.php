<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// 微妙に違う
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    // タイムスタンプの保存に使用するカラム名をカスタマイズ
    const CREATED_AT = "ins_timestamp";
    const UPDATED_AT = "upd_timestamp";
}
