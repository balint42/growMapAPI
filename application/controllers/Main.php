<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Main Controller
 *
 * This content is released under the MIT License (MIT)
 *
 * Main controller for growMapAPI package.
 *
 * @package	growMapAPI
 * @author	Balint Morvai
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @filesource
 */

class Main extends CI_Controller {
    /**
     * @var api_url the root url of the crops growstuff api
     */
    var $api_url = "http://www.growstuff.org/crops";

    /**
     * Main constructor
     */
    public function __construct()
    {
        parent::__construct();
        // init
        $this->load->database();
        $this->load->model('Crops_model', 'crops_model');
        $this->load->model('Plantings_model', 'plantings_model');
        $this->load->model('Owners_model', 'owners_model');
        // growstuff should give dates in UTC (with "Z" suffix in JS)
        date_default_timezone_set('UTC');
    }

    /**
     * Index Page for this controller.
     *
     * @return void
     */
    public function index()
    {
        $this->load->view('Main_view');
    }

    /**
     * JSON API duplicating the growstuff
     * "crops.json" and "crops/(:num).json" calls partially
     * or acting differently if called with id < 0.
     *
     * @param int id
     * @return void
     */
    public function crops($id = null)
    {
        if($id > 0) {
            // get one specific crop with detailed data
            $result = $this->_get_crop($id);
        }
        else if ($id == null) {
            // get all crops growstuff-style (no detailed data)
            $result = $this->crops_model->get_crops();
        }
        else if ($id < 0) {
            $crops = $this->crops_model->get_crops();
            // get all crops alternative-style (with detailed data)
            $result = array();
            for($i = 0; $i < count($crops); $i++) {
                $result[] = $this->_get_crop($crops[$i][TF_CS_ID]);
            }
        }

        $json = json_encode($result, JSON_UNESCAPED_SLASHES);
        $this->output
             ->set_content_type('application/json')
             ->set_output($json);
    }

    /**
     * Update db via growstuff JSON API.
     *
     * @return void
     */
    public function update()
    {
        // below we just try to add any crop, planting or owner and
        // don't care if they already exist or not - the models will
        // avoid duplicates.
        $crops = json_decode(file_get_contents($this->api_url.'.json'));
        foreach($crops as $crop) {
            // add crop
            $this->crops_model->add_crop(
                $crop->id,
                $crop->name,
                $crop->en_wikipedia_url,
                $crop->plantings_count
            );
            // add plantings & owners
            $plantings = json_decode(
                            file_get_contents($this->api_url.'/'.$crop->id.'.json'))
                         ->plantings;
            foreach($plantings as $planting) {
                $owner = $planting->owner;
                // convert dates to unix time (UTC)
                $d = date_parse($planting->created_at);
                $planting->created_at = mktime($d['hour'], $d['minute'], $d['second'],
                                               $d['month'], $d['day'], $d['year']);
                if($planting->finished_at) {
                    $d = date_parse($planting->finished_at);
                    $planting->finished_at = mktime($d['hour'], $d['minute'], $d['second'],
                                                        $d['month'], $d['day'], $d['year']);
                }
                // add planting
                $this->plantings_model->add_planting(
                    $planting->id,
                    $planting->crop_id,
                    $planting->owner_id,
                    $planting->created_at,
                    $planting->finished_at,
                    $planting->description
                );
                // add owner
                $this->owners_model->add_owner(
                    $owner->id,
                    $owner->latitude,
                    $owner->longitude,
                    $owner->login_name
                );
            }
        }

        print_r("update done");
    }

    /**
     * Get crop given by id from db and return it
     * in an API like array format.
     *
     * @param int id crop id
     * @return array
     */
    private function _get_crop($id)
    {
        // lets build a growstuff-like JSON response
        // get crop details
        $result = $this->crops_model->get_crop($id);
        // add list of plantings
        $result['plantings'] =
            $this->plantings_model->get_plantings_by_crop($id);
        // format date & add owner details for each planting
        for($i = 0; $i < count($result['plantings']); $i++) {
            // format date
            $result['plantings'][$i][TF_PS_CREATED] =
                date("Y-m-d", $result['plantings'][$i][TF_PS_CREATED]);
            if($result['plantings'][$i][TF_PS_FINISHED]) {
                $result['plantings'][$i][TF_PS_FINISHED] =
                    date("Y-m-d", $result['plantings'][$i][TF_PS_FINISHED]);
            }
            // add owner details
            $result['plantings'][$i]['owner'] =
                $this->owners_model->get_owner($result['plantings'][$i][TF_PS_OWNER]);
        }

        return $result;
    }
}

/* End of file Main.php */
/* Location: ./application/controllers/Main.php */
