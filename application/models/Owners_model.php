<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * owners model
 *
 * The model handles owners.
 *
 * @author Balint Morvai
 * @license http://opensource.org/licenses/MIT	MIT License
 * @package growMapAPI
 */
class Owners_model extends CI_Model
{
    /**
     * @var t1_name name of the owners table
     */
    private $t1_name = "gm_owners";


    /**
     * Owners model constructor
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Add a new owner to the db.
     * Returns TRUE if the owner was added, FALSE otherwise.
     * FALSE can occur either due to a duplicate owner or an error.
     *
     * @param int id the owner id
     * @param float lat latitude of the owner
     * @param float lng longitude of the owner
     * @param string name the owner name
     * @return bool
     */
    public function add_owner($id, $lat, $lng, $name)
    {
        $this->db->from($this->t1_name)->where(TF_OS_ID, $id);
        if($this->db->count_all_results() == 0) {
            $this->db->insert($this->t1_name, array(
                TF_OS_ID => $id,
                TF_OS_LAT => $lat,
                TF_OS_LNG => $lng,
                TF_OS_NAME => $name
            ));
        }

        return $this->db->affected_rows() > 0;
    }

    /**
     * Get an owner from the db by id.
     * Returns an owner array that contains the db field names
     * as keys and db field values as values.
     * Returns an empty array if the given id does not exist.
     *
     * @param int id the owner id
     * @return array
     */
    public function get_owner($id)
    {
        $this->db->where(TF_OS_ID, $id);
        $result = $this->db->get($this->t1_name)->result_array();

        return reset($result);
    }

    /**
     * Get all owners from the db.
     * Returns an array of associative owner arrays. Each owner array
     * contains the db field names as keys and db field values as values.
     *
     * @return array
     */
    public function get_owners()
    {
        return $this->db->get($this->t1_name)->result_array();
    }
}
