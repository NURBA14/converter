<?php

namespace App\Service\Convert\V1;

use App\Base\ServiceBase;
use Illuminate\Support\Facades\Http;

class GeminiService extends ServiceBase
{
    protected function handleLogic(): \App\Base\Response
    {
        $apiToken = env("GEMINI_KEY");
        $text = $this->data['text'];

        $response = Http::withHeaders([
            "Content-Type" => "application/json"
        ])->asJson()
            ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=" . $apiToken, [
                'contents' => [
                    "parts" => [
                        "text" => $text
                    ]
                ],
            ]);

        if(!$response->successful()){
            return $this->response(false, "Error", [], [], 404);
        }

        $correctResponse = $response->json();
        return $this->response(true, "Success", [
            "text" => $correctResponse['candidates'][0]['content']['parts'][0]['text']
        ], [], 200);
    }

    protected function validateRules(): array
    {
        return [
            "text" => "required|string"
        ];
    }
}