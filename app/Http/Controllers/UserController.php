<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\User;
use Cloudder;
use Carbon\Carbon;

class UserController extends Controller{
    protected $authUser;

    public function __construct(){
        $this->authUser = Auth::user();
    }
    /**
     * Display a all registered users
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
      $users = User::paginate(10);
      return view('students', compact('users'));
    }

    /**
     * get a student by his matric no
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserByMatricNumber(){
      return view('yearbook');
    }


    /**
     * Display user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function userProfile(){
        return view('student-profile');
    }

    /**
     * Show the form for editing the specified user profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(){
        return view('student.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        $niceNames = array(
            'firstname' => 'First Name',
            'lastname'  => 'Last Name',
            'email'     => 'Email',
            'facebook'  => 'Facebook',
            'website'  => 'Website',
            'twitter'  => 'Twitter',
            'sex'      => 'Sex',
            'google'   => 'Google Plus',
            'instagram'  => 'Instagram',
            'linkedin'  => 'Linkedin',
            'dateofbirth'=> 'Date Of Birth',
            'avatar' => 'Avatar'
        );

        $this->validate($request, [
            'firstname' => 'required',
            'lastname'  => 'required',
            'sex'       => 'required',
            'email'     => 'required|email',
            'dateofbirth'=> 'required|Date'
        ], [], $niceNames);

        $user = User::findOrFail($this->authUser->user_id);

        if($request->hasFile('avatar')){
            $this->validate($request, [
                'avatar' => 'mimes:jpg,jpeg,bmp,png|between:1,7000',
            ], [], $niceNames);

            $file = $request->file('avatar')->getRealPath();
            Cloudder::upload($file, null);
            list($width, $height) = getimagesize($file);
            $user->profile->imgPath =
                Cloudder::show(Cloudder::getPublicId(), ["width" => 1024, "height" => 921]);
        }

        if($request->has('website')){
            $this->validate($request, [
                'website'  => 'required|url'
            ], [], $niceNames);
            $user->profile->website = $request->input('website');
        }

       if($request->has('facebook')){
            $this->validate($request, [
                'facebook'  => 'required|url'
            ], [], $niceNames);
           $user->profile->facebook = $request->input('facebook');
        }

        if($request->has('twitter')){
            $this->validate($request, [
                'twitter'  => 'required|url'
            ], [], $niceNames);
            $user->profile->twitter = $request->input('twitter');
        }

        if($request->has('google')){
            $this->validate($request, [
                'google'  => 'required|url'
            ], [], $niceNames);
            $user->profile->google = $request->input('google');
        }

        if($request->has('linkedin')){
            $this->validate($request, [
                'linkedin'  => 'required|url'
            ], [], $niceNames);
            $user->profile->linkedin = $request->input('linkedin');
        }

        if($request->has('instagram')){
            $this->validate($request, [
                'instagram'  => 'required|url'
            ], [], $niceNames);
            $user->profile->instagram = $request->input('instagram');
        }

        $user->first_name = $request->input('firstname');
        $user->last_name = $request->input('lastname');
        $user->email = $request->input('email');
        $user->phone_no = $request->input('phone');
        $user->sex = $request->input('sex');
        $user->profile->date_of_birth = Carbon::parse($request->input('dateofbirth'))->format('Y-m-d');
        $user->profile->address = $request->input('address');
        $user->profile->country = $request->input('country');
        $user->profile->description = $request->input('bio');
        $user->profile->occupation = $request->input('occupation');
        $user->push();

        return redirect()->back()->with('status', 'Profile Updated successfully');
    }
}
