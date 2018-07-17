<?php
namespace BobFreelancer\Http;

/**
 * Very naive implementation but the intention should be clear.
 */
class Response
{

    /**
     * @var int
     */
    private $status_code;

    /**
     * @var string
     */
    private $body;

    private $content_type;

    /**
     * @param int $status_code
     * @param string $body
     */
    public function __construct(int $status_code=200, string $body='', $content_type='text/html')
    {
        $this->status_code = $status_code;
        $this->body = $body;
        $this->content_type = $content_type;
    }

    public function send()
    {
        header(http_response_code($this->status_code));
        header('Content-Type: '.$this->content_type);
        echo $this->body;
    }
}