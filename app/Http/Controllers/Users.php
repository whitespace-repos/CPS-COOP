<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Twilio\Rest\Client;

use Shop;
use Inertia;

class Users extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //
        // $sid = "AC7f403e2092e0071cd5a638ace7bc555c"; // Your Account SID from www.twilio.com/console
        // $token = "f3b9da505803c9baecd7cf73ee0db227"; // Your Auth Token from www.twilio.com/console

        $sid = 'ACeef7e31176eac5903d6f5320cda0de96';
        $token = 'ebbd02275c2764ba7c5acd4eab5c84ab';
        $client = new Client($sid, $token);
        // print_r($client);
        // A Twilio number you own with Voice capabilities
        $twilio_number = "+17547993758";

        // Where to make a voice call (your cell phone?)
        $to_number = "+917018643356";

        $client = new Client($sid, $token);

        $client->account->calls->create(
            $to_number,
            $twilio_number,
            array(
                "url" => "http://demo.twilio.com/docs/voice.xml"
            )
        );
        dd($message->sid);

        //
        $users = User::with('roles','shop')->get();
        return Inertia::render('Users/Users', [ "users" => $users ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $shops = Shop::all();
        return Inertia::render('Users/Create', [ "shops" => $shops ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'shop_id' => $request->shop_id
        ]);

        event(new Registered($user));
        //
        $user->assignRole('Employee');
        //
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $shops = Shop::all();
        $user = User::find($id);
        return view('pages.users.edit',compact('user','shops'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::find($id);
        $user->update($request->all());
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
