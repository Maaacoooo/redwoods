<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

        include APPPATH.'libraries/Moment/Moment.php';
        include APPPATH.'libraries/Moment/MomentLocale.php';
        include APPPATH.'libraries/Moment/MomentPeriodVo.php';
        include APPPATH.'libraries/Moment/MomentHelper.php';
        include APPPATH.'libraries/Moment/MomentFromVo.php';
        include APPPATH.'libraries/Moment/MomentException.php';

    /**
     * This provides an encrypted and/or unreadable data.
     * @param  String   $str    Any string to be encrypted.
     * @return String           Encrypted string. U NO SAY????
     */
    function cleancrypt($str) {

    	$crypt_str 	= crypt(md5($str), 'TrRz'); //encodes the string
    	$new_str 	= substr($crypt_str, 0, 6); //limits the string

    	return $new_str;
    }


    /**
     * Simply checks the existence of the file
     * @param  String   $file   The file path.
     * @return Boolean          Returns true if exists. U NO SAY????
     */
    function filexist($file) {

        if(file_exists($file)) {
            return TRUE;
        } else {
            return FALSE;
        }

    }


    /**
     * Removes unnecessary characters.
     * @param  [type] $str [description]
     * @return [type]      [description]
     */
    function safelink($str) {
       return preg_replace("/[^a-zA-Z]/", "", $str);
    }


    /**
     * This cleans a string to simply get the INT id 
     * @param  String   $str    the string starting with # . e.g  "#000143-- John Jones Smith"
     * @return int              the int ID. e.g     "143"
     */
    function cleanId($str) {

        sscanf($str,"#%d",$id);

        return $id;
    }

    /**
     * Returns the age. This is stupidly coded for some reasons
     * @param  String   $date   a MySQL Date format str
     * @param  String   $range  the range to be calculated
     * @return int              the Age
     */
    function getAge($age_sql, $range = NULL) {

        if (is_null($range)) {
            $range = now();
        }
        $str = "#".timespan(mysql_to_unix($age_sql . '00:00:00'), $range, 1);

        sscanf($str,"#%d",$age);

        return $age;
    }


    /**
     * Returns a pretty ID. 
     * @param  int       $str    the String to be prettified
     * @param  int       $digits the number of digits to fulfill; default is 5
     * @return Double           returns 000001 
     */
    function prettyID($str, $digits = 5) {
        return str_pad($str,$digits,"0",STR_PAD_LEFT);
    }


    /**
     * Returns a decimal form
     * @param  [type] $str [description]
     * @return [type]      [description]
     */
    function decimalize($str) {
        return sprintf("%1\$.2f", $str);
    }



    /**
     * Checks and Creates a directory from a String Request
     * @param  String   $path           the path to be created; e.g: dir1/subdir1/supersub1
     * @param  String   $upload_folder  the main upload folder
     * @return String   The path created
     */
    function checkDir($path) {

        $exp_path = explode('/', $path);

        foreach ($exp_path as $key => $value) {

            $addr[] = $value; //compile path
            $dir_path = implode('/', $addr); //glue parts

            //checks if path already exist
            if(!is_dir($dir_path)) {
                //Create a Path
                if (mkdir($dir_path)) {     
                    write_file($dir_path.'/index.html', ''); //creates an index HTML for random path access security - (Is this even the correct term?) 
                } else {               
                    return FALSE; // if error occurs
                }
            } 
        }

        return $dir_path;

    }

    /**
     * Converts Decimal into Char form
     * @param  [type] $str [description]
     * @return [type]      [description]
     */
    function num_to_char($str) {

        //The array of digits with its corresponding character
        $val_arr = array(
        '1' => 'A',
        '2' => 'B',
        '3' => 'C',
        '4' => 'D',
        '5' => 'E',
        '6' => 'F',
        '7' => 'G',
        '8' => 'H',
        '9' => 'I',
        '0' => 'J'
        );

        $num_arr = str_split(round($str));

        foreach ($num_arr as $key => $value) {
            $num_to_char[] = $val_arr[$num_arr[$key]];
        }

        return implode("", $num_to_char);

    }


    /**
     * Gets the Row ID 
     * @param  String      $str     the ID of the item. i.e    ABCD-01-01-00001 
     * @return String               the actual ROW ID          1;
     */
    function getRowID($str) {
        $str = explode("-", $str);

        if(sizeof($str) > 1) {
            sscanf($str[(sizeof($str)-1)], "%d", $result);
        } else {
            sscanf($str[0], "ITEM%d", $result);
        }

        return $result;

    }


    function moneytize($digits, $currency = NULL) {

        if(is_null($currency)) {
            $currency = APP_CURRENCY; //system defaults 
        }
        $digits = number_format($digits, 2, '.', ',');
        return $currency . ' ' . $digits;
    }

    /**
     * Converts Bootstrap Date to MySQL Date Form and vice versa
     * @param  String $str mm/dd/yy
     * @return [type]      [description]
     */
    function dateform($str) {


        if(strpbrk($str, '-')) {
            
            // yyyy-mm-dd format to dd/mm/yyyy format
            
            $date = explode('-', $str);

           //array size validation
            if(sizeof($date) != 3) {
                //returns null if not date form 
                return NULL;                
            }

            //parse to Int
            $year   = intval($date[0]);
            $month  = str_pad(intval($date[1]),2,"0",STR_PAD_LEFT);
            $day    = str_pad(intval($date[2]),2,"0",STR_PAD_LEFT);

            if($year <= 0 || $month <= 0 || $day <= 0 || strlen($year) != 4 || strlen($month) != 2 || strlen($day) != 2 || !($month <= 12) || !($day <= 31)) {
                return NULL;
            }

            
            //return mm/dd/yyyy format
            return $day . '/' . $month . '/' . $year; 


        } elseif(strpbrk($str, '/')) {

           // dd/mm/yyyy format to yyyy-mm-dd format
           
           $date = explode('/', $str);

           //array size validation
            if(sizeof($date) != 3) {
                //returns null if not date form 
                return NULL;                
            }

            //parse to Int
            $year   = intval($date[2]);
            $month  = str_pad(intval($date[0]),2,"0",STR_PAD_LEFT);
            $day    = str_pad(intval($date[1]),2,"0",STR_PAD_LEFT);




            if($year <= 0 || $month <= 0 || $day <= 0 || strlen($year) != 4 || strlen($month) != 2 || strlen($day) != 2 || !($month <= 12) || !($day <= 31)) {
                return NULL;
            }

            
            //return yyyy-mm-dd format
            return $year . '-' . $month . '-' . $day; 


        } else {
            //if none date format
            return NULL;
        }
        /**
         *  
         */


    }



    /**
     * Generates a textable contact format
     * @param  [type] $str [description]
     * @return [type]      [description]
     */
    function safeContact($str) {


        $str = preg_replace('/[^0-9]/', '', $str);

        if(strlen($str)==10) {
            $str = '+63'.$str;
        } else {
            return FALSE;
        }

        return $str;
    }



    /**
     * Custom helper for payment schedules
     * @param  [type] $startdate [description]
     * @param  [type] $enddate   [description]
     * @param  [type] $amount    [description]
     * @return [type]            [description]
     */
    function getSchedules($startdate, $enddate, $amount, $moneytize = FALSE) {
    //GET Due Date with Moment //////////////////////////////////////////


                /**
                 * Gets the Median or Perios. 15 / 30
                 * @param  [type] $date [description]
                 * @return [type]       [description]
                 */
                function getPeriod($date) {
                    $date = new \Moment\Moment($date);
                    if ($date->getDay() >= 20) {
                        //15th day of next month
                        $date->addDays(15);
                        $date->startOf('month');
                        $date->addDays(14);                     
                        return $date->format('Y-m-d');
                        
                    } elseif ($date->getDay() >= 5) {
                        //fall on the 30th of this month or 29/28 feb
                        if ($date->endOf('month')->getDay() > 30) {
                            $date->subtractDays(1); //subtract 1 if 31
                            return $date->format('Y-m-d');
                        } else {
                            return $date->endOf('month')->format('Y-m-d');
                        }
                    } elseif($date->getDay() < 5) {
                        //this month's 15th
                        $date->startOf('month');
                        $date->addDays(14);                     
                        return $date->format('Y-m-d');
                    }
                }

                $dates = array();
                while($startdate < $enddate) {

                    $startdate = getPeriod($startdate); //set a new date

                    if ($startdate > $enddate) {
                        //return the end date
                        //echo $enddate;
                        $dates[] = $enddate;
                    } else {
                        //echo $startdate . '<br/>';
                        $dates[] = $startdate;
                    }
                    
                }

                $data = array();
                for ($i=0; $i < count($dates); $i++) { 
                    $val['schedule'] = $dates[$i];
                    if ($moneytize) {
                         $val['amount'] = moneytize(round($amount / count($dates), 2));                        
                    } else {
                         $val['amount'] = (round($amount / count($dates), 2));
                    }
                    $data[] = $val;
                }

        return $data;
                
  }



  function AddDays($days, $startdate = null) {
            

            $date = new \Moment\Moment($startdate);
            $date->addDays($days);

            return $date->format('Y-m-d');
  }



  /**
   * Checks if it's an img
   * @param  [type]  $img path or filename w/ extension
   * @return boolean      [description]
   */
  function isImage($img) {

     $img =  explode('.', $img);
     $count = count($img);
     $ext = $img[$count-1];

     $image_ext = array(
        'jpeg' => 'jpeg',
        'jpg' => 'jpg',
        'png' => 'png',
        'gif' => 'gif'
    );


     if (array_search($ext, $image_ext)) {
         return true;
     }
     
     return false;

  }




  


/* End of file Someclass.php */