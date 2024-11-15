<?php

class Token
{
    public static function generateToken(): string
    {
        try {
            $token = bin2hex(random_bytes(32));
            $_SESSION['token'] = $token;
            return $token;
        } catch (Exception $e) {
            error_log('Hiba a token generálásakor: ' . $e->getMessage());
            return 'Hiba történt a token generálásakor.';
        } catch (Error $e) {
            error_log('Rendszerhiba a token generálásakor: ' . $e->getMessage());
            return 'Rendszerhiba történt a token generálásakor.';
       }
    }
}