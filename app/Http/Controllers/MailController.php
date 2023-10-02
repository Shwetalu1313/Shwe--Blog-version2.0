<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function Laravel\Prompts\alert;

class MailController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $message = $request->input('message');

        $mail = new MyMail($name, $email, $message);
        if ($this->isonline()){
            return redirect()->back()->withErrors('hi', 'bad network or no connection');
        }
        else{
            $mail->send();

            return redirect()->back()->with('successemail', 'Email sent successfully!');
        }


    }


    // Internet connection checker
    private function isonline($site = "https://www.youtube.com/watch?v=icXHq5sEfCg&list=RDQ9rEE-6Tafo&index=3"): bool
    {
        if (@fopen($site, "r")) {
            return true;
        } else {
            return false;
        }
    }
}
