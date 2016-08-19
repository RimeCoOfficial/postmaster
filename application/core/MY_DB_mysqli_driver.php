<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// https://ellislab.com/forums/viewthread/203637/
// http://nitmedia.com/post/18132504068/codeigniter-on-duplicate-update-db-function

class MY_DB_mysqli_driver extends CI_DB_mysqli_driver
{
    final public function __construct($params)
    {
        return parent::__construct($params);
    }

    // http://dev.mysql.com/doc/refman/5.1/en/innodb-auto-increment-handling.html
    // innodb_autoinc_lock_mode = 0

    // --------------------------------------------------------------------

    /**
     * Insert_On_Duplicate_Update
     *
     * Compiles an insert string and runs the query
     *
     * @param string  the table to insert data into
     * @param array an associative array of insert values
     * @param bool  $escape Whether to escape values and identifiers
     * @return  object
     */
    public function insert_on_duplicate_update($table = '', $set = NULL, $escape = NULL)
    {
        if ($set !== NULL)
        {
            $this->set($set, '', $escape);
        }

        if ($this->_validate_insert($table) === FALSE)
        {
            return FALSE;
        }

        $sql = $this->_insert_on_duplicate_update(
            $this->protect_identifiers(
                $this->qb_from[0], TRUE, $escape, FALSE
            ),
            array_keys($this->qb_set),
            array_values($this->qb_set)
        );

        $this->_reset_write();
        return $this->query($sql);
    }

    // --------------------------------------------------------------------

    /**
     * Insert statement
     *
     * Generates a platform-specific insert string from the supplied data
     *
     * @param string  the table name
     * @param array the insert keys
     * @param array the insert values
     * @return  string
     */
    protected function _insert_on_duplicate_update($table, $keys, $values)
    {
        foreach($keys as $key)
         $update_fields[] = $key.'=VALUES('.$key.')';

        return "INSERT INTO ".$table." (".implode(', ', $keys).") VALUES (".implode(', ', $values).") ON DUPLICATE KEY UPDATE ".implode(', ', $update_fields);
    }

    // --------------------------------------------------------------------

    /**
     * Insert_Batch_On_Duplicate_Update
     *
     * Compiles batch insert strings and runs the queries
     * MODIFIED to do a MySQL 'ON DUPLICATE KEY UPDATE'
     *
     * @access public
     * @param string the table to retrieve the results from
     * @param array an associative array of insert values
     * @return object
     */
    function insert_batch_on_duplicate_update($table = '', $set = NULL, $escape = NULL)
    {
        if ($set !== NULL)
        {
            $this->set_insert_batch($set, '', $escape);
        }

        if (count($this->qb_set) === 0)
        {
            // No valid data array. Folds in cases where keys and values did not match up
            return ($this->db_debug) ? $this->display_error('db_must_use_set') : FALSE;
        }

        if ($table === '')
        {
            if ( ! isset($this->qb_from[0]))
            {
                return ($this->db_debug) ? $this->display_error('db_must_set_table') : FALSE;
            }

            $table = $this->qb_from[0];
        }

        // Batch this baby
        $affected_rows = 0;
        for ($i = 0, $total = count($this->qb_set); $i < $total; $i += 100)
        {
            $this->query($this->_insert_batch_on_duplicate_update($this->protect_identifiers($table, TRUE, $escape, FALSE), $this->qb_keys, array_slice($this->qb_set, $i, 100)));
            $affected_rows += $this->affected_rows();
        }

        $this->_reset_write();
        return $affected_rows;
    }

    // --------------------------------------------------------------------

    /**
     * Insert batch statement
     *
     * Generates a platform-specific insert string from the supplied data.
     *
     * @param string  $table  Table name
     * @param array $keys INSERT keys
     * @param array $values INSERT values
     * @return  string
     */
    protected function _insert_batch_on_duplicate_update($table, $keys, $values)
    {
        foreach($keys as $key)
            $update_fields[] = $key.'=VALUES('.$key.')';

        return 'INSERT INTO '.$table.' ('.implode(', ', $keys).') VALUES '.implode(', ', $values).' ON DUPLICATE KEY UPDATE '.implode(', ', $update_fields);
    }
}