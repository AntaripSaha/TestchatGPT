<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ChatGptController extends Controller
{
    public function chat(Request $request)
    {
     
      // API 
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.env('CHAT_GPT_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user',
                 'content' => $request->input('message')
                ],
            ],
            'temperature'=> 0.7,
            'max_tokens' => 30,
            'stop' => ["10."],
        ])->throw()->json();

        // It will save the conversation to the database according to user
        $conversation = new Conversation();
        $conversation->user_message = $request->input('message');
        $conversation->user_id = Auth::id();
        $conversation->chatgpt_message = $response['choices'][0]['message']['content'];
        $conversation->save();

        return response()->json($response);
    }
}
