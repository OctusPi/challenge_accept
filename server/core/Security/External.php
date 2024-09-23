<?php
namespace Picpay\Challenge\core\Security;

class External
{
    public static function sanitize(?array $data): ?array
    {
        if (!is_null($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = is_array($value)
                    ? self::sanitize($value)
                    : self::disinfectant($value) ;
            }

            return $data;
        }

        return null;
    }

    public static function disinfectant(?string $data): ?string
    {
        $sanitized_input = strip_tags($data);
        $sanitized_input = htmlspecialchars($sanitized_input, ENT_QUOTES, 'UTF-8');
        $sanitized_input = filter_var($sanitized_input, FILTER_SANITIZE_URL);

        return $sanitized_input;
    }
}