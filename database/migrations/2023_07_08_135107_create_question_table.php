<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable("questions")) {
            Schema::create("questions", function (Blueprint $table) {
                $table->increments("id");
                $table->timestamp("ins_timestamp")->useCurrent();
                $table->integer("ins_user_id")->default(0);
                $table->string("ins_action")->nullable();
                $table->timestamp("upd_timestamp")->nullable();
                $table->integer("upd_user_id")->default(0);
                $table->string("upd_action")->nullable();
                $table->timestamp("del_timestamp")->nullable();
                $table->integer("del_user_id")->default(0);
                $table->string("del_action")->nullable();
                $table->boolean("del_flag")->default(0);
                $table->text("question");
                $table->string("manager_id"); // 質問のテキスト
                $table->string("value"); // 質問のテキスト
                $table->integer("sort_num"); // 質問の順序
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("questions");
    }
};
