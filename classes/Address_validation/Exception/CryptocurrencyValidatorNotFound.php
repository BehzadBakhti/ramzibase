<?php



class CryptoValidatorNotFound extends Exception
{
    public function __construct($iso)
    {
        parent::__construct(sprintf('Cryptocurrency validator for %s not found', $iso));
    }
}