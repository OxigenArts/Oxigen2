<?php

namespace Core\Exceptions;

use Core\Exceptions\IException;
use \Exception;

abstract class NotFoundContentTypeException extends Exception implements IException
{
    protected $message = 'Content type not found or not registered on oxigen';     // Exception message
    private   $string;                            // Unknown
    protected $code    = 501;                       // User-defined exception code
    protected $file;                              // Source filename of exception
    protected $line;                              // Source line of exception
    private   $trace;                             // Unknown

    public function __construct($message = null, $code = 0)
    {
        if (!$message) {
            throw new $this('Content Type not found in:  '. get_class($this));
        }
        parent::__construct($message, $code);
    }
    
    public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
                                . "{$this->getTraceAsString()}";
    }
}


?>