<?php
Class User {
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedin;


    public function __construct($user = null){
        $this->_db = DB::getInstance();

        $this->_sessionName =Config::get('session/se ssion_name');
        $this->_cookieName =Config::get('remember/cookie_name');
        if(!$user){
            if(Session::exists($this->_sessionName)){
                $user = Session::get($this->_sessionName);
                if($this->find($user)){
                    $this->_isLoggedin = true;

                }else{

                }
            }
        }else{
            $this->find($user);
          }

    }

    public function create ($fields = array()){
        if(!$this->_db->insert('users',$fields)){
            throw new Exception();

        }
    }

    public function find($user = null){
        if($user){
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users',array($field,'=',$user));

            if($data->count()){
                $this->_data =$data->first();
                return true;
            }
        }
        return false;

    }

    public function login($username=null, $password = null, $remember){

        $user = $this->find($username);
        
        if($user){
            if($this->data()->password === Hash::make($password, $this->data()->salt)){
                // echo "ok!";
                Session::put($this->_sessionName, $this->data()->id);
                return true;

                if($remember){
                    $hash = Hash::unique();
                    $hashCheck = $this->_db->get('users_sessions', array('user_id', '=', $this->data()->id));

                    if(!$hashCheck->count()){
                        $this->_db->insert('users_sessions', array(
                            'user_id'=> $this->data()->id,
                            'hash'   => $hash
                        
                        ));
                    }else{
                        $hash =$hashCheck->first()->hash;
                    }
                    Cookie::put($this->_cookieName, $hash, Config::get('remeber/cookie_expiry'));

                }

                return true;

            }
        }
        return false;    
    }

    public function logout() {
        Session::delete($this->_sessionName);
    }


    public function data(){
        return $this->_data;

    }

    public function isLoggedin(){
        return $this->_isLoggedin;
    }
}