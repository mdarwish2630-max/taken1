<?php
/**
 * CMS Platform - Database Class
 * كلاس قاعدة البيانات باستخدام PDO
 */

class Database
{
    private static $instance = null;
    private $pdo;
    private $query;
    private $error;
    private $results;
    private $count = 0;

    /**
     * إنشاء اتصال بقاعدة البيانات
     */
    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            if (DEBUG_MODE) {
                echo "<h2>Database Connection Failed</h2>";
                echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
                echo "<p><strong>Host:</strong> " . htmlspecialchars(DB_HOST) . "</p>";
                echo "<p><strong>Database:</strong> " . htmlspecialchars(DB_NAME) . "</p>";
                echo "<p><strong>User:</strong> " . htmlspecialchars(DB_USER) . "</p>";
                echo "<hr><p>Check settings in <code>app/config/config.php</code> and import <code>sql/database.sql</code></p>";
            } else {
                echo "<h2>Site temporarily unavailable</h2>";
            }
            exit;
        }
    }

    /**
     * الحصول على نسخة وحيدة من الكلاس (Singleton)
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * تنفيذ استعلام SQL مع المعاملات
     * @param string $sql الاستعلام
     * @param array $params المعاملات
     * @return $this
     */
    public function query($sql, $params = [])
    {
        $this->error = false;
        
        try {
            $this->query = $this->pdo->prepare($sql);
            
            if (!empty($params)) {
                $i = 1;
                foreach ($params as $param) {
                    $this->query->bindValue($i, $param);
                    $i++;
                }
            }
            
            if ($this->query->execute()) {
                $this->results = $this->query->fetchAll();
                $this->count = $this->query->rowCount();
            } else {
                $this->error = true;
            }
        } catch (PDOException $e) {
            $this->error = true;
            if (DEBUG_MODE) {
                error_log("SQL Error: " . $e->getMessage());
            }
        }
        
        return $this;
    }

    /**
     * الحصول على جميع النتائج
     */
    public function results()
    {
        return $this->results;
    }

    /**
     * الحصول على نتيجة واحدة
     */
    public function first()
    {
        return $this->results()[0] ?? null;
    }

    /**
     * الحصول على عدد الصفوف
     */
    public function count()
    {
        return $this->count;
    }

    /**
     * التحقق من وجود خطأ
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * الحصول على آخر ID تم إدخاله
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * الحصول على كائن PDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * بدء معاملة
     */
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * إنهاء المعاملة بنجاح
     */
    public function commit()
    {
        return $this->pdo->commit();
    }

    /**
     * التراجع عن المعاملة
     */
    public function rollBack()
    {
        return $this->pdo->rollBack();
    }

    /**
     * تنفيذ استعلام مباشر - DEPRECATED: Use query() with parameterized queries instead.
     * This method allows raw SQL execution without parameterization and is a SQL injection risk.
     * @deprecated Use query($sql, $params) for all SQL operations.
     * @param string $sql Raw SQL query
     * @return int Number of affected rows
     */
    public function raw($sql)
    {
        error_log('SECURITY WARNING: Database::raw() is deprecated. Use parameterized query() instead. SQL: ' . $sql);
        return $this->pdo->exec($sql);
    }

    /**
     * منع استنساخ الكائن
     */
    private function __clone() {}

    /**
     * منع إلغاء التسلسل
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
}
