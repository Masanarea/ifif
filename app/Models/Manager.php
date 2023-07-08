<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    // タイムスタンプの保存に使用するカラム名をカスタマイズ
    const UPDATED_AT = "upd_timestamp";
}
