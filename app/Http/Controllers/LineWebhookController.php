<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LINE\Clients\MessagingApi\Model\ReplyMessageRequest;
use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Clients\MessagingApi\Model\UserProfileResponse;
use Illuminate\Support\Facades\Log;

class LineWebhookController extends Controller
{
    public function message(Request $request)
    {
        Log::debug("debug ログ!");
        $data = $request->all();
        $events = $data["events"];
        Log::debug($events);
        // Log::debug( $data);
        // var_dump($events);
        // Log::debug("services.line.message.channel_token:  ");
        // Log::debug(config("services.line.message.channel_token"));

        if (isset($events) && is_array($events)) {
            foreach ($events as $event) {
                if (isset($event["replyToken"])) {
                    $replyToken = $event["replyToken"];
                    Log::debug("ReplyToken: " . $replyToken);

                    $client = new \GuzzleHttp\Client();
                    $config = new \LINE\Clients\MessagingApi\Configuration();
                    // ZQ20usEaSYqIBOb+9Ckzgz590dZDsNR2DaHJhidaj4xYwN+Dn55zPHEhMPnuZOPSWCdaueD21zl9VTgg1sdcxvzsGSLLD+u8lFRtQXwXcvLqB2dVm3d70iL8DUJAgMNLpszgwjPeRPTxN8V8+ZV6LAdB04t89/1O/w1cDnyilFU=
                    $config->setAccessToken(
                        config("services.line.message.channel_token")
                    );
                    $messagingApi = new \LINE\Clients\MessagingApi\Api\MessagingApiApi(
                        client: $client,
                        config: $config
                    );
                    // $UserProfileResponse = new UserProfileResponse();
                    $UserProfileResponse = $messagingApi->getProfile(
                        userId: $event["source"]["userId"]
                    );
                    // $UserProfileResponse
                    Log::debug($UserProfileResponse);
                    // Log::debug($UserProfileResponse->getPictureUrl());
                    // Log::debug($UserProfileResponse->getModelName());
                    // Log::debug($UserProfileResponse->getLanguage());
                    // Log::debug($UserProfileResponse->getDisplayName());
                    // Log::debug($UserProfileResponse->getStatusMessage());
                    // Log::debug($UserProfileResponse->getUserId());
                    // Log::debug($UserProfileResponse->setStatusMessage('this message is test from VScode!'));
                    // $UserProfileResponse->setStatusMessage('this message is test from VScode!');
                    // $UserProfileResponse = $messagingApi->getProfile(
                    //     userId: $event['source']['userId']
                    // );

                    // ユーザからのメッセージをチェック
                    $userMessage = $event["message"]["text"];
                    $replyText =
                        "申し訳ありませんが、\n該当ワード以外を打ち込まないでください。";

                    if ($userMessage == "診断開始") {
                        $replyText =
                            "診断開始\nQ1:あなたの現在のストレス度合いは以下のどれに当てはまりますか\n\n・悪い\n・普通\n・良い";
                    } elseif ($userMessage == "悪い") {
                        $replyText =
                            "調子が悪いのですね。お大事になさってください。";
                    } elseif ($userMessage == "普通") {
                        $replyText = "普通であれば問題ありません。";
                    } elseif ($userMessage == "良い") {
                        $replyText =
                            "調子がいいのであればよかったです。キープしていきましょう。";
                    }

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
                    } catch (\LINE\Clients\MessagingApi\Api\MessagingApiApi $e) {
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
}
