<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Laravolt\Avatar\Avatar;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable /* SoftDeletes */;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'role_id',
        'password',
        'profileImage',
        'addressLine1',
        'addressLine2',
        'city',
        'state',
        'county',
        'pinCode',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public static function getUserRoles()
    {
        return Role::pluck('role_type', 'id'); // Assuming you have a Role model and 'name' field for the role name
    }

    // Define the relationship
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function saveUserProfileImg($image)
    {
        /*
        Upload file and store files into the sever itself
        $profileName = $image->getClientOriginalName();
        $profileNamePath = $image->storeAs("Users/User_$this->id", $profileName, 'public');
        $profileUrl =  url("uploads/$profileNamePath");
        return $profileUrl;
        */

        //Upload file and Store files into AWS S3 bucket
        $profileName = $image->getClientOriginalName();
        $path = "Users/User_$this->id/$profileName";
        Storage::disk('s3')->put($path, file_get_contents($image), 'public');
        $profileUrl = Storage::disk('s3')->url($path);
        return $profileUrl;
    }

    public function deleteUserProfileImg()
    {
        /*
        Delete files form the sever
        $baseFileName = basename($this->profileImage);
        Storage::disk('public')->delete("Users/User_$this->id/{$baseFileName}");
        File::deleteDirectory("uploads/Users/User_$this->id");
        */

        //Delete file from the AWS S3 bucket
        if (!$this->profileImage) {
            return; // No image to delete
        }
        $filePath = parse_url($this->profileImage, PHP_URL_PATH);
        $filePath = ltrim($filePath, '/');
        Storage::disk('s3')->delete($filePath);
    }

    public function getProfileAvatar($size)
    {
        $avatar = new Avatar();
        $name = strtoupper($this->name);
        $name = strtoupper($this->surname);
        $profileImage = $avatar
            ->create($name . $name)
            ->setBackground($this->getRandomConfiguredColor())
            ->toGravatar(['d' => 'identicon', 'r' => 'pg', 's' => $size]);
        return $profileImage;
    }

    private function getRandomConfiguredColor()
    {
        $backgrounds = config('laravolt.avatar.backgrounds');
        $randomColor = $backgrounds[array_rand($backgrounds)];
        return $randomColor;
    }
}
