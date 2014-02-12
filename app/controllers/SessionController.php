<?php

class SessionController extends BaseController {

    public function login()
    {
        if (Input::server('REQUEST_METHOD') == 'POST')
        {
            // TODO: Validataion
            if (Auth::attempt(Input::only('email', 'password')))
            {
                return Redirect::intended('/');
            }
            return Redirect::back()->withInput();
        }
        return View::make('settings.login');
    }
    
    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');
    }
}
