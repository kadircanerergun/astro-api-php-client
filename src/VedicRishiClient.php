<?php
/**
 * Vedic Rishi Client for consuming Vedic Rishi Astro Web APIs
 * http://www.vedicrishiastro.com/astro-api/
 * Author: Chandan Tiwari
 * Date: 06/12/14
 * Time: 5:42 PM
 */
namespace KCE\AstrologyApi;

use App\Models\User\PersonalInformation;
use Carbon\Carbon;

class VedicRishiClient
{
    private $userId = null;
    private $apiKey = null;
    private $language = null;

    //TODO: MUST enable this on production- MUST
    //private $apiEndPoint = "https://api.vedicrishiastro.com/v1";

    //TODO: MUST- comment this and uncomment https url above on production for added security

    /**
     * @param $uid string userId for Vedic Rishi Astro API
     * @param $key string api key for Vedic Rishi Astro API access
     */
    public function __construct($uid, $key)
    {
        $this->userId = $uid;
        $this->apiKey = $key;
    }


    /*
    A Function to set the Language of Response.
    Just call this function and you can change the language.
    This function should be passed either 'en' for English or 'hi' for Hindi.
*/
    public function setLanguage( $language )
    {
        $this->language = $language;
    }

    private function packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        return array(
            'day' => $date,
            'month' => $month,
            'year' => $year,
            'hour' => $hour,
            'min' => $minute,
            'lat' => $latitude,
            'lon' => $longitude,
            'tzone' => $timezone,
            'name' => 'chandan'
        );
    }

    private function packageTransitPredictionData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone, $predictionTimezone)
    {
        return array(
            'day' => $date,
            'month' => $month,
            'year' => $year,
            'hour' => $hour,
            'min' => $minute,
            'lat' => $latitude,
            'lon' => $longitude,
            'tzone' => $timezone,
            'prediction_timezone' => $predictionTimezone
        );
    }

    private function packageNumeroData($date, $month, $year, $name)
    {
        return array(
            'day' => $date,
            'month' => $month,
            'year' => $year,
            'name' => $name
        );
    }

    private function packageMatchMakingData($maleBirthData, $femaleBirthData)
    {
        $mData = array(
            'm_day' => $maleBirthData['date'],
            'm_month' => $maleBirthData['month'],
            'm_year' => $maleBirthData['year'],
            'm_hour' => $maleBirthData['hour'],
            'm_min' => $maleBirthData['minute'],
            'm_lat' => $maleBirthData['latitude'],
            'm_lon' => $maleBirthData['longitude'],
            'm_tzone' => $maleBirthData['timezone']
        );
        $fData = array(
            'f_day' => $femaleBirthData['date'],
            'f_month' => $femaleBirthData['month'],
            'f_year' => $femaleBirthData['year'],
            'f_hour' => $femaleBirthData['hour'],
            'f_min' => $femaleBirthData['minute'],
            'f_lat' => $femaleBirthData['latitude'],
            'f_lon' => $femaleBirthData['longitude'],
            'f_tzone' => $femaleBirthData['timezone']
        );

        return array_merge($mData, $fData);
    }

    private function packageSunSignPredictionData($predictionTimezone)
    {
        return array (
            'timezone' => $predictionTimezone
        );
    }

    private function packageGeoData($place, $numRow)
    {
        return array(
            'place' => $place,
            'maxRows' => $numRow
        );
    }

    private function dataSanityCheck($data)
    {

    }

    /**
     * @param $resourceName string apiName name of an api without any begining and end slashes (ex 'birth_details')
     * @param $date date
     * @param $month month
     * @param $year year
     * @param $hour hour
     * @param $minute minute
     * @param $latitude latitude
     * @param $longitude longitude
     * @param $timezone timezone
     * @return array response data decoded in PHP associative array format
     */

    /**
     * @param $resourceName string apiName name of numerological api (numero_table and numero_report)
     * @param $date int date of birth
     * @param $month int month of birth
     * @param $year int year of birth
     * @param $name string name
     * @return array response data decoded in PHP associative array format
     */

    /**
     * @param $resourceName apiName name of an api along without any begining and end slashes (ex match_birth_details)
     * @param array $maleBirthData  array maleBirthdata associative array format
     * @param array $femaleBirthData array femaleBirthdata associative array format
     * @return array response data decoded in PHP associative array format
     */

    //***************************************** MATCHMAKING FUNCTIONS ****************************************************


    public function matchBirthDetails(array $maleBirthData, array $femaleBirthData)
    {
        //TODO:  needs to validate male and female birth data against expected keys
        //$this->dataSanityCheck($maleBirthData);
        //$this->dataSanityCheck($femaleBirthData);
        $resourceName = 'match_birth_details';
        $data = $this->packageMatchMakingData($maleBirthData, $femaleBirthData);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function matchPlanetDetails(array $maleBirthData, array $femaleBirthData)
    {
        //TODO:  needs to validate male and female birth data against expected keys
        //$this->dataSanityCheck($maleBirthData);
        //$this->dataSanityCheck($femaleBirthData);
        $resourceName = 'match_planet_details';
        $data = $this->packageMatchMakingData($maleBirthData, $femaleBirthData);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function matchAstroDetails(array $maleBirthData, array $femaleBirthData)
    {
        //TODO:  needs to validate male and female birth data against expected keys
        //$this->dataSanityCheck($maleBirthData);
        //$this->dataSanityCheck($femaleBirthData);
        $resourceName = 'match_astro_details';
        $data = $this->packageMatchMakingData($maleBirthData, $femaleBirthData);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function matchAshtakootPoints(array $maleBirthData, array $femaleBirthData)
    {
        //TODO:  needs to validate male and female birth data against expected keys
        //$this->dataSanityCheck($maleBirthData);
        //$this->dataSanityCheck($femaleBirthData);
        $resourceName = 'match_ashtakoot_points';
        $data = $this->packageMatchMakingData($maleBirthData, $femaleBirthData);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getMatchMakingReport(array $maleBirthData, array $femaleBirthData)
    {
        //TODO:  needs to validate male and female birth data against expected keys
        //$this->dataSanityCheck($maleBirthData);
        //$this->dataSanityCheck($femaleBirthData);
        $resourceName = 'match_making_report';
        $data = $this->packageMatchMakingData($maleBirthData, $femaleBirthData);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getMatchManglikReport(array $maleBirthData, array $femaleBirthData)
    {
        //TODO:  needs to validate male and female birth data against expected keys
        //$this->dataSanityCheck($maleBirthData);
        //$this->dataSanityCheck($femaleBirthData);
        $resourceName = 'match_manglik_report';
        $data = $this->packageMatchMakingData($maleBirthData, $femaleBirthData);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function matchObstructions(array $maleBirthData, array $femaleBirthData)
    {
        //TODO:  needs to validate male and female birth data against expected keys
        //$this->dataSanityCheck($maleBirthData);
        //$this->dataSanityCheck($femaleBirthData);
        $resourceName = 'match_obstructions';
        $data = $this->packageMatchMakingData($maleBirthData, $femaleBirthData);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getMatchSimpleReport(array $maleBirthData, array $femaleBirthData)
    {
        //TODO:  needs to validate male and female birth data against expected keys
        //$this->dataSanityCheck($maleBirthData);
        //$this->dataSanityCheck($femaleBirthData);
        $resourceName = 'match_simple_report';
        $data = $this->packageMatchMakingData($maleBirthData, $femaleBirthData);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }



    //***************************************** NUMEROLOGY FUNCTIONS ****************************************************


    public function getNumeroTable($date, $month, $year, $name)
    {
        $resourceName = 'numero_table';
        $data = $this->packageNumeroData($date, $month, $year, $name);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getNumeroReport($date, $month, $year, $name)
    {
        $resourceName = 'numero_report';
        $data = $this->packageNumeroData($date, $month, $year, $name);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getNumeroFavTime($date, $month, $year, $name)
    {
        $resourceName = 'numero_fav_time';
        $data = $this->packageNumeroData($date, $month, $year, $name);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getNumeroPlaceVastu($date, $month, $year, $name)
    {
        $resourceName = 'numero_place_vastu';
        $data = $this->packageNumeroData($date, $month, $year, $name);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getNumeroFastsReport($date, $month, $year, $name)
    {
        $resourceName = 'numero_fasts_report';
        $data = $this->packageNumeroData($date, $month, $year, $name);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getNumeroFavLord($date, $month, $year, $name)
    {
        $resourceName = 'numero_fav_lord';
        $data = $this->packageNumeroData($date, $month, $year, $name);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getNumeroFavMantra($date, $month, $year, $name)
    {
        $resourceName = 'numero_fav_mantra';
        $data = $this->packageNumeroData($date, $month, $year, $name);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    /*public function getNumeroGemSuggestion($date, $month, $year, $name)
    {
        $resourceName = 'numero_gem_suggestion';
        $data = $this->packageNumeroData($date, $month, $year, $name);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data);
        return $response;
    }*/


    //***************************************** PREDICTION FUNCTIONS ****************************************************


    public function callTransitPrediction($resourceName, $date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone,$predictionTimezone)
    {
        $data = $this->packageTransitPredictionData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone,$predictionTimezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $resData;
    }

    private function callSunSignDailyPrediction($resourceName, $predictionTimezone)
    {
        $data = $this->packageSunSignPredictionData($predictionTimezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getTodaysPrediction($zodiacSign, $timezone)
    {
        $resourceName = 'sun_sign_prediction/daily/'.$zodiacSign;
        return $this->callSunSignDailyPrediction($resourceName, $timezone);
    }

    public function getTomorrowsPrediction($zodiacSign, $timezone)
    {
        $resourceName = 'sun_sign_prediction/daily/next/'.$zodiacSign;
        return $this->callSunSignDailyPrediction($resourceName, $timezone);

    }

    public function getYesterdaysPrediction($zodiacSign, $timezone)
    {
        $resourceName = 'sun_sign_prediction/daily/previous/'.$zodiacSign;
        return $this->callSunSignDailyPrediction($resourceName, $timezone);
    }

    public function getDailyNakshatraPrediction($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'daily_nakshatra_prediction';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    //***************************************** ASTROLOGY FUNCTIONS ****************************************************


    //*****************Basic Astro****************//

    public function getBirthDetails($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'birth_details';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getAstroDetails($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'astro_details';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getPlanetsDetails($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'planets';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getPlanetsExtendedDetails($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'planets/extended';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getPlanetsTropicalDetails($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'planets/tropical';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }


    public function getGeoDetails($place, $rows)
    {
        $resourceName = 'geo_details';
        $data = $this->packageGeoData($place, $rows);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getTimezone($countryId, $isDst)
    {
        $resourceName = 'timezone';
        $data = array('country_code' => $countryId, 'isDst' => $isDst);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }


    //*****************Ashtakvarga****************//

    public function getAshtakvargaDetails($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone, $planet)
    {
        $resourceName = 'planet_ashtak/'.$planet;
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getSarvashtakDetails($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'sarvashtak';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }


    //*****************Panchang****************//

    public function getBasicPanchang($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'basic_panchang';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getPlanetPanchang($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'planet_panchang';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getBasicPanchangSunrise($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'basic_panchang/sunrise';
        $data = $this->packageHoroData($date, $month, $year, 0, 0, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getPlanetPanchangSunrise($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'planet_panchang/sunrise';
        $data = $this->packageHoroData($date, $month, $year, 0, 0, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getAdvancedPanchang($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'advanced_panchang';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getAdvancedPanchangSunrise($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'advanced_panchang/sunrise';
        $data = $this->packageHoroData($date, $month, $year, 0, 0, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getChaughadiyaMuhurta($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'chaughadiya_muhurta';
        $data = $this->packageHoroData($date, $month, $year, 0, 0, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getHoraMuhurta($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'hora_muhurta';
        $data = $this->packageHoroData($date, $month, $year, 0, 0, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }


    //*****************Vimshottari Dasha****************//

    public function getCurrentVimDasha($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'current_vdasha';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getCurrentVimDashaAll($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'current_vdasha_all';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getMajorVimDasha($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'major_vdasha';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }


    //*****************Yogini Dasha****************//

    public function getMajorYoginiDasha($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'major_yogini_dasha';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getSubYoginiDasha($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'sub_yogini_dasha';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getCurrentYoginiDasha($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'current_yogini_dasha';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }


    //*****************Char Dasha****************//

    public function getMajorCharDasha($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'major_chardasha';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getCurrentCharDasha($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'current_chardasha';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getSubCharDasha($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone, $rashiName)
    {
        $resourceName = 'sub_chardasha/'.$rashiName;
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getSubSubCharDasha($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone, $rashiName, $subRashiName)
    {
        $resourceName = 'sub_chardasha/'.$rashiName.'/'.$subRashiName;
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }


    //*****************Kalsarpa Dasha****************//

    public function getKalsarpaDetails($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'kalsarpa_details';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    /*public function getKalsarpaRemedies($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'kalsarpa_remedy';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data);
        return $response;
    }*/


    //*****************Pitri Dasha****************//

    public function getPitriDoshaReport($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'pitra_dosha_report';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }


    //*****************Sadhesati Dosha****************//

    public function getSadhesatiLifeDetails($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'sadhesati_life_details';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getSadhesatiCurrentStatus($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'sadhesati_current_status';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getSadhesatiRemedies($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'sadhesati_remedies';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }


    //*****************Manglik Dosha****************//

    public function getManglikDetails($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'manglik';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    /*public function getManglikRemedies($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'manglik_remedy';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data);
        return $response;
    }*/


    //*****************Horoscope Charts****************//


    public function getHoroChartById($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone, $chartId)
    {
        $resourceName = 'horo_chart/'.$chartId;
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getExtendedHoroChartById($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone, $chartId)
    {
        $resourceName = 'horo_chart_extended/'.$chartId;
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }


    //*****************Suggestions and Remedies****************//

    public function getBasicGemSuggestion($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'basic_gem_suggestion';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getPujaSuggestion($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'puja_suggestion';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getRudrakshaSuggestion($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'rudraksha_suggestion';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }




    //***************************************** GENERAL REPORTS FUNCTIONS ****************************************************


    public function getGeneralHouseReport($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone, $planetName)
    {
        $resourceName = 'general_house_report/'.$planetName;
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getGeneralRashiReport($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone, $planetName)
    {
        $resourceName = 'general_rashi_report/'.$planetName;
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getNakshatraReport($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone)
    {
        $resourceName = 'general_nakshatra_report';
        $data = $this->packageHoroData($date, $month, $year, $hour, $minute, $latitude, $longitude, $timezone);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }


    /*
     * Palmastrology Methods
     */
    public function getWesternHoroscope(PersonalInformation $personalInformation)
    {
        $resourceName = 'western_horoscope';
        $data = $this->personalInformationData($personalInformation);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getWheelChart(PersonalInformation $personalInformation)
    {
        $resourceName = 'wheel_chart/tropical';
        $data = $this->personalInformationData($personalInformation);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getFriendshipReport(PersonalInformation $personalInformation1, PersonalInformation $personalInformation2)
    {
        $resourceName = 'friendship_report/tropical';
        $data = $this->coupleData($personalInformation1, $personalInformation2);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getZodiacCompability($sign1, $sign2)
    {
        $resourceName = 'zodiac_compatibility/'.$sign1.'/'.$sign2;
        $data = [];
        return $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
    }

    public function getNumero(PersonalInformation $personalInformation)
    {
        $resourceName = 'numero_table';
        $data = $this->personalInformationData($personalInformation);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getLifeForecastReport(PersonalInformation $personalInformation)
    {
        $resourceName = 'life_forecast_report/tropical';
        $data = $this->personalInformationData($personalInformation);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getDailyTransits(PersonalInformation $personalInformation)
    {
        $resourceName = 'tropical_transits/daily';
        $data = $this->personalInformationData($personalInformation);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }
    public function getMonthlyTransits(PersonalInformation $personalInformation)
    {
        $resourceName = 'tropical_transits/monthly';
        $data = $this->personalInformationData($personalInformation);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }
    public function getYearlyTransits(PersonalInformation $personalInformation)
    {
        $resourceName = 'tropical_transits/yearly';
        $data = $this->personalInformationData($personalInformation);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getPersonalityReport(PersonalInformation $personalInformation)
    {
        $resourceName = 'personality_report/tropical';
        $data = $this->personalInformationData($personalInformation);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getRomanticPersonalityData(PersonalInformation $personalInformation)
    {
        $resourceName = 'romantic_personality_report/tropical';
        $data = $this->personalInformationData($personalInformation);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getGeneralSignReport(PersonalInformation $personalInformation, $planet)
    {
        $resourceName = 'general_sign_report/tropical/'.$planet;
        $data = $this->personalInformationData($personalInformation);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }


    public function getAscendantReport(PersonalInformation $personalInformation)
    {
        $resourceName = 'general_ascendant_report';
        $data = $this->personalInformationData($personalInformation);
        $response = $this->getCurlResponse($this->userId, $this->apiKey, $resourceName, $data, $this->language);
        return $response;
    }

    public function getWeklyPrediction($zodiacSign, $timezone)
    {
        $resourceName = 'horoscope_prediction/weekly/'.$zodiacSign;
        return $this->callSunSignDailyPrediction($resourceName, $timezone);
    }

    /*
     * End Palmastrology Methods
     */

    /*Timezone with DST*/
    public function timezoneWithDst( $date, $latitude, $longitude)
    {
        $data = array(
            "date" => $date,
            "latitude" => $latitude,
            "longitude" => $longitude
        );

        $resourceName = 'timezone_with_dst';


        $resData = $this->getCurlResponse($this->userId, $this->apiKey,$resourceName, $data,$this->language);
        return $resData;
    }

    private function getCurlResponse($userId, $apiKey, $resource, array $data, $language)
    {
        $apiEndPoint = "http://json.astrologyapi.com/v1";


        $serviceUrl = $apiEndPoint.'/'.$resource.'/';
        $authData = $userId.":".$apiKey;

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $serviceUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $header[] = 'Authorization: Basic '. base64_encode($authData);
        /* Setting the Language of Response */
        if( $language != NULL ) {
            array_push( $header , 'Accept-Language: ' .$language );
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    public function personalInformationData(PersonalInformation $personalInformation)
    {
        $birthDateCarbon = Carbon::parse($personalInformation->birth_date);
        return [
            'day' => $birthDateCarbon->day,
            'month' => $birthDateCarbon->month,
            'year' => $birthDateCarbon->year,
            'hour' => $birthDateCarbon->hour,
            'min' => $birthDateCarbon->minute,
            'lat' => $personalInformation->latitude,
            'lon' => $personalInformation->longitude,
            'tzone' => $personalInformation->timezone,
            'name' => $personalInformation->name_surname
        ];
    }

    private function coupleData(PersonalInformation $person1, PersonalInformation $person2, $key1="p", $key2='s')
    {

        $birthDateCarbonP = Carbon::parse($person1->birth_date);
        $mData = [
            $key1.'_'.'day' => $birthDateCarbonP->day,
            $key1.'_'.'month' => $birthDateCarbonP->month,
            $key1.'_'.'year' => $birthDateCarbonP->year,
            $key1.'_'.'hour' => $birthDateCarbonP->hour,
            $key1.'_'.'min' => $birthDateCarbonP->minute,
            $key1.'_'.'lat' => $person1->latitude,
            $key1.'_'.'lon' => $person1->longitude,
            $key1.'_'.'tzone' => $person1->timezone,
            $key1.'_'.'name' => $person1->name_surname
        ];
        $birthDateCarbonS = Carbon::parse($person2->birth_date);

        $fData = [
            $key2.'_'.'day' => $birthDateCarbonS->day,
            $key2.'_'.'month' => $birthDateCarbonS->month,
            $key2.'_'.'year' => $birthDateCarbonS->year,
            $key2.'_'.'hour' => $birthDateCarbonS->hour,
            $key2.'_'.'min' => $birthDateCarbonS->minute,
            $key2.'_'.'lat' => $person2->latitude,
            $key2.'_'.'lon' => $person2->longitude,
            $key2.'_'.'tzone' => $person2->timezone,
            $key2.'_'.'name' => $person2->name_surname
        ];
        return array_merge($mData, $fData);
    }


}