<?php
namespace Picpay\Challenge\Security;

class External
{
    public static function sanitize(?array $data):?array
    {
        if(!is_null($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $data[$key] = self::sanitize($value);
                } else {
                    $data[$key] = filter_var($value, FILTER_SANITIZE_STRING);
                }
            }

            return $data;
        }

        return null;
    }
}