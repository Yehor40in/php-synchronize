<?php

    final class ConcreteJSONSyncManager
    {
        static $sync_channel;
        static $verify_channel;

        static function initialize()
        {
            self::$sync_channel = curl_init( 'http://test2.local/sync/sync' );
            self::$verify_channel = curl_init( 'http://test2.local/sync/verify' );
        }

        static function synchronize( $data, $token )
        {
            $payload = json_encode($data);

            curl_setopt(self::$sync_channel, CURLOPT_POSTFIELDS, $payload );
            curl_setopt(self::$sync_channel, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload),
                'Token:' . $token
            ]);
            curl_setopt(self::$sync_channel, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec( self::$sync_channel );
        }


        static function verify_token( $data )
        {
            curl_setopt(self::$verify_channel, CURLOPT_POSTFIELDS, json_encode($data) );
            curl_setopt(self::$verify_channel, CURLOPT_HTTPHEADER, [ 'Content-Type:application/json' ]);
            curl_setopt(self::$verify_channel, CURLOPT_RETURNTRANSFER, true);

            $result = json_decode( curl_exec(self::$verify_channel), true);

            if ( isset($result['success']) )
            {
                return true;
            }
            return false;
        }
    }

    ConcreteJSONSyncManager::initialize();