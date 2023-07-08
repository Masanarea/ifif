<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// モデルは単数系
class User extends Model
{
    // Flightモデルがflightsテーブルにレコードを格納し、AirTrafficControllerモデルはair_traffic_controllersテーブルにレコードを格納
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    // protected $table = 'users';

    /**
     * テーブルに関連付ける主キー
     *
     * @var string
     */
    // protected $primaryKey = 'flight_id';

    // タイムスタンプの保存に使用するカラム名をカスタマイズ
    const UPDATED_AT = "upd_timestamp";
}
