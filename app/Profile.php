<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{

    protected $guarded = [];

    public function profileImage()
    {
        $imagePath = ($this->image) ? $this->image : 'https://scontent-nrt1-1.cdninstagram.com/v/t51.2885-19/s150x150/94692020_270398274124587_3266959104106561536_n.jpg?_nc_ht=scontent-nrt1-1.cdninstagram.com&_nc_ohc=I6e5MC6_ywcAX9zRltZ&oh=4685f8257dd26740c7791ab75053132a&oe=5ECDC728';

        return '/storage/' . $imagePath;
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
