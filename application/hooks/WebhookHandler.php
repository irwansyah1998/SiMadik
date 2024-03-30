<?php

class WebhookHandler
{
    public function handleWebhook()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        file_put_contents('logwebhook.txt', '[' . date('Y-m-d H:i:s') . "]\n" . json_encode($data) . "\n\n", FILE_APPEND);

        $message = $data['message'] ?? null;
        $from = $data['from'] ?? null;
        $isGroup = $data['isGroup'] ?? null;
        $isMe = $data['isMe'] ?? null;

        switch ($message) {
            case "ping":
                $responseData = [
                    'message_type' => 'text',
                    'message' => [
                        'message' => 'pong'
                    ]
                ];
                break;
            case "media":
                $responseData = [
                    'message_type' => 'media',
                    'message' => [
                        "media_type" => "image",
                        "url" => "https://i.ibb.co/QmPKL4Q/sad.jpg",
                        "caption" => "This is caption"
                    ]
                ];
                break;
            default:
                // if message is not match
                $responseData = false;
                break;
        }

        $response = [
            'status' => 'success',
            'data' => $responseData
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
