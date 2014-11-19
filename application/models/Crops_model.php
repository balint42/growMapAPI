<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * crops model
 *
 * The model handles crops.
 *
 * @author Balint Morvai
 * @license http://opensource.org/licenses/MIT	MIT License
 * @package growMapAPI
 */
class Crops_model extends CI_Model
{
    /**
     * @var t1_name name of the crops table
     */
    private $t1_name = "gm_crops";


    /**
     * Crops model constructor
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Add a new crop to the db.
     * Returns TRUE if the crop was added, FALSE otherwise.
     * FALSE can occur either due to a duplicate crop or an error.
     *
     * @param int id the crop id
     * @param string name the crop name
     * @param string wiki optional string giving the english wiki url for the crop
     * @param int count optional integer giving the plantings count of the crop
     * @return bool
     */
    public function add_crop($id, $name, $wiki = NULL, $count = NULL)
    {
        $this->db->from($this->t1_name)->where(TF_CS_ID, $id);
        if($this->db->count_all_results() == 0) {
            $this->db->insert($this->t1_name, array(
                TF_CS_ID => $id,
                TF_CS_NAME => $name,
                TF_CS_WIKI => $wiki,
                TF_CS_COUNT => $count
            ));
        }

        return $this->db->affected_rows() > 0;
    }

    /**
     * Get a crop from the db by id.
     * Returns a crop array that contains the db field names
     * as keys and db field values as values.
     * Returns an empty array if the given id does not exist.
     *
     * @param int id the crop id
     * @return array
     */
    public function get_crop($id)
    {
        $this->db->where(TF_CS_ID, $id);
        $result = $this->db->get($this->t1_name)->result_array();

        return reset($result);
    }

    /**
     * Get all crops from the db.
     * Returns an array of associative crop arrays. Each crop array
     * contains the db field names as keys and db field values as values.
     *
     * @return array
     */
    public function get_crops()
    {
        return $this->db->get($this->t1_name)->result_array();
    }
}
