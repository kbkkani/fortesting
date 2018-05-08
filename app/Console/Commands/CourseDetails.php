<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use app\Helpers\Common;
use App\Courseinfo;

class CourseDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coursedetails:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $results = json_decode(Common::curl_conn("courses?offset=0&displayLength=100", array()));
        $coursetypes = $results;

        if(count($coursetypes) > 0) {

            Courseinfo::truncate();

            $valid_courses = array(
                "Anaphylaxis","Aquatic Technical Operations","Pool Bronze Medallion","CAA - Pool Safety Summit","Community Surf Life Saving Certificate","Defibrillation","Emergency Asthma Management","Pool Lifeguard","Provide Cardio Pulmonary Resuscitation","Provide First Aid","Provide First Aid Blended","Certificate IV in Training and Assessment (TAE40110)"
            );

            $sorted_courses = array();

            foreach($coursetypes as $coursetype){
                $result = json_decode(Common::curl_conn("/course/detail?ID=$coursetype->ID&type=w", array()));
                if(in_array($coursetype->NAME, $valid_courses)) {
                    if(array_key_exists("COST",$result) && $result->COST != ""){
                        $coursetype->COST = $result->COST;
                    }
                    if(array_key_exists("DESCRIPTION",$result) && $result->DESCRIPTION != ""){
                        $coursetype->DESCRIPTION = $result->DESCRIPTION;
                    }
                    if(array_key_exists("SHORTDESCRIPTION",$coursetype) && $coursetype->SHORTDESCRIPTION != ""){
                        $sorted_courses[$coursetype->NAME] = $coursetype;
                    }
                } else {
                    if(strpos($coursetype->NAME, " Update")) {
                            $name = str_replace(" Update", "", $coursetype->NAME);
                            if(array_key_exists(trim($name),$sorted_courses) ){
                                if(array_key_exists('COST',$result)){
                                    $sorted_courses[trim($name)]->UPDATE_COST = $result->COST;
                                }
                                if(array_key_exists('ID',$result)){
                                    $sorted_courses[trim($name)]->UPDATE_ID = $result->ID;
                                }
                            }
                    }
                }
            }
            print_r($sorted_courses);
            foreach ($sorted_courses as $name=>$course){
                $courseInfo = new Courseinfo();
                $courseInfo->name = $name;
                if(array_key_exists("SHORTDESCRIPTION",$coursetype)){
                    $courseInfo->short_description = $course->SHORTDESCRIPTION;
                }
                if(array_key_exists("UPDATE_COST",$course)){
                    $courseInfo->update_cost = $course->UPDATE_COST;
                }
                if(array_key_exists("COST",$course)){
                    $courseInfo->cost = $course->COST;
                }
                if(array_key_exists("ID",$course)){
                    $courseInfo->info_id = $course->ID;
                }
                if(array_key_exists("UPDATE_ID",$course)){
                    $courseInfo->type_id = $course->UPDATE_ID;
                }

                $courseInfo->save();
            }

            $this->info('The courses info were saved successfully!');
        } else {
            $this->info('No courses info found');
        }
    }
}
