<?php


class Error extends Exception
{
    private $customMessage;

    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->customMessage = $message." on line ".$this->line." in ".$this->file." :".$this->message;
    }

    /**
     * @return mixed
     */
    public function getCustomMessage()
    {
        return $this->customMessage;
    }

}