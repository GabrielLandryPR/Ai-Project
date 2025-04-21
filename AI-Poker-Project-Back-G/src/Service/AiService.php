<?php



namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class AiService
{
    private HttpClientInterface $httpClient;
    private string $apiUrl;
    private string $apiKey;

    public function __construct(HttpClientInterface $httpClient, string $geminiApiUrl, string $geminiApiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiUrl = $geminiApiUrl;
        $this->apiKey = $geminiApiKey;
    }

    public function generateResponse(string $prompt): array
    {
        try {
            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 1,
                    'topP' => 1,
                    'topK' => 40,
                    'maxOutputTokens' => 65535,
                    'responseMimeType' => "text/plain"
                ],
                'safetySettings' => [
                    [
                        'category' => "HARM_CATEGORY_HATE_SPEECH",
                        'threshold' => "BLOCK_NONE"
                    ],
                ]
            ];


            $url = $this->apiUrl . '?key=' . $this->apiKey;


            $response = $this->httpClient->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $payload,
                'timeout' => 60,
                'verify_peer' => true,
                'verify_host' => true,
                'extra' => [
                    'ssl' => [
                        'peer_name' => 'generativelanguage.googleapis.com',
                        'ciphers' => 'DEFAULT:!DH' // Contournement bug OpenSSL
                    ]
                ]
            ]);

            $statusCode = $response->getStatusCode();
            $data = $response->toArray(false);

            if ($statusCode >= 200 && $statusCode < 300) {
                $result = [
                    'success' => true,
                    'message' => $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Pas de réponse',
                    'data' => $data
                ];

                if (isset($data['candidates'][0]['reasoningSteps'])) {
                    $result['reasoning'] = $data['candidates'][0]['reasoningSteps'];
                }

                return $result;
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage(),
                'data' => ['exception' => get_class($e)]
            ];
        }
        return [
            'success' => false,
            'message' => 'Erreur inconnue',
            'data' => []
        ];
    }
}
