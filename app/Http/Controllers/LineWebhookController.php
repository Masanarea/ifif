<?php

namespace App\Http\Controllers;

use App\CommonConstants;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LINE\Clients\MessagingApi\Model\ReplyMessageRequest;
use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Clients\MessagingApi\Model\UserProfileResponse;
use Illuminate\Support\Facades\Log;

use App\Models\LineInfo;
use App\Models\Manager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\Configuration;
use Illuminate\Support\Facades\Crypt;

class LineWebhookController extends Controller
{
    // メイン機能
    public function message(Request $request)
    {
        Log::debug("debug ログ!");
        $data = $request->all();
        $events = $data["events"];
        // Log::debug($events);

        // クエリ文字列から暗号化されたマネージャーIDを取得
        $encrypted_manager_id = $request->query("manager_id");

        // 暗号化されたマネージャーIDを復号化
        $manager_id = Crypt::decryptString($encrypted_manager_id);

        // マネージャーテーブルから該当のマネージャー情報を取得
        $manager = Manager::find($manager_id);

        // マネージャ情報の取得
        if ($manager) {
            $encryptedChannel_token = $manager->channel_token;
            $channel_token = Crypt::decryptString($encryptedChannel_token);
        } else {
            return "access error";
        }

        if (isset($events) && is_array($events)) {
            foreach ($events as $event) {
                if (isset($event["replyToken"])) {
                    $replyToken = $event["replyToken"];
                    Log::debug("ReplyToken: " . $replyToken);

                    $client = new \GuzzleHttp\Client();
                    $config = new Configuration();
                    $config->setAccessToken($channel_token);
                    $messagingApi = new MessagingApiApi(
                        client: $client,
                        config: $config
                    );
                    $userProfileResponse = $messagingApi->getProfile(
                        userId: $event["source"]["userId"]
                    );
                    Log::debug($userProfileResponse);

                    // ユーザーの LINE ID に基づいたデータを取得または作成(「アップサート」操作)
                    $lineId = $userProfileResponse->getUserId();
                    $lineInfo = LineInfo::where("line_id", $lineId)->first();

                    if ($lineInfo) {
                        // データが既に存在すれば更新
                        $lineInfo->update([
                            "displayName" => $userProfileResponse->getDisplayName(),
                            "language" => $userProfileResponse->getLanguage(),
                            "pictureUrl" => $userProfileResponse->getPictureUrl(),
                            "statusMessage" => $userProfileResponse->getStatusMessage(),
                        ]);
                    } else {
                        // データが存在しなければ新規作成
                        $lineInfo = LineInfo::create([
                            "line_id" => $lineId,
                            "displayName" => $userProfileResponse->getDisplayName(),
                            "language" => $userProfileResponse->getLanguage(),
                            "pictureUrl" => $userProfileResponse->getPictureUrl(),
                            "statusMessage" => $userProfileResponse->getStatusMessage(),
                        ]);
                    }

                    $userMessage = $event["message"]["text"];
                    $replyText = $this->handleUserMessage(
                        $userMessage,
                        $lineInfo
                    );

                    $message = new TextMessage([
                        "type" => "text",
                        "text" => $replyText,
                    ]);
                    $request = new ReplyMessageRequest([
                        "replyToken" => $replyToken,
                        "messages" => [$message],
                    ]);
                    Log::debug($request);

                    try {
                        $response = $messagingApi->replyMessage($request);
                        // Success
                    } catch (MessagingApiApi $e) {
                        // Failed
                        Log::error(
                            "Error Log: " .
                                $e->getCode() .
                                " " .
                                $e->getResponseBody()
                        );
                    }
                }
            }
        }
    }

    private function handleUserMessage($userMessage, $lineInfo)
    {
        // LINE トークンのセッティング処理
        if ($userMessage == "セッティング") {
            $managerInfo = Manager::where("id", $lineInfo->manager_id)
                ->where("del_flag", CommonConstants::DEL_FLG["OFF"])
                ->first();
            if ($managerInfo) {
                $managerInfo->channel_id = Crypt::encryptString("");
                $managerInfo->channel_secret = Crypt::encryptString("");
                $managerInfo->channel_token = Crypt::encryptString("");
                $managerInfo->save();
                return "LINE のアクセストークンのセッティングが完了しました。";
            }
        }

        switch ($lineInfo->sync_step_cd) {
            case 0: // 何もしていない状態 + メールアドレス入力待ち状態
                if ($userMessage == "同期開始") {
                    $lineInfo->sync_step_cd = 1;
                    $lineInfo->save();
                    return "メールアドレスを入力してください";
                }
                return "申し訳ありませんが、\n同期を開始するためには\n「同期開始」\nを入力してください。";

            case 1: //メールアドレス入力待ち状態
                $validator = Validator::make(
                    ["email" => $userMessage],
                    [
                        "email" => "required|email",
                    ]
                );

                if ($validator->fails()) {
                    return "メールアドレスの形式が間違っています。\n正しいメールアドレスを入力してください。";
                }

                $lineInfo->temp_email = $userMessage;
                $lineInfo->sync_step_cd = 2;
                $lineInfo->save();
                //メールアドレス登録完了状態

                return "続いて、パスワードを入力してください";

            case 2: //メールアドレス保存状態(※後はパスワードのみ)
                $manager = Manager::where(
                    "email",
                    $lineInfo->temp_email
                )->first();
                if ($manager && Hash::check($userMessage, $manager->password)) {
                    $lineInfo->manager_id = $manager->id;
                    $lineInfo->sync_step_cd = 3;
                    $lineInfo->save();
                    return "同期が完了しました";
                } else {
                    $lineInfo->sync_step_cd = 0;
                    $lineInfo->save();
                    return "該当するユーザーが見つかりませんでした。\n再度「同期開始」を入力してやり直してください。";
                }

            case 3: //同期完了状態
                return "同期が完了しました";
        }

        return "申し訳ありませんが、予期しないエラーが発生しました。(エラーコード: 1000)";
    }
}
