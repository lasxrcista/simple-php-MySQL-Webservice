<?php
/**
 * Created by Natalie Wiser-Orozco
 * Date: 2/6/18
 * Time: 10:20 AM
 */
require('connex.php');


class api
{
    private $db;

    /**
     * Constructor - open DB connection
     *
     * @param none
     * @return database
     */
    function __construct()
    {
        $this->db = new Db();
    }

    /**
     * Destructor - close DB connection
     *
     * @param none
     * @return none
     */
    function __destruct()
    {
        //
    }

    /**
     * Get the list of users
     *
     * @param none or user id
     * @return list of data on JSON format
     */

    function get()
    {

        $topPostsSql = "SELECT wp.post_title, wp.post_date, wp.post_excerpt, pm.meta_value, wp2.guid, wp.guid as postLink FROM `wp_posts` wp 
        INNER JOIN `wp_postmeta` pm
        ON pm.post_id = wp.id 
        INNER JOIN `wp_posts` wp2 ON
        wp2.id = pm.meta_value
        WHERE wp.post_status='publish' and wp.comment_status='open' and wp.ping_status='open' and pm.meta_key='_thumbnail_id' ORDER BY wp.post_date DESC
        
        LIMIT 3";

        $theResult = $this->db->select($topPostsSql);


        return $theResult;

    }
}
