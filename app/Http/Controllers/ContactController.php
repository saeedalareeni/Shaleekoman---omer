<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{


    public function index()
    {
        $contact = Contact::first();
        return view('backend.pages.contact_us.index', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'address_ar' => 'required',
            'address_en' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'whatsapp' => 'required',
        ]);

        $contact = Contact::find($id);

        $data['address_ar'] = $request->address_ar;
        $data['address_en'] = $request->address_en;

        $data['map'] = $request->map;
        $data['map_footer'] = $request->map_footer;

        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['whatsapp'] = $request->whatsapp;

        $data['body_ar'] = $request->body_ar;
        $data['body_en'] = $request->body_en;

        $data['facebook_url'] = $request->facebook_url;
        $data['instagram_url'] = $request->instagram_url;
        $data['twitter_url'] = $request->twitter_url;
        $data['youtube_url'] = $request->youtube_url;
        $data['linkedin_url'] = $request->linkedin_url;

        $contact->update($data);

        toast('تم التعديل بنجاح','success');
        return redirect()->back();
    }

}
