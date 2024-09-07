<?php

namespace App\Http;

class Response
{
    public const int HTTP_OK = 200;
    public const int HTTP_NOT_FOUND = 404;
    public const int HTTP_BAD_REQUEST = 400;
    public const int HTTP_SERVER_ERROR = 500;

    public const string CONTENT_TYPE_HTML = 'text/html';
    public const string CONTENT_TYPE_JSON = 'application/json';

    public function __construct(
        /** Response content (the HTML that we will send for example) */
        private string $content,
        /** Response status code */
        private int $statusCode = self::HTTP_OK,
        /** The type of data the client will receive. It's a mime type */
        private string $contentType = self::CONTENT_TYPE_HTML
    )
    {
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }

    public function setContentType(string $contentType): void
    {
        $this->contentType = $contentType;
    }

    public function __toString(): string
    {
        return $this->content;
    }
}
