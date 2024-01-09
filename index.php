<?php

require './vendor/autoload.php';

use Aws\Sdk;

$sharedConfig = [
    'region' => 'us-west-2',
];

$sdk = new Sdk($sharedConfig);

$bedrockRuntime = $sdk->createBedrockRuntime();

$body = [
    'inputText' => 'Who are you?',
    'textGenerationConfig' => [
        'temperature' => 0,
        'maxTokenCount' => 512,
    ],
];

$response = $bedrockRuntime->invokeModel([
    'modelId' => 'amazon.titan-text-express-v1',
    'contentType' => 'application/json',
    'body' => json_encode($body),
]);

$result = json_decode($response['body']);

print_r($result);
