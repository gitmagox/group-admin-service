<?php

namespace App\Models;


use App\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class Menu.
 *
 * @property int $id
 *
 * @method where($parent_id, $id)
 */
class Menu extends Model
{
    use ModelTree;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'order', 'title', 'icon', 'uri'];

    protected $table = 'admin_menu';

    public $timestamps = true;


    /**
     * A Menu belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'admin_role_menu', 'menu_id', 'role_id');
    }

    /**
     * @return array
     */
    public function allNodes()
    {
        $orderColumn = DB::getQueryGrammar()->wrap($this->orderColumn);
        $byOrder = $orderColumn.' = 0,'.$orderColumn;
        //\DB::enableQueryLog();
        $data = static::with('roles')->orderByRaw($byOrder)->get()->toArray();
        return $data;
        //dd(\DB::getQueryLog());
    }

    /**
     * Build Nested array.
     *
     * @param array $nodes
     * @param int   $parentId
     *
     * @return array
     */
    protected function buildNestedArray(array $nodes = [], $parentId = 0)
    {
        $branch = [];

        if (empty($nodes)) {
            $nodes = $this->allNodes();
        }

        foreach ($nodes as $node) {
            if( Auth::guard('api_admin')->user()->visible( $node['roles'] ) ){
                if ($node[$this->parentColumn] == $parentId) {
                    $children = $this->buildNestedArray($nodes, $node[$this->getKeyName()]);
                    if ($children) {
                        $node['children'] = $children;
                    }
                    $branch[] = $node;
                }
            }
        }

        return $branch;
    }
}
