<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Manager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class ManagerController extends Controller
{
    /**
     * ログイン処理
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $user_info = $request->only("email", "password"); // @scrf を除外

        // attemptメソッドで、データベースにある該当ユーザーを探す。パスワードは生のままでよく、ハッシュ化させなくて大丈夫
        // 暗号化方式: bcrypt
        if (Auth::guard("manager")->attempt($user_info)) {
            // true or false
            // ログイン成功
            $request->session()->regenerate(); // セッション固定攻撃（Session Fixation Attack）対策
            return redirect()->route("manager.top");
        } else {
            // ログイン失敗
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    "login_check" => "該当するユーザーが存在しません。",
                ]);
        }
    }

    /**
     * トップページ
     */
    public function top()
    {
        $channel_id = Crypt::decryptString(
            Auth::guard("manager")->user()->channel_id
        );
        $channel_secret = Crypt::decryptString(
            Auth::guard("manager")->user()->channel_secret
        );
        $channel_token = Crypt::decryptString(
            Auth::guard("manager")->user()->channel_token
        );
        return view("manager_top", [
            "decryptedChannel_id" => $channel_id,
            "decryptedChannel_secret" => $channel_secret,
            "decryptedChannel_token" => $channel_token,
        ]);
    }

    /**
     * 新規登録フォーム
     */
    public function showRegisterForm()
    {
        return view("manager.auth.register");
    }
    /**
     * ログインフォーム
     */
    public function showLoginForm()
    {
        return view("manager.auth.login");
    }

    /**
     * 新規登録処理
     */
    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $manager = new Manager();

            // 登録するデータ一覧
            $manager->email = $request->email;
            $manager->password = Hash::make($request->password); // パスワードをハッシュ化
            $manager->ins_action = "登録画面からの登録";
            $manager->upd_action = "登録画面からの登録";
            $manager->email = $request->email;
            $manager->email = $request->email;
            $manager->email = $request->email;
            $manager->email = $request->email;

            DB::commit();
            $manager->save();

            return redirect()->route("manager.login.page");
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            Log::error(DB::getQueryLog());
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(["error" => "登録に失敗しました。"]);
        }
    }
}
