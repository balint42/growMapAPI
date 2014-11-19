<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * plantings model
 *
 * The model handles plantings.
 *
 * @author Balint Morvai
 * @license http://opensource.org/licenses/MIT	MIT License
 * @package growMapAPI
 */
class Plantings_model extends CI_Model
{
    /**
     * @var t1_name name of the plantings table
     */
    private $t1_name = "gm_plantings";


    /**
     * Plantings model constructor
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Add a new planting to the db.
     * Returns TRUE if the planting was added, FALSE otherwise.
     * FALSE can occur either due to a duplicate planting or an error.
     *
     * @param int id the planting id
     * @param int crop_id the planted crop's id
     * @param int owner_id the owner's id
     * @param int created_at unix epoch time of creation [s]
     * @param int finished_at unix epoch time of finish if any, NULL otherwise [s]
     * @param string description the description text
     * @return bool
     */
    public function add_planting($id, $crop_id, $owner_id, $created_at, $finished_at = NULL, $description = NULL)
    {
        $this->db->from($this->t1_name)->where(TF_PS_ID, $id);
        if($this->db->count_all_results() == 0) {
            $this->db->insert($this->t1_name, array(
                TF_PS_ID => $id,
                TF_PS_CROP => $crop_id,
                TF_PS_OWNER => $owner_id,
                TF_PS_CREATED => $created_at,
                TF_PS_FINISHED => $finished_at,
                TF_PS_DESC => $description
            ));
        }

        return $this->db->affected_rows() > 0;
    }

    /**
     * Get a planting from the db by id.
     * Returns a planting array that contains the db field names as
     * keys and db field values as values.
     * Returns an empty array if the given id does not exist.
     *
     * @param int id the planting id
     * @return array
     */
    public function get_planting($id)
    {
        $this->db->where(TF_PS_ID, $id);
        $result = $this->db->get($this->t1_name)->result_array();

        return reset($result);
    }

    /**
     * Get plantings from the db by crop id.
     * Returns an array of associative planting arrays with the given crop id.
     * Each planting array contains the db field names as keys and db field
     * values as values.
     * Returns an empty array if the given id does not exist.
     *
     * @param int id the crop id
     * @return array
     */
    public function get_plantings_by_crop($crop_id)
    {
        $this->db->where(TF_PS_CROP, $crop_id);

        return $this->db->get($this->t1_name)->result_array();
    }

    /**
     * Get plantings from the db by owner id.
     * Returns an array of associative planting arrays with the given owner id.
     * Each planting array contains the db field names as keys and db field
     * values as values.
     * Returns an empty array if the given id does not exist.
     *
     * @param int id the owner id
     * @return array
     */
    public function get_plantings_by_owner($owner_id)
    {
        $this->db->where(TF_PS_CROP, $owner_id);

        return $this->db->get($this->t1_name)->result_array();
    }

    /**
     * Get all plantings from the db.
     * Returns an array of associative planting arrays. Each planting array
     * contains the db field names as keys and db field values as values.
     *
     * @return array
     */
    public function get_plantings()
    {
        return $this->db->get($this->t1_name)->result_array();
    }
}
