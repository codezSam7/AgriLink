<?php

require_once 'Db.php';
class Admin extends Db
{
    private $agconn;

    public function __construct()
    {
        $this->agconn = $this->connect();
    }

    public function login_admin($username, $password)
    {
        try {
            $sql = 'SELECT * FROM admins WHERE admin_username = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$username]);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($record) {
                $saved_hash = $record['admin_password'];
                $rsp = password_verify($password, $saved_hash);
                if ($rsp) {
                    // keep their id in session: key:user_online
                    $_SESSION['admin_online'] = $record['admin_id'];

                    return true; // password and username are correct
                } else {
                    $_SESSION['errormsg'] = 'Incorrect password';

                    return false; // incorrect password
                }
            } else {
                $_SESSION['errormsg'] = 'Invalid username';

                return false;
            }
        } catch (PDOException $e) {
            // echo $e->getMessage(); die();
            return false;
        }
    }

    // create a method that accepts user_id and returns all the details of the user so as for them to keep them logged whenever they go from page to page
    public function get_admin_details($admin_id)
    {
        try {
            $sql = 'SELECT * FROM admins WHERE admin_id = ?';
            $stmt = $this->agconn->prepare($sql);
            $stmt->execute([$admin_id]);
            $rsp = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rsp;
        } catch (PDOException $e) {
            // echo $e->getMessage();
            return false;
        }
    }

    // a method that logs out user by destroying all the session for the user
    public function logout()
    {
        session_unset();
        session_destroy();
    }
}

// $re = new Admin;
// var_dump($re->change_recipe_status(11));
