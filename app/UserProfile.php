<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
         'description', 'email_description', 'image', 'user', 'company', 'links'
    ];
    protected $casts = [
        'links' => 'object'
    ];
    public function user()
    {
        return $this->belongsTo('App\User', 'user');
    }
    public static function createProfile($user, $company, $description, $email_description, $links, $imagename)
    {
        $profile = UserProfile::create([
            'user' => $user,
            'description' => $description,
            'company' => $company,
            'email_description' => $email_description,
            'links' => json_decode($links),
            'image' => $imagename
        ]);
        return "$user updated!";
    }
    public static function updateProfile($user, $company, $description, $email_description, $links, $image)
    {
        echo "links $links";
        $profile = UserProfile::where('user', $user)->first();
        $profile->description = $description;
        $profile->company = $company;
        $profile->email_description = $email_description;
        $profile->links = $links;
        $profile->image = $image;
        $profile->update();
        // ->update([
        //     'description' => $description,
        //     'company' => $company,
        //     'email_description' => $email_description,
        //     'links' => json_decode($links),
        //     'image' => $image
        // ]);

        return $profile;
    }
}
