<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table            = 'menus';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'slug', 'category_id', 'description', 'price', 'image'];

    protected bool $allowEmptyInserts = true;

    public function get($slug = false, $limit = 9, $noLimit = false)
    {
        if ($slug) {
            $query = $this->table($this->table)
                ->select('menus.*, mc.name as category_name, mc.id as category_id')
                ->join('menu_categories mc', 'mc.id = menus.category_id')
                ->where('slug', $slug)
                ->first();
            return $query;
        } elseif ($noLimit) {
            return $this->table($this->table)
                ->select('menus.*, c.name as category_name')
                ->join('menu_categories c', 'c.id = menus.category_id')
                ->findAll();
        } else {
            return $this->table($this->table)
                ->select('menus.*, c.name as category_name')
                ->join('menu_categories c', 'c.id = menus.category_id')
                ->paginate($limit, 'menus');
        }
    }

    public function search($keyword)
    {
        return $this->table($this->table)
            ->select('menus.*, mc.name as category_name')
            ->join('menu_categories mc', 'mc.id = menus.category_id')
            ->like('menus.name', $keyword)
            ->paginate(9, 'menus');
    }
}
