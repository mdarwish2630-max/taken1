<?php
/**
 * CMS Platform - Base Model Class
 * الكلاس الأساسي للنماذج
 */

abstract class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $timestamps = true;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * الحصول على جميع السجلات
     */
    public function all($orderBy = null, $direction = 'ASC')
    {
        $sql = "SELECT * FROM {$this->table}";
        
        if ($orderBy) {
            $orderBy = $this->sanitizeOrderBy($orderBy);
            // Only append direction if orderBy doesn't already contain one
            if (stripos($orderBy, 'ASC') === false && stripos($orderBy, 'DESC') === false) {
                $direction = $this->sanitizeDirection($direction);
                $sql .= " ORDER BY {$orderBy} {$direction}";
            } else {
                $sql .= " ORDER BY {$orderBy}";
            }
        }
        
        return $this->db->query($sql)->results();
    }

    /**
     * البحث بواسطة المعرف
     */
    public function find($id)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?",
            [$id]
        )->first();
    }

    /**
     * البحث بواسطة حقل معين
     */
    public function findBy($column, $value)
    {
        return $this->db->query(
            "SELECT * FROM {$this->table} WHERE {$column} = ?",
            [$value]
        )->first();
    }

    /**
     * البحث عن جميع السجلات بواسطة حقل معين
     */
    public function findAllBy($column, $value, $orderBy = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = ?";
        
        if ($orderBy) {
            $sql .= " ORDER BY " . $this->sanitizeOrderBy($orderBy);
        }
        
        return $this->db->query($sql, [$value])->results();
    }

    /**
     * الحصول على السجلات مع شروط متعددة
     */
    public function where($conditions, $params = [], $orderBy = null, $limit = null)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$conditions}";
        
        if ($orderBy) {
            $sql .= " ORDER BY " . $this->sanitizeOrderBy($orderBy);
        }
        
        if ($limit) {
            $sql .= " LIMIT " . $this->sanitizeLimit($limit);
        }
        
        return $this->db->query($sql, $params)->results();
    }

    /**
     * إنشاء سجل جديد
     */
    public function create($data)
    {
        $data = $this->filterFillable($data);
        
        if ($this->timestamps) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        
        $this->db->query($sql, array_values($data));
        
        if (!$this->db->error()) {
            return $this->db->lastInsertId();
        }
        
        return false;
    }

    /**
     * تحديث سجل
     */
    public function update($id, $data)
    {
        $data = $this->filterFillable($data);
        
        if ($this->timestamps) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        
        $setParts = [];
        foreach (array_keys($data) as $column) {
            $setParts[] = "{$column} = ?";
        }
        
        $setClause = implode(', ', $setParts);
        $params = array_values($data);
        $params[] = $id;
        
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?";
        
        $this->db->query($sql, $params);
        
        return !$this->db->error();
    }

    /**
     * حذف سجل
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        
        $this->db->query($sql, [$id]);
        
        return !$this->db->error();
    }

    /**
     * حذف بشروط
     */
    public function deleteWhere($conditions, $params = [])
    {
        $sql = "DELETE FROM {$this->table} WHERE {$conditions}";
        
        $this->db->query($sql, $params);
        
        return !$this->db->error();
    }

    /**
     * عد السجلات
     */
    public function count($conditions = null, $params = [])
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        
        if ($conditions) {
            $sql .= " WHERE {$conditions}";
        }
        
        $result = $this->db->query($sql, $params)->first();
        
        return $result ? $result->count : 0;
    }

    /**
     * التحقق من وجود سجل
     */
    public function exists($conditions, $params = [])
    {
        return $this->count($conditions, $params) > 0;
    }

    /**
     * الحصول على سجلات مع ترقيم الصفحات
     */
    public function paginate($page = 1, $perPage = 10, $conditions = null, $params = [], $orderBy = null)
    {
        $perPage = $this->sanitizeLimit($perPage);
        $page = $this->sanitizeLimit($page);
        $offset = ($page - 1) * $perPage;
        $total = $this->count($conditions, $params);
        
        $sql = "SELECT * FROM {$this->table}";
        
        if ($conditions) {
            $sql .= " WHERE {$conditions}";
        }
        
        if ($orderBy) {
            $sql .= " ORDER BY " . $this->sanitizeOrderBy($orderBy);
        }
        
        $sql .= " LIMIT {$perPage} OFFSET {$offset}";
        
        $results = $this->db->query($sql, $params)->results();
        
        return [
            'data' => $results,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'last_page' => ceil($total / $perPage),
        ];
    }

    /**
     * تصفية البيانات حسب الـ fillable
     */
    protected function filterFillable($data)
    {
        if (empty($this->fillable)) {
            return $data;
        }
        
        return array_intersect_key($data, array_flip($this->fillable));
    }

    /**
     * التحقق من اسم العمود (لمنع SQL Injection)
     * يدعم عمود واحد أو عدة أعمدة مع اتجاه
     */
    private function sanitizeOrderBy($orderBy)
    {
        $orderBy = trim($orderBy);
        
        // Handle multi-column: "col1 ASC, col2 DESC"
        if (strpos($orderBy, ',') !== false) {
            $parts = array_map('trim', explode(',', $orderBy));
            $safe = [];
            foreach ($parts as $part) {
                $safe[] = $this->sanitizeOrderBySingle($part);
            }
            return implode(', ', $safe);
        }
        
        return $this->sanitizeOrderBySingle($orderBy);
    }
    
    /**
     * التحقق من عمود واحد مع اتجاهه
     */
    private function sanitizeOrderBySingle($orderBy)
    {
        $orderBy = trim($orderBy);
        $parts = preg_split('/\s+/', $orderBy);
        
        if (count($parts) === 2) {
            $column = $parts[0];
            $direction = strtoupper($parts[1]);
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $column)) {
                throw new \InvalidArgumentException("Invalid order by column: {$column}");
            }
            if ($direction !== 'ASC' && $direction !== 'DESC') {
                $direction = 'ASC';
            }
            return "{$column} {$direction}";
        }
        
        // Single column name
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $orderBy)) {
            throw new \InvalidArgumentException("Invalid order by column: {$orderBy}");
        }
        return $orderBy;
    }

    /**
     * التحقق من اتجاه الترتيب (لمنع SQL Injection)
     */
    private function sanitizeDirection($direction)
    {
        $direction = strtoupper($direction);
        if ($direction !== 'ASC' && $direction !== 'DESC') {
            return 'ASC';
        }
        return $direction;
    }

    /**
     * التحقق من قيمة الحد (لمنع SQL Injection)
     */
    private function sanitizeLimit($limit)
    {
        $limit = (int) $limit;
        if ($limit < 1) {
            return 10;
        }
        return $limit;
    }

    /**
     * تنفيذ استعلام مخصص
     */
    public function raw($sql, $params = [])
    {
        return $this->db->query($sql, $params);
    }

    /**
     * الحصول على آخر خطأ
     */
    public function error()
    {
        return $this->db->error();
    }

    /**
     * بدء معاملة
     */
    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    /**
     * إنهاء المعاملة
     */
    public function commit()
    {
        return $this->db->commit();
    }

    /**
     * التراجع عن المعاملة
     */
    public function rollBack()
    {
        return $this->db->rollBack();
    }
}
