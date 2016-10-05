<?php

namespace App\Http\Controllers;

use App\Bot;
use Illuminate\Http\Request;

use App\Http\Requests;

class BotController extends Controller
{
    public function handle()
    {
        $bot = new Bot('268503234:AAFeyiEA04MRoGBIL-eEI8FVNGMdcZJTr7U');
        $input_data = json_decode(file_get_contents('php://input'), true);
        mb_internal_encoding("UTF-8");

        define('BOT_DEBUG', false);

        $input_data = json_decode(file_get_contents('php://input'), true);
        if (BOT_DEBUG) file_put_contents(public_path() . '/input_data.txt', var_export($input_data, true));

        if (isset($input_data['message'])) {
            $Message = $input_data['message'];
            $User = $Message['from'];
            if (isset($Message['text'])) $MsgText = $Message['text'];
        }

        $text = "Hello";
        $bot->executeMethod('sendMessage', http_build_query(array('chat_id' => $User['id'], 'text' => $text, 'parse_mode' => 'HTML')));
    }
}
