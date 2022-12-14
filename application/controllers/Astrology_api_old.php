<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		exit(0);
}
class Astrology_api extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		// $this->load->model('Api_Model','w_m');
		$this->load->library('form_validation');
	}

	public function index()
	{
	print_r("expression"); die;	
	}

	public function global_api()
	{
		// $data =json_decode(file_get_contents('php://input'), true);	
		$data = array(
		'api-condition' => "lalkitab_remedies",
		'user_id' => 25,
		'planet_name' => "sun",
		'name' => "shubham",
		'lang' => "hi",
		'date' => 25,
		'month' => 12,
		'year' => 1988,
		'hour' => 4,
		'minute' => 0,
		'latitude' => 25.123,
		'longitude' => 82.34,
		'timezone' => 5.5
		



		);
		if(isset($data) && !empty($data))
		{
			
			$userId = "616664";
			$apiKey = "a5d2bc019b2fb1f31d99417fa4e5099e";

			// make some dummy data in order to call vedic rishi api
			$planetName = ["sun", "moon", "mars", "mercury", "jupiter", "venus", "saturn" , "ascendant"];

			//sign name
			$signName = ['aries', 'taurus', 'gemini', 'cancer', 'leo', 'virgo', 'libra', 'scorpio', 'sagittarius', 'capricorn', 'aquarius', 'pisces'];


			//chart Id to calculate horoscope chart
			$chartId = ['chalit','SUN','MOON','D1','D2','D3','D4','D5','D7','D8','D9','D10','D12','D16','D20','D24','D27','D30','D40','D45','D60'];
			
			if ($data['user_id'] != 0) 
			{
				//$this->db->insert("cronjob_history",array("cron_job_name"=>$data['name'].'/'.$data['lat_long_address']));
				if (isset($data['date'])) 
				{
					$date = $data['date'];
				}
				else
				{
					$date = '';
				}
				if (isset($data['month'])) 
				{
					$month = $data['month'];
				}
				else
				{
					$month = '';
				}
				if (isset($data['year'])) 
				{
					$year = $data['year'];
				}
				else
				{
					$year = '';
				}

				if (isset($data['hour'])) 
				{
					$hour = $data['hour'];
				}
				else
				{
					$hour = '';
				}

				if (isset($data['minute'])) 
				{
					$minute = $data['minute'];
				}
				else
				{
					$minute = '';
				}

				if (isset($data['timezone'])) 
				{
					$timezone = $data['timezone'];
				}
				else
				{
					$timezone = '';
				}

				if (isset($data['latitude'])) 
				{
					$latitude = $data['latitude'];
				}
				else
				{
					$latitude = '';
				}

				if (isset($data['longitude'])) 
				{
					$longitude = $data['longitude'];
				}
				else
				{
					$longitude = '';
				}

				if (isset($data['lat_long_address'])) 
				{
					$lat_long_address_insert = $data['lat_long_address'];
				}
				else
				{
					$lat_long_address_insert = '';
				}

				if (isset($data['name'])) 
				{
					$name_insert = $data['name'];
					//$this->db->insert("cronjob_history",array("cron_job_name"=>$name_insert.'/'.$lat_long_address_insert));
				}
				else
				{
					$name_insert = '';
					$data['name'] = '';

				}

				if ($data['api-condition'] == 'match_ashtakoot_points' || $data['api-condition'] == 'match_birth_details' || $data['api-condition'] == 'match_astro_details' || $data['api-condition'] == 'match_dashakoot_points' || $data['api-condition'] == 'match_manglik_report' || $data['api-condition'] == 'match_making_report' || $data['api-condition'] == 'match_horoscope') 
				{
					# code...
				}
				else
				{
					$check_u_data = $this->db->get_where("user_saved_rashi",array("user_id"=>$data['user_id'],"date"=>$date,"month"=>$month,"year"=>$year,"hour"=>$hour,"minute"=>$minute,"timezone"=>$timezone),1)->row();
					// print_r($check_u_data); die;
					if (count($check_u_data) > 0) 
					{
					 
					}
					else
					{
						if ($date !== '' && $month !== '' && $year !== '' && $data['user_id'] !== '') 
						{
							$insert_array = array(	
												"name"=>$name_insert,
												"user_id"=>$data['user_id'],
												"date"=>$date,
												"month"=>$month,
												"year"=>$year,
												"hour"=>$hour,
												"minute"=>$minute, 
												"latitude"=>$latitude,
												"longitude"=>$longitude,
												"lat_long_address"=>$lat_long_address_insert,
												"timezone"=>$timezone,
												"added_on"=>date('Y-m-d H:i:s'));
							$this->db->insert('user_saved_rashi',$insert_array);		
						}
					}
				}	
			
			}
			else
			{
				if (isset($data['name'])) 
				{
					
				}
				else
				{
					$data['name'] = '';
				}
			}
			 

			switch ($data['api-condition']) 
			{
				case 'basic_detail':
					$this->basic_detail($userId,$apiKey,$data);
					break;

				case 'basic_panchang':
					$this->basic_panchang($userId,$apiKey,$data);
					break;

				case 'advanced_panchang':
					$this->advanced_panchang($userId,$apiKey,$data);
					break;

				case 'astro_detail':
					$this->astro_detail($userId,$apiKey,$data);
					break;

				case 'charts':
					$this->charts($userId,$apiKey,$data);
					break;

				/* Match Making api girl boy*/
				case 'match_birth_details':
					$this->match_making_common_fun($userId,$apiKey,$data,'matchBirthDetails');
					break;

				case 'match_astro_details':
					$this->match_making_common_fun($userId,$apiKey,$data,'matchAstroDetails');
					break;

				case 'match_dashakoot_points':
					$this->match_making_common_fun($userId,$apiKey,$data,'matchDashakootPoints');
					break;

				case 'match_manglik_report':
					$this->match_making_common_fun($userId,$apiKey,$data,'getMatchManglikReport');
					break;

				case 'match_making_report':
					$this->match_making_common_fun($userId,$apiKey,$data,'getMatchMakingReport');
					break;

				case 'match_rajju_dosha':
					$this->match_making_common_fun($userId,$apiKey,$data,'get_match_rajju_dosha');
					break;

				case 'match_horoscope':
					$this->match_making_common_fun2($userId,$apiKey,$data,'getmatch_horoscope');
					break;

				case 'papasamyam_details':
					$this->match_papasamyam_details($userId,$apiKey,$data);
					break;

				case 'match_making_detailed_report':
					$this->match_making_common_fun($userId,$apiKey,$data,'getmatch_making_detailed_report');
					break;

				case 'match_ashtakoot_points':
					$this->match_ashtakoot_points($userId,$apiKey,$data);
					break;

				case 'horo_chart_image':
					$this->horo_chart_image($userId,$apiKey,$data);
					break;

				case 'sarvashtak':
					$this->sarvashtak($userId,$apiKey,$data);
					break;

				/*numerology*/
				case 'numero_table':
					$this->numero_table($userId,$apiKey,$data);
					break;

				case 'numero_report':
					$this->numero_report($userId,$apiKey,$data);
					break;

				case 'numero_fav_time':
					$this->numero_fav_time($userId,$apiKey,$data);
					break;

				case 'numero_place_vastu':
					$this->numero_place_vastu($userId,$apiKey,$data);
					break;

				case 'numero_fasts_report':
					$this->numero_fasts_report($userId,$apiKey,$data);
					break;

				case 'numero_fav_lord':
					$this->numero_fav_lord($userId,$apiKey,$data);
					break;

				case 'numero_fav_mantra':
					$this->numero_fav_mantra($userId,$apiKey,$data);
					break;

				case 'numero_prediction_daily':
					$this->numero_prediction_daily($userId,$apiKey,$data);
					break;

				/*end numerology*/

				/* Laal Kitab*/
				case 'lalkitab_horoscope':
					$this->lalkitab_horoscope($userId,$apiKey,$data);
					break;

				case 'lalkitab_debts':
					$this->lalkitab_debts($userId,$apiKey,$data);
					break;

				case 'lalkitab_remedies':
					$this->lalkitab_remedies($userId,$apiKey,$data);
					break;

				case 'lalkitab_houses':
					$this->lalkitab_houses($userId,$apiKey,$data);
					break;

				case 'lalkitab_planets':
					$this->lalkitab_planets($userId,$apiKey,$data);
					break;

				case 'lalkitab_reports':
					$this->lalkitab_reports($userId,$apiKey,$data);
					break;

				// sadhe sati report
				case 'sadhesati_life_details':
					$this->sadhesati_life_details($userId,$apiKey,$data);
					break;

				case 'sadhesati_current_status':
					$this->sadhesati_current_status($userId,$apiKey,$data);
					break;

				case 'sadhesati_remedies':
					$this->sadhesati_remedies($userId,$apiKey,$data);
					break;

				// Gem suggestion
				case 'basic_gem_suggestion':
					$this->basic_gem_suggestion($userId,$apiKey,$data);
					break;
					
				// ghat_chakra suggestion
				case 'ghat_chakra':
					$this->ghat_chakra($userId,$apiKey,$data);
					break;

				// chaughadive suggestion
				case 'getChaughadiyaMuhurta':
					$this->getChaughadiyaMuhurta($userId,$apiKey,$data);
					break;


				// Vimshottari Module
				case 'current_vdasha_all':
					$this->current_vdasha_all($userId,$apiKey,$data);
					break;	

				case 'current_vdasha':
					$this->current_vdasha($userId,$apiKey,$data);
					break;	

				case 'major_vdasha':
					$this->major_vdasha($userId,$apiKey,$data);
					break;

				case 'sub_vdasha':
					$this->sub_vdasha($userId,$apiKey,$data);
					break;

				// chardasha Module
				case 'current_chardasha':
					$this->current_chardasha($userId,$apiKey,$data);
					break;	

				case 'major_chardasha':
					$this->major_chardasha($userId,$apiKey,$data);
					break;
					


				//Basic Yogini Dasha/major_yogini_dasha
				case 'sub_yogini_dasha':
					$this->sub_yogini_dasha($userId,$apiKey,$data);
					break;

				case 'major_yogini_dasha':
					$this->major_yogini_dasha($userId,$apiKey,$data);
					break;

				case 'current_yogini_dasha':
					$this->current_yogini_dasha($userId,$apiKey,$data);
					break;

				/* Varshpal (Yealry Prediction) */
				// Varshphal Details
				case 'varshaphal_details':
					$this->varshaphal($userId,$apiKey,$data,'varshaphal_details');
					break;

				// Varshphal Yearly Chart

				case 'varshaphal_year_chart':
					$this->varshaphal_year_chart($userId,$apiKey,$data,'varshaphal_year_chart');
					break;


				// Varshphal planets
				case 'varshaphal_planets':
					$this->varshaphal_on_demand($userId,$apiKey,$data,'varshaphal_planets');
					break;	

				// Varshphal Monthly Chart

				// Varshphal varshaphal_panchavargeeya_bala
				case 'varshaphal_panchavargeeya_bala':
					$this->varshaphal_on_demand($userId,$apiKey,$data,'varshaphal_panchavargeeya_bala');
					break;	

				// Varshphal varshaphal_harsha_bala
				case 'varshaphal_harsha_bala':
					$this->varshaphal_on_demand($userId,$apiKey,$data,'varshaphal_harsha_bala');
					break;	

				// Varshphal varshaphal_saham_points
				case 'varshaphal_saham_points':
					$this->varshaphal_on_demand($userId,$apiKey,$data,'varshaphal_saham_points');
					break;	


				/* End Varshphal Api;s*/


				/* Kp system api's*/

				// Kp system kp_planets
				case 'kp_planets':
					$this->kpsystem($userId,$apiKey,$data,'kp_planets');
					break;	

				// Kp kp_house_cusps
				case 'kp_house_cusps':
					$this->kpsystem($userId,$apiKey,$data,'kp_house_cusps');
					break;

				// Kp kp_planet_significator
				case 'kp_planet_significator':
					$this->kpsystem($userId,$apiKey,$data,'kp_planet_significator');
					break;	

				// Kp kp_planet_significator
				case 'kp_house_significator':
					$this->kpsystem($userId,$apiKey,$data,'kp_house_significator');
					break;	

				// Kp kp_planet_significator
				case 'kp_horoscope':
					$this->kpsystem($userId,$apiKey,$data,'kp_horoscope');
					break;	

				//Planetary positions
				case 'planets':
					$this->planets_position($userId,$apiKey,$data);
					break;

				//Jaimini API/jaimini_details
				case 'jaimini_details':
					$this->jaimini_details($userId,$apiKey,$data);
					break;

				//bhav_madhya
				case 'bhav_madhya':
					$this->bhav_madhya($userId,$apiKey,$data);
					break;

				//bhav_madhya
				case 'planet_ashtakavarga':
					$this->planet_ashtakavarga($userId,$apiKey,$data);
					break;

				//kalsarpa_details
				case 'kalsarpa_details':
					$this->kalsarpa_details($userId,$apiKey,$data);
					break;

				//mangal_dosha
				case 'mangal_dosha':
					$this->mangal_dosha($userId,$apiKey,$data);
					break;

				//mangal_remedy
				case 'pitra_dosha_report':
					$this->pitra_dosha_report($userId,$apiKey,$data);
					break;

				// Predictions
				case 'daily_nakshatra_prediction':
					$this->daily_nakshatra_prediction($userId,$apiKey,$data,'daily_nakshatra_prediction');
					break;

				//next day
				case 'daily_nakshatra_prediction_next':
					$this->daily_nakshatra_prediction($userId,$apiKey,$data,'daily_nakshatra_prediction/next');
					break;

				//prev day
				case 'daily_nakshatra_prediction_previous':
					$this->daily_nakshatra_prediction($userId,$apiKey,$data,'daily_nakshatra_prediction/previous');
					break;
				//biorytham day
				case 'biorhythm':
					$this->daily_nakshatra_prediction($userId,$apiKey,$data,'biorhythm');
					break;

				//Rudraksha Suggestion/rudraksha_suggestion
				case 'rudraksha_suggestion':
					$this->rudraksha_suggestion($userId,$apiKey,$data,'rudraksha_suggestion');
					break;

				//General Reports/general_house_report/:planet_name
				case 'general_house_report':
					$this->life_report($userId,$apiKey,$data,'general_house_report');
					break;

				case 'general_rashi_report':
					$this->life_report($userId,$apiKey,$data,'general_rashi_report');
					break;

				case 'general_ascendant_report':
					$this->life_report($userId,$apiKey,$data,'general_ascendant_report');
					break;

				case 'general_nakshatra_report':
					$this->life_report($userId,$apiKey,$data,'general_nakshatra_report');
					break;

				case 'planet_nature':
					$this->life_report($userId,$apiKey,$data,'planet_nature');
					break;

				case 'moon_biorhythm':
					$this->life_report($userId,$apiKey,$data,'moon_biorhythm');
					break;

				case 'personality_report':
					$this->life_report($userId,$apiKey,$data,'personality_report');
					break;


				default:
					$this->fail();
					break;
			}
			
		}
	}


	/*Basic Detail*/
	private function basic_detail($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getBirthDetails($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key($responseData,$data['name']);
	}

	/*Basic Panchang*/
	private function basic_panchang($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getBasicPanchang($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key($responseData);
	}
	/*Advanced Panchang*/
	private function advanced_panchang($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getAdvancedPanchang($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key($responseData);
	}

	/*Astro Detail*/
	private function astro_detail($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getAstroDetails($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key($responseData);
	}

	private function charts($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData22 = $vedicRishi->getHoroChartById($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'], $data['chart_id']);
		$this->check_status_key_inmultiple($responseData22);
	}

	private function match_papasamyam_details($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData22 = $vedicRishi->getmpapasamyam_details($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'], $data['gender']);
		$this->check_status_key_inmultiple($responseData22);
	}

	private function match_ashtakoot_points($userId,$apiKey,$data)
	{
		$mdata = array(	'date' => $data['m_date'],
					    'month' => $data['m_month'],
					    'year' => $data['m_year'],
					    'hour' => $data['m_hour'],
					    'minute' => $data['m_minute'],
					    'latitude' => $data['m_latitude'],
					    'longitude' => $data['m_longitude'],
					    'timezone' => $data['m_timezone']
					);
		$femaleData = array(

						    'date' => $data['f_date'],
						    'month' => $data['f_month'],
						    'year' => $data['f_year'],
						    'hour' => $data['f_hour'],
						    'minute' => $data['f_minute'],
						    'latitude' => $data['f_latitude'],
						    'longitude' => $data['f_longitude'],
						    'timezone' => $data['f_timezone']
						);
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$res1 = $vedicRishi->matchAshtakootPoints($mdata, $femaleData);
		$this->check_status_key_match_making($res1,$data['b_name'],$data['f_name']);
	}

	private function match_making_common_fun($userId,$apiKey,$data,$condition)
	{

		$mdata = array(	'date' => $data['m_date'],
					    'month' => $data['m_month'],
					    'year' => $data['m_year'],
					    'hour' => $data['m_hour'],
					    'minute' => $data['m_minute'],
					    'latitude' => $data['m_latitude'],
					    'longitude' => $data['m_longitude'],
					    'timezone' => $data['m_timezone']
					);
		$femaleData = array(

						    'date' => $data['f_date'],
						    'month' => $data['f_month'],
						    'year' => $data['f_year'],
						    'hour' => $data['f_hour'],
						    'minute' => $data['f_minute'],
						    'latitude' => $data['f_latitude'],
						    'longitude' => $data['f_longitude'],
						    'timezone' => $data['f_timezone']
						);
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		switch ($condition) {
			case 'matchBirthDetails':
				$res1 = $vedicRishi->matchBirthDetails($mdata, $femaleData);
				$this->check_status_key_match_making($res1,$data['boy_name'],$data['girl_name']);
				break;

			case 'matchAstroDetails':
				$res1 = $vedicRishi->matchAstroDetails($mdata, $femaleData);
				$this->check_status_key_match_making($res1,$data['boy_name'],$data['girl_name']);
				break;

			case 'matchDashakootPoints':
				$res1 = $vedicRishi->matchDashakootPoints($mdata, $femaleData);
				$this->check_status_key_match_making($res1,$data['boy_name'],$data['girl_name']);
				break;

			case 'getMatchManglikReport':
				$res1 = $vedicRishi->getMatchManglikReport($mdata, $femaleData);
				$this->check_status_key_match_making($res1,$data['boy_name'],$data['girl_name']);
				break;

			case 'getMatchMakingReport':
				$res1 = $vedicRishi->getMatchMakingReport($mdata, $femaleData);
				$this->check_status_key_match_making($res1,$data['boy_name'],$data['girl_name']);
				break;

			case 'get_match_rajju_dosha':
				$res1 = $vedicRishi->getMatchMakingReport($mdata, $femaleData);
				$this->check_status_key_match_making($res1,$data['boy_name'],$data['girl_name']);
				break;

			case 'getmatch_making_detailed_report':
				$res1 = $vedicRishi->getmatch_making_detailed_report($mdata, $femaleData);
				$this->check_status_key_match_making($res1,$data['boy_name'],$data['girl_name']);
				break;
			
			default:
				# code...
				break;
		}
	}

	private function match_making_common_fun2($userId,$apiKey,$data,$condition)
	{

		$mdata = array(	'date' => $data['m_date'],
					    'month' => $data['m_month'],
					    'year' => $data['m_year'],
					    'hour' => $data['m_hour'],
					    'minute' => $data['m_minute'],
					    'latitude' => $data['m_latitude'],
					    'longitude' => $data['m_longitude'],
					    'timezone' => $data['m_timezone']
					);
		$femaleData = array(

						    'date' => $data['f_date'],
						    'month' => $data['f_month'],
						    'year' => $data['f_year'],
						    'hour' => $data['f_hour'],
						    'minute' => $data['f_minute'],
						    'latitude' => $data['f_latitude'],
						    'longitude' => $data['f_longitude'],
						    'timezone' => $data['f_timezone'],
						    'match_method' => $data['match_method'],
						    'manglik_regional_setting' => $data['manglik_regional_setting']
						);
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		switch ($condition) {
			case 'getmatch_horoscope':
				$res1 = $vedicRishi->getmatch_horoscope($mdata, $femaleData);
				$this->check_status_key_match_making($res1,$data['boy_name'],$data['girl_name']);
				break;

			default:
				# code...
				break;
		}
	}


	private function check_status_key($responseData,$name = '')
	{
		$r = json_decode($responseData);
		if (is_array($r) && array_key_exists('status', $r)) 
		{
		  	echo $responseData;
		}
		else
		{
			$r->status = true;
			$r->uname = $name;
			echo json_encode($r);
		}
	}

	private function check_status_key_inmultiple($responseData2)
	{
		$r = json_decode($responseData2);
		if (is_array($r) && array_key_exists('status', $r)) 
		{
		  	echo $responseData2;
		}
		else
		{
			$response = array("status"=>true,"responseData"=>$r);
			echo json_encode($response);
		}
	}

	private function check_status_key_match_making($responseData2,$m_name,$f_name)
	{
		$r = json_decode($responseData2);
		if (array_key_exists('status', $r)) 
		{
		  	echo $responseData2;
		}
		else
		{
			$response = array("status"=>true,"responseData"=>$r,"male_name"=>$m_name,"female_name"=>$f_name);
			echo json_encode($response);
		}
	}

	private function horo_chart_image($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData22 = $vedicRishi->getExtendedHoroChartImageById($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'], $data['chart_id'],$data['chartType']);
		// print_r($responseData22);
		if ($this->isJson($responseData22) == 1) 
		{
			$this->check_status_key_inmultiple($responseData22);
		}
		else
		{
			$this->make_it_json($responseData22);
		}
	}

	private function make_it_json($value)
	{
		$t = explode('"<sv', $value);
		if (count($t) > 0) 
		{
			$t2 = explode('/svg>"', $t[1]);
			if (count($t2) > 0) 
			{
				$str1 = "<sv".$t2[0]."/svg>";
				$str = preg_replace('/\\\"/',"\"", $str1);
				$svg = array("svg"=>$str);
				$res = array("status"=>true,"responseData"=>$svg);
			}
			else
			{
				$res = array("status"=>false,"msg"=>"not_found");
			}
		}
		else
		{
			$res = array("status"=>false,"msg"=>"not_found");
		}
		echo json_encode($res, JSON_UNESCAPED_SLASHES);
	}

	/*Ashtakvarga*/
	private function sarvashtak($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getSarvashtakDetails($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key($responseData);
	}

	/*Numerology*/
	private function numero_table($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getNumeroTable($data['date'], $data['month'], $data['year'], $data['name']);
		$this->check_status_key($responseData);
	}

	private function numero_report($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getNumeroReport($data['date'], $data['month'], $data['year'], $data['name']);
		$this->check_status_key($responseData);
	}

	private function numero_fav_time($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getNumeroFavTime($data['date'], $data['month'], $data['year'], $data['name']);
		$this->check_status_key($responseData);
	}

	private function numero_place_vastu($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getNumeroPlaceVastu($data['date'], $data['month'], $data['year'], $data['name']);
		$this->check_status_key($responseData);
	}

	private function numero_fasts_report($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getNumeroFastsReport($data['date'], $data['month'], $data['year'], $data['name']);
		$this->check_status_key($responseData);
	}

	private function numero_fav_lord($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getNumeroFavLord($data['date'], $data['month'], $data['year'], $data['name']);
		$this->check_status_key($responseData);
	}

	private function numero_fav_mantra($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getNumeroFavMantra($data['date'], $data['month'], $data['year'], $data['name']);
		$this->check_status_key($responseData);
	}

	private function numero_prediction_daily($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getNumerodaily($data['date'], $data['month'], $data['year'], $data['name']);
		$this->check_status_key($responseData);
	}

	/* end of numerology */


	private function lalkitab_horoscope($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getLaalKitabchat($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['chartType']);
		$this->check_status_key_inmultiple($responseData);
	}

	public function laalkitaab_chart()
	{
		$userId = "616664";
		$apiKey = "a5d2bc019b2fb1f31d99417fa4e5099e";
		$user_id=$this->input->post("user_id");
		$date=$this->input->post("date");
		$month=$this->input->post("month");
		$year=$this->input->post("year");
		$hour=$this->input->post("hour");
		$minute=$this->input->post("minute");
		$latitude=$this->input->post("latitude");
		$longitude=$this->input->post("longitude");
		$timezone=$this->input->post("timezone");
		$width=$this->input->post("width");
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$lang = $this->input->post("lang");
		$chartType = $this->input->post("chartType");
		// $user_id=1;
		// $date=1;
		// $month=1;
		// $year=2001;
		// $hour=11;
		// $minute=11;
		// $latitude=11.11;
		// $longitude=56.33223;
		// $timezone=1.1;
		// $varshaphal_year=2020;
		// $width=100;
		// $lang ='en';
		// $chartType ='south';

		$vedicRishi->setLanguage($lang);
		$responseData = $vedicRishi->getLaalKitabchat($date,$month,$year,$hour,$minute,$latitude,$longitude,$timezone,$chartType);
		$r = json_decode($responseData,true);
		if (array_key_exists('status', $r)) 
		{
		  	echo '';
		}
		else
		{
			$this->data['chartType'] = $chartType;
			$this->data['responso'] = $r;
			$this->data['width'] = 200;
			$this->load->view('thirdpartyapichartfolder/index3',$this->data);
		}
	}

	private function lalkitab_debts($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getLaalKitabdebts($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function lalkitab_remedies($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getLaalKitabremedies($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['planet_name']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function lalkitab_houses($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getlalkitab_houses($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function lalkitab_reports($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getlalkitab_reports($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function lalkitab_planets($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getlalkitab_planets($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function sadhesati_life_details($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getSadesati($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function sadhesati_current_status($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getSadesati_current($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function sadhesati_remedies($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getSadhesatiRemedies($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function basic_gem_suggestion($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getBasic_gem_suggestion($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	public function ghat_chakra($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->ghat_chakra($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['gender']);
		$this->check_status_key_inmultiple($responseData);
	}

	public function getChaughadiyaMuhurta($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getChaughadiyaMuhurta($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['gender']);
		$this->check_status_key_inmultiple($responseData);
	}

	public function current_vdasha_all($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getCurrentVimDashaAll($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['gender']);
		$this->check_status_key_inmultiple($responseData);
	}

	public function major_vdasha($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getMajorVimDasha($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['gender']);
		$this->check_status_key_inmultiple($responseData);
	}

	public function current_vdasha($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getCurrentVimDasha($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['gender']);
		$this->check_status_key_inmultiple($responseData);
	}

	public function sub_vdasha($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getSubVimDashaDate($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['gender'],$data['sub']);
		$this->check_status_key_inmultiple($responseData);
	}


	public function sub_yogini_dasha($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getSubYoginiDasha($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['gender'],$data['sub']);
		$this->check_status_key_inmultiple($responseData);
	}

	public function major_yogini_dasha($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getMajorYoginiDasha($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	public function current_yogini_dasha($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getCurrentYoginiDasha($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	public function major_chardasha($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getMajorCharDasha($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	public function current_chardasha($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getCurrentCharDasha($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	public function varshaphal($userId,$apiKey,$data,$resourceName)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->varshaphal_details_text($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['varshaphal_year']);
		$this->check_status_key_inmultiple($responseData);
	}

	public function varshaphal_on_demand($userId,$apiKey,$data,$resourceName)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->varshaphal_on_demand($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['varshaphal_year'],$resourceName);
		$this->check_status_key_inmultiple($responseData);
	}

	

	public function kpsystem($userId,$apiKey,$data,$resourceName)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->kpsystem_details($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$resourceName);
		$this->check_status_key_inmultiple($responseData);
	}

	public function varshaphal_year_chart()
	{
		// $data_ = $this->input->post("user_id").'||'.$this->input->post("date").'||'.$this->input->post("month").'||'.$this->input->post("year").'||'.$this->input->post("hour").'||'.$this->input->post("minute").'||'.$this->input->post("latitude").'||'.$this->input->post("longitude").'||'.$this->input->post("timezone").'||'.$this->input->post("varshaphal_year").'||'.$this->input->post("width");
		// $array = array("name"=>$data_);
		// $this->db->insert("test_cul",$array);
		$userId = "616664";
		$apiKey = "a5d2bc019b2fb1f31d99417fa4e5099e";
		$resourceName = "varshaphal_year_chart";
		$user_id=$this->input->post("user_id");
		//$lang=en;
		$date=$this->input->post("date");
		$month=$this->input->post("month");
		$year=$this->input->post("year");
		$hour=$this->input->post("hour");
		$minute=$this->input->post("minute");
		$latitude=$this->input->post("latitude");
		$longitude=$this->input->post("longitude");
		$timezone=$this->input->post("timezone");
		$varshaphal_year=$this->input->post("varshaphal_year");
		$width=$this->input->post("width");
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$lang = $this->input->post("lang");
		$chartType = $this->input->post("chartType");
		// $user_id=1;
		// $date=1;
		// $month=1;
		// $year=2001;
		// $hour=11;
		// $minute=11;
		// $latitude=11.11;
		// $longitude=56.33223;
		// $timezone=1.1;
		// $varshaphal_year=2020;
		// $width=100;
		// $lang ='en';
		// $chartType ='south';

		$vedicRishi->setLanguage($lang);
		// $responseData = $vedicRishi->varshaphal_details($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['varshaphal_year'],$resourceName);
		$responseData = $vedicRishi->varshaphal_details($date,$month,$year,$hour,$minute,$latitude,$longitude,$timezone,$varshaphal_year,$resourceName,$chartType);
		$r = json_decode($responseData,true);
		if (is_array($r) && array_key_exists('status', $r)) 
		{
		  	echo '';
		}
		else
		{
			$this->data['responso'] = $r;
			$this->data['chartType'] = $chartType;
			$this->data['width'] = 200;
			$this->load->view('thirdpartyapichartfolder/index',$this->data);
		}
	}

	public function varshaphal_year_chart_json()
	{
		$data =json_decode(file_get_contents('php://input'), true);	
		if(isset($data) && !empty($data))
		{
			$userId = "616664";
			$apiKey = "a5d2bc019b2fb1f31d99417fa4e5099e";
			$resourceName = "varshaphal_year_chart";
			$user_id=$data["user_id"];
			//$lang=en;
			$date=$data["date"];
			$month=$data["month"];
			$year=$data["year"];
			$hour=$data["hour"];
			$minute=$data["minute"];
			$latitude=$data["latitude"];
			$longitude=$data["longitude"];
			$timezone=$data["timezone"];
			$varshaphal_year=$data["varshaphal_year"];
			$width=$data["width"];
			$this->load->library('astrosdk');
			$vedicRishi = new VedicRishiClient($userId, $apiKey);
			$lang = $data["lang"];
			$vedicRishi->setLanguage($lang);
			// $responseData = $vedicRishi->varshaphal_details($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['varshaphal_year'],$resourceName);
			$responseData = $vedicRishi->varshaphal_details($date,$month,$year,$hour,$minute,$latitude,$longitude,$timezone,$varshaphal_year,$resourceName);
			$r = json_decode($responseData,true);
			if (array_key_exists('status', $r)) 
			{
			  	echo '';
			}
			else
			{
				$this->data['responso'] = $r;
				$this->data['width'] = 200;
				$this->load->view('thirdpartyapichartfolder/index',$this->data);
			}
		}
	}

	public function varshaphal_month_chart()
	{
		$userId = "616664";
		$apiKey = "a5d2bc019b2fb1f31d99417fa4e5099e";
		$resourceName = "varshaphal_month_chart";
		$user_id=$this->input->post("user_id");
		$date=$this->input->post("date");
		$month=$this->input->post("month");
		$year=$this->input->post("year");
		$hour=$this->input->post("hour");
		$minute=$this->input->post("minute");
		$latitude=$this->input->post("latitude");
		$longitude=$this->input->post("longitude");
		$timezone=$this->input->post("timezone");
		$varshaphal_year=$this->input->post("varshaphal_year");
		$width=$this->input->post("width");
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$lang = $this->input->post("lang");
		$chartType = $this->input->post("chartType");
		// $user_id=1;
		// $date=1;
		// $month=1;
		// $year=2001;
		// $hour=11;
		// $minute=11;
		// $latitude=11.11;
		// $longitude=56.33223;
		// $timezone=1.1;
		// $varshaphal_year=2020;
		// $width=100;
		// $lang ='en';
		// $chartType ='north';
		$vedicRishi->setLanguage($lang);
		$responseData = $vedicRishi->varshaphal_details($date,$month,$year,$hour,$minute,$latitude,$longitude,$timezone,$varshaphal_year,$resourceName,$chartType);
		$r = json_decode($responseData,true);
		if (is_array($r) && array_key_exists('status', $r)) 
		{
		  	echo '';
		}
		else
		{
			$this->data['responso'] = $r;
			$this->data['chartType'] = $chartType;
			$this->data['width'] = 200;
			$this->load->view('thirdpartyapichartfolder/index2',$this->data);
		}
	}

	public function varshaphal_month_chart_json()
	{
		$data =json_decode(file_get_contents('php://input'), true);	
		if(isset($data) && !empty($data))
		{
			$userId = "616664";
			$apiKey = "a5d2bc019b2fb1f31d99417fa4e5099e";
			$resourceName = "varshaphal_month_chart";
			$user_id=$data["user_id"];
			$date=$data["date"];
			$month=$data["month"];
			$year=$data["year"];
			$hour=$data["hour"];
			$minute=$data["minute"];
			$latitude=$data["latitude"];
			$longitude=$data["longitude"];
			$timezone=$data["timezone"];
			$varshaphal_year=$data["varshaphal_year"];
			$width=$data["width"];
			$this->load->library('astrosdk');
			$vedicRishi = new VedicRishiClient($userId, $apiKey);
			$lang = $data['lang'];
			$vedicRishi->setLanguage($lang);
			$responseData = $vedicRishi->varshaphal_details($date,$month,$year,$hour,$minute,$latitude,$longitude,$timezone,$varshaphal_year,$resourceName);
			$r = json_decode($responseData,true);
			if (array_key_exists('status', $r)) 
			{
			  	echo '';
			}
			else
			{
				$this->data['responso'] = $r;
				$this->data['width'] = 200;
				$this->load->view('thirdpartyapichartfolder/index2',$this->data);
			}
		}
	}

	private function planets_position($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getPlanetsDetails($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function jaimini_details($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getJaminiDetails($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function bhav_madhya($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getBhavmadhya($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function planet_ashtakavarga($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getAshtakvargaDetails($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['planet']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function kalsarpa_details($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getKalsarpaDetails($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function mangal_dosha($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getManglikDetails($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function pitra_dosha_report($userId,$apiKey,$data)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getPitriDoshaReport($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function daily_nakshatra_prediction($userId,$apiKey,$data,$resourceName)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getDailyNakshatraPrediction($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$resourceName);
		$this->check_status_key_inmultiple($responseData);
	}

	private function rudraksha_suggestion($userId,$apiKey,$data,$resourceName)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		$responseData = $vedicRishi->getRudrakshaSuggestion($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		$this->check_status_key_inmultiple($responseData);
	}

	private function life_report($userId,$apiKey,$data,$resourceName)
	{
		$this->load->library('astrosdk');
		$vedicRishi = new VedicRishiClient($userId, $apiKey);
		$vedicRishi->setLanguage($data['lang']);
		if ($resourceName == 'general_house_report') 
		{
			$responseData = $vedicRishi->getGeneralHouseReport($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['planetName']);
		}
		elseif ($resourceName == 'general_rashi_report') 
		{
			$responseData = $vedicRishi->getGeneralRashiReport($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone'],$data['planetName']);
		}
		elseif ($resourceName == 'general_ascendant_report') 
		{
			$responseData = $vedicRishi->getAscendantReport($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		}
		elseif ($resourceName == 'general_nakshatra_report') 
		{
			$responseData = $vedicRishi->getNakshatraReport($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		}
		elseif ($resourceName == 'planet_nature') 
		{
			$responseData = $vedicRishi->getPlanetnatureReport($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		}
		elseif ($resourceName == 'moon_biorhythm') 
		{
			$responseData = $vedicRishi->getMoonbioReport($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		}
		elseif ($resourceName == 'personality_report') 
		{
			$responseData = $vedicRishi->getpersonrepoReport($data['date'], $data['month'], $data['year'], $data['hour'], $data['minute'], $data['latitude'], $data['longitude'], $data['timezone']);
		}
		
		$this->check_status_key_inmultiple($responseData);
	}



	private function isJson($string) {
    return ((is_string($string) &&
            (is_object(json_decode($string)) ||
            is_array(json_decode($string))))) ? true : false;
	}


	public function daily_sun_sign_prediction()
	{
		$data =json_decode(file_get_contents('php://input'), true);
		if(isset($data) && !empty($data))
		{
			$userId = "616664";
			$apiKey = "a5d2bc019b2fb1f31d99417fa4e5099e";
			$this->load->library('astrosdk');
			$vedicRishi = new VedicRishiClient($userId, $apiKey);
			$vedicRishi->setLanguage($data['lang']);
			$responseData = $vedicRishi->getTodaysPrediction($data['zodiacSign'], $data['timezone']);
			$res = $this->check_status_key_inmultiple($responseData);
			print_r($res);
		}
	}

}