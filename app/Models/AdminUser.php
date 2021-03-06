<?php
namespace App\Models;
use App\Traits\PemissionTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
/**
 * Class AdminUser
 */
class AdminUser extends Authenticatable implements JWTSubject
{
    use PemissionTrait;

    protected $dates = ['delete_at'];

    protected $table = 'admin_user';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'username',
        'nikename',
        'avatar',
        'mobile',
        'wx',
        'password',
        'rember_token',
        'invitation_code',
        'begin_at',
        'end_at',
        'operator_id',
        'status',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $guarded = [];

    public function getJWTIdentifier()
    {
        return $this->getKey(); // Eloquent model method
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims(){
        return [];
    }

    /**
     * A role belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'admin_role_user', 'user_id', 'role_id');
    }

    public function setInvitationCode( $id ){
        $code = $this->createrInvitationCode($id);
        $this->where( 'id', $id)->update(['invitation_code'=>$code] );
        return $this;
    }
    /**
     * 创建邀请码
     * @param $id
     * @return string
     */
    public function createrInvitationCode($id){
        static $sourceString = [
            0,1,2,3,4,5,6,7,8,9,10,
            'a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','q','r',
            's','t','u','v','w','x',
            'y','z'
        ];
        $num = $id;
        $code = '';
        while($num)
        {
            $mod = $num % 36;
            $num = (int)($num / 36);
            $code = $sourceString[$mod].$code;
        }
        //判断code的长度
        if( strlen($code) <= 4 )
        {
            $code = str_pad($code,5,'0',STR_PAD_LEFT);
        }
        return $code;
    }

}