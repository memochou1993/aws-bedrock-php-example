<?php

require './vendor/autoload.php';

use Aws\Sdk;

$sharedConfig = [
    'region' => 'us-west-2',
];

$sdk = new Sdk($sharedConfig);

$bedrockRuntime = $sdk->createBedrockRuntime();

function invokeTitan($bedrockRuntime, $text) {
    $body = [
        'inputText' => "User: $text\nAssistant:",
        'textGenerationConfig' => [
            'maxTokenCount' => 512,
            'temperature' => 0,
            'stopSequences' => ['User:'],
        ],
    ];

    $response = $bedrockRuntime->invokeModel([
        'modelId' => 'amazon.titan-text-express-v1',
        'contentType' => 'application/json',
        'body' => json_encode($body),
    ]);

    $result = json_decode($response['body']);

    return $result;
}

function invokeClaude($bedrockRuntime, $text) {
    $body = [
        'prompt' => "\n\nHuman:$text\n\nAssistant:",
        'max_tokens_to_sample' => 512,
        'temperature' => 0,
        'stop_sequences' => ["\n\nHuman:"],
    ];

    $response = $bedrockRuntime->invokeModel([
        'modelId' => 'anthropic.claude-v2:1',
        'contentType' => 'application/json',
        'body' => json_encode($body),
    ]);

    $result = json_decode($response['body']);

    return $result;
}

print_r(invokeTitan($bedrockRuntime, '你好嗎？'));
print_r(invokeClaude($bedrockRuntime, '你好嗎？'));
