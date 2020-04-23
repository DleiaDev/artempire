<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Contact;
use App\User;

use App\Events\MessagesSeenEvent;
use App\Events\NewMessageEvent;
use App\Events\MessageReceivedEvent;
use App\Events\MessagesReceivedEvent;

class ChatController extends Controller
{

    // Get contact by ID
    public function getContact($id)
    {
        // Get latest message
        $message = Message::where('from', $id)->orderBy('created_at', 'desc')->first();

        // Set necessary properties
        $user = User::find($id);
        $user->lastMessage = $message;
        $user->unread = 1;
        $user->scrolls = 0;

        // Return user
        return $user;
    }

    // Get all contacts
    public function getContacts()
    {
        $user = auth()->user();

        // Get contacts
        $contactIDs = array_map('intval', explode(',', $user->contact->contacts));
        $contacts = User::find($contactIDs);

        // Receive all messages
        foreach ($contacts as $contact) {
          Message::where('to', auth()->user()->id)
            ->where('from', $contact->id)
            ->where('received', 0)
            ->update(['received' => 1]);
        }

        // Unread messages count per contact
        $unreadPerContact = Message::selectRaw('`from` as sender_id, count(`from`) as messages_count')
        ->where('to', auth()->user()->id)
        ->where('read', false)
        ->groupBy('from')
        ->get();

        // Add 'unread', 'lastMessage', 'scrolls' and 'status' properties to each contact
        $contacts = collect($contacts)->map(function($contact) use ($unreadPerContact) {
          $contact->scrolls = 0;
          $contact->online = false;

          $unreadContact = $unreadPerContact->where('sender_id', $contact->id)->first();
          $contact->unread = $unreadContact ? $unreadContact->messages_count : 0;

          $contact->lastMessage = Message::select('*')
          ->where(function($q) use ($contact) {
            $q->where('from', auth()->user()->id)->where('to', $contact->id);
          })
          ->orWhere(function($q) use ($contact) {
            $q->where('from', $contact->id)->where('to', auth()->user()->id);
          })
          ->orderBy('created_at', 'desc')
          ->first();

          return $contact;
        });

        // Convert back to array
        $contacts = $contacts->toArray();

        // Sort contacts based on last message
        usort($contacts, function($a, $b) {
          return strtotime( ((object)$b)->lastMessage->created_at) - strtotime( ((object)$a)->lastMessage->created_at);
        });

        return $contacts;
    }

    public function seeMessages(Request $request)
    {
        Message::where('from', $request->contact_id)->where('to', auth()->user()->id)->update(['read' => true]);
        broadcast(new MessagesSeenEvent($request->currentUser_id, $request->contact_id));
    }

    public function getMessages(Request $request, $contact_id)
    {
        $currentUser = auth()->user();
        $scrolls = intval($request->query('scrolls'));

        $messages = Message::where(function($query) use ($contact_id, $currentUser) {
          $query->where('from', $currentUser->id)->where('to', $contact_id);
        })->orWhere(function($query) use ($contact_id, $currentUser) {
          $query->where('from', $contact_id)->where('to', $currentUser->id);
        })
        ->orderBy('created_at', 'desc')
        ->skip(50 * $scrolls)
        ->take(50)
        ->get();

        $messages = $messages->toArray();

        // Sort messages based on created_at
        usort($messages, function($a, $b) {
          return strtotime($a['created_at']) - strtotime($b['created_at']);
        });

        return $messages;
    }

    public function sendMessage(Request $request)
    {
        $user = auth()->user();

        $message = Message::create([
          'from' => $user->id,
          'to' => $request->contact_id,
          'text' => $request->message,
          'read' => false,
          'received' => false,
          'sent' => true
        ]);

        Message::where('to', $user->id)
          ->where('from', $request->contact_id)
          ->update(['read' => 1]);

        broadcast(new NewMessageEvent($message));

        // Add each other as contacts if they aren't already
        if (strpos($user->contact->contacts, strval($request->contact_id)) === false) {

          $contactRowUser = Contact::find($user->id);
          if ($contactRowUser->contacts) $contactRowUser->contacts .= ','.$request->contact_id;
          else $contactRowUser->contacts = ''.$request->contact_id;
          $contactRowUser->save();

          $contactRowContact = Contact::find($request->contact_id);
          if ($contactRowContact->contacts) $contactRowContact->contacts .= ','.$user->id;
          else $contactRowContact->contacts = ''.$user->id;
          $contactRowContact->save();

        }

        return $message;
    }

    public function receiveMessage(Request $request)
    {
      Message::where('from', $request->contactWhoSent)
        ->where('to', auth()->user()->id)
        ->update(['received' => true]);
      broadcast(new MessageReceivedEvent(
        $request->contactWhoSent,
        $request->message_id
      ));
    }
}
