<?php

namespace App\Service\Translate;

use App\Base\ServiceBase;

use Illuminate\Support\Facades\Http;
use Google\Cloud\Translate\V2\TranslateClient;

class TranslateService extends ServiceBase
{
    protected function handleLogic(): \App\Base\Response
    {
        $text = $this->data['text'];
        $source_lang = $this->data['source_lang'];
        $target_lang = $this->data['target_lang'];

        $translate = new TranslateClient([
            'key' => env("GOOGLE_TRANSLATE_API_KEY"),
        ]);
        $translation = $translate->translate($text, [
            "source" => $source_lang,
            'target' => $target_lang,
        ]);
        return $this->response(true, "Translate text", [], []);
    }

    protected function validateRules(): array
    {
        return [
            "text" => "required|string",
            "source_lang" => "required|string|max:2",
            "target_lang" => "required|string|max:2"
        ];
    }
}