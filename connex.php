<?php
/**
 * Created by PhpStorm.
 * User: BeerHunters
 * Date: 2/6/18
 * Time: 8:43 AM
 */

class Db
{
    // The database connection

    protected static $connection;

    // Connect to the database.  Return false on failure / mysqli MySQLi object instance on success
    public function connect()
    {
        // Try to connect to the database

        // Try and connect to the database, if a connection has not been established yet
        if (!isset(self::$connection)) {
            // Load configuration as an array. Use the actual location of your configuration file
            $config = parse_ini_file('../../../config.ini');

            self::$connection = new mysqli($config['host'], $config['username'], $config['password'], $config['database']);
        }

        // If connection was not successful, handle the error
        if (self::$connection === false) {
            // Handle error - notify administrator, log to a file, show an error screen, etc.
            return false;
        }
        return self::$connection;
    }

    /** Query the database
     * @param $query is the query string
     * @return The result of the mysqli::query() function
     */
    public function query($query)
    {
        // Connect to the database
        $connection = $this->connect();

        // Query the database
        $result = mysqli_query($connection, $query);

        return $result;
    }

    /** Fetch rows from the database (SELECT query)
     * @param $query
     * @return array|bool - false on failure, array on query success.
     */
    public function select($query)
    {
        $rows = array();
        $result = $this->query($query);

        // If query failed, return `false`
        if ($result === false) {
            return false;
        }

        // If query was successful, retrieve all the rows into an array
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    /** Get the last error from the database
     * @return string
     */
    public function error()
    {
        $connection = $this->connect();
        return $connection->error;
    }

    /** Quote and escape value for use in a database query to prevent injection attacks
     * @param $value
     * @return string
     */
    public function quote($value)
    {
        $connection = $this->connect();
        return "'" .$connection->real_escape_string($value) . "'";
    }
}
