<?php

namespace App\Service\Convert\V1;

use App\Base\ServiceBase;

class ConvertService extends ServiceBase
{
    protected function handleLogic(): \App\Base\Response
    {
        // Данные
        $source_lang = $this->data['source_lang'];
        $text = $this->data['text'];
        $langs = [
            "fr",
            "pl",
            "tr",
            "sv",
            "bg",
            "da"
        ];

        // Gemini query
        $service = new GeminiService();
        $geminiResponse = $service->load([
            "text" => $text . "\n" . $this->prompt($source_lang)
        ])->handle()->php();
        $text = $geminiResponse['data']['text'];

        // Повторный Перевод
        $service = new TranslateService();
        foreach ($langs as $lang) {
            $result = $service->load([
                "text" => $text,
                "source_lang" => $source_lang,
                "target_lang" => $lang
            ])->handle()->php();
            if (!$result['status']) {
                return $this->response(false, "Translate error", [], [], 404);
            }
        }

        // Возвращение в исходный язык
        $final_result = $service->load([
            "text" => $result['data']['text'],
            "target_lang" => $source_lang,
            "source_lang" => "da"
        ])->handle()->php();
        if (!$final_result['status']) {
            return $this->response(false, "Translate error", [], [], 404);
        }

        // Reponse
        return $this->response(true, "wad", [
            "text" => $final_result['data']['text']
        ], [], 200);
    }

    protected function validateRules(): array
    {
        return [
            "source_lang" => "required|string|max:2",
            "text" => "required|string"
        ];
    }

    private function prompt($source_lang)
    {
        $ru = "Напиши более человечным языком, чтобы прошло через анти плагиат";
        $en = "Write in a more human language so that it goes through anti-plagiarism";
        $kk = "Плагиатқа қарсы өту үшін адам тілімен көбірек жазыңыз";

        if($source_lang == "kk"){
            return $kk;
        }
        if($source_lang == "en"){
            return $en;
        }
        if($source_lang == "ru"){
            return $ru;
        }
    }
}