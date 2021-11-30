<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
class ContactController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all();
        return $contacts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'message' => 'required',
        ]);
        $contact = new Contact;
        $contact->email = $request->email;
        $contact->message = $request->message;

        $contact->save();
        return $contact;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return $contact;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) 
    {
        $contact = Contact::findOrFail($id);
        return $contact;

    }
    
     /**
     * Create a new controller to send & receive email.
     *
     * @return void
     */
    public function mail(Request $request)
    {
        $data = [  
            'email' => $request->email,
            'content' => $request->message,
        ];

        Mail::send('contact_email', $data, function ($message) use ($data) {
            $message->to($data['email'])->subject($data['content']);
            $message->from('scm.kyimyatnoesoe@gmail.com');
        });

        return back()->with(['message' => 'Email successfully sent!']);
    }

}
