<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable {

    protected $connection = 'auth';

    protected $table = 'account';

    protected $fillable = [
        'username', 'password', 'email', 'expansion'
    ];

    use Notifiable;

    public static function create($data) {
        $passwordHashAccount = sha1(strtoupper($data['name']) . ":" . strtoupper($data['password_game']));
        $accountGame = \DB::connection('auth')->table('account')->insert(['username' => $data['name'], 'sha_pass_hash' => $passwordHashAccount, 'email' => $data['email'], 'reg_mail' => $data['email'], 'last_login' => date("Y-m-d H:i:s"), 'expansion' => '3']);
    }
    
    public static function newPassword($user, $password) {
        $passwordHashAccount = sha1(strtoupper($user) . ":" . strtoupper($password));
        $accountGame = \DB::connection('auth')->table('account')->where('email', $user)->update(['sha_pass_hash' => $passwordHashAccount]);
        return true;
    }

    public static function newEmail($user, $email) {
        $accountBnet = \DB::connection('auth')->table('battlenet_accounts')->where('email', $user)->update(['email' => $email]);
        $accountGame = \DB::connection('auth')->table('account')->where('email', $user)->update(['email' => $email]);
        return true;
    }

    public static function userGameID($email) {
        return \DB::connection('auth')->table('account')->where('email', '=', $email)->get();
    }

    public static function userGameAccount() {
        return \DB::connection('auth')->table('account')->where('email', '=', \Auth::user()->email)->get();
    }

    public static function userGameCharacters($id) {
        return \DB::connection('characters')->table('characters')->where('account', '=', $id)->get();
    }

    public static function banedUser() {
        return \DB::connection('auth')->table('account_banned')->where('active', '=', 1)->count();
    }
}
