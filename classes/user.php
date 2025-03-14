<?php
Class User {
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedin;

    public function __construct($user = null){
        $this->_db = DB::getInstance();

        $this->_sessionName =Config::get('session/session_name');
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

    public function update($fields = array(), $id = null){

        if(!$id && $this->isLoggedin()) {
            $id = $this->data()->id;
        }


        if(!$this->_db->update('users',$id,$fields)){
            throw new Exception('There was a problem updating.');
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

    public function login($username=null, $password = null, $remember=false){
       

       

        if(!$username && !$password && $this->exists() ){
            Session::put($this->_sessionName,$this->data()->id);

        }else{
            $user = $this->find($username);
                
            if($user){
                if($this->data()->password === Hash::make($password, $this->data()->salt)){
                    // echo "ok!";
                    Session::put($this->_sessionName, $this->data()->id);
                // return true;

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

        }
        return false;    
    }

    // public function hasPermission($key){
    //     $group = $this->_db->get('groups', array('id', '=', $this->data()->group));
        
    //     if($group->count()){
    //        $permissions = json_decode($group->first()->permissions, true);        
       
          
    //       if($permissions[$key] == true){
    //         return true;
    //       }
          
    //     }
    //     return false;

    // }
    public function hasPermission($key) {
        // Fetch the group data from the database
        $group = $this->_db->get('groups', array('id', '=', $this->data()->group));
    
        // Check if any group data was returned
        if($group->count()) {
            // Decode the permissions JSON string
            $permissions = json_decode($group->first()->permissions, true);        
    
            // Check if the decoding was successful and if the key exists in the permissions array
            if (json_last_error() === JSON_ERROR_NONE && isset($permissions[$key]) && $permissions[$key] == true) {
                return true;
            }
        }
    
        // Return false if no permissions are found or if the key does not have the required permission
        return false;
    }
    

    public function exists(){
        return (!empty($this->_data)) ? true :false ;
    }

    public function logout() {

        $this->_db->delete('users_sessions',array('user_id','=',$this->data()->id));


        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }


    public function data(){
        return $this->_data;

    }

    public function isLoggedin(){
        return $this->_isLoggedin;
    }
}