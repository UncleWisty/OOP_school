<?php

namespace App\Http;

class ResponseJson
{
    private string $header = 'Content-Type:application/json';
    private int $statusCode;
    private string $body;

    public function __construct(int $statusCode, array $data)
    {
        $this->statusCode = $statusCode;
        $this->body = json_encode($data);
    }

    public function send()
    {
        http_response_code($this->statusCode);

        // For 204 No Content, do not send a body or content-type header
        if ($this->statusCode === 204) {
            return;
        }

        header("$this->header");
        echo $this->body;
    }
}
