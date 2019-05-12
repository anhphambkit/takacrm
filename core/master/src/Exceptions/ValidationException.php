<?php
namespace Core\Master\Exceptions;

use Illuminate\Validation\ValidationException as Exception;
use Core\Master\Requests\FormatMessageTrait;

class ValidationException extends Exception {
	use FormatMessageTrait;
	
    /**
     * Get all of the validation error messages.
     * @author TrinhLe
     * @return array
     */
    public function errors()
    {
        return $this->customErrors($this->validator->errors()->messages());
    }
    
}