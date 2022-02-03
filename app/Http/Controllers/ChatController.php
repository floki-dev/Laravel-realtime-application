<?php

namespace App\Http\Controllers;

use App\Events\GreetingSent;
use App\Events\MessageSent;
use App\Http\Requests\MessageRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showChat(): \Illuminate\Contracts\Support\Renderable
    {
        return view('chat.show');
    }

    public function messageReceived(MessageRequest $request): \Illuminate\Http\JsonResponse
    {
        broadcast(new MessageSent($request->user(), $request->message));

        return response()->json('Message broadcast');
    }

    /**
     * @param Request $request
     * @param User $user
     * @return string
     */
    public function greetReceived(Request $request, User $user): string
    {
        broadcast(new GreetingSent($user, "{$request->user()->name} greeted you"));
        broadcast(new GreetingSent($request->user(), "You greeted {$user->name}"));

        return "Greeting {$user->name} from {$request->user()->name}";
    }
}
