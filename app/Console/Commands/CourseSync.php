<?php

namespace App\Console\Commands;

use App\Helpers\Common;
use Illuminate\Console\Command;
use App\Courseinfo;

class CourseSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:sync';

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
        print_r("#########################################################33");
        $coursesType = json_decode(Common::curl_conn("courses?offset=0&displayLength=100&isActive=true", array()));

        if(count($coursesType) > 0){
            Type::truncate();

            foreach ($coursesType as $types) {
                $type = new Type();
                $type->type = $types->NAME;
                $type->code = $types->CODE;
                $type->delivery = $types->DELIVERY;
                $type->instance_id = $types->ID;
                $type->is_active = $types->ISACTIVE;
                $type->short_desc = $types->SHORTDESCRIPTION;
                $type->save();
                Course::where('type', $types->NAME)->update(['type_id' => $types->ID]);

            }
            $this->info('The course types were saved successfully!');
        }
        Courseinfo::truncate();
        $results = json_decode($this->curl_conn("courses?offset=0&displayLength=100", array()));
        $coursetypes = $results;

        if(count($coursetypes) > 0) {

            foreach($coursetypes as $areaid => $coursetype){
                $result = json_decode($this->curl_conn("/course/detail?ID=$coursetype->ID&type=w", array()));
                $courseInfo = new Courseinfo();
                $courseInfo->cost = $result->COST;
                $courseInfo->description = $result->DESCRIPTION;
                print_r($coursetype);
                if(strpos($coursetype->NAME, " Update")){
                    $name = str_replace(" Update", "", $coursetype->NAME);
                    $courseInfo->info_id = $coursetype->ID;
                    $courseInfo->cost  = $coursetype->COST;
                    $courseInfo->name = $name;
                } else {
                    $courseInfo->name = $coursetype->NAME;
                }

                $courseInfo->save();
            }

            $valid_courses = array(
                "Anaphylaxis","Aquatic Technical Operations","Pool Bronze Medallion","CAA - Pool Safety Summit","Community Surf Life Saving Certificate","Defibrillation","Emergency Asthma Management","Pool Lifeguard","Provide Cardio Pulmonary Resuscitation","Provide First Aid","Provide First Aid Blended","Certificate IV in Training and Assessment (TAE40110)"
            );

            $this->info('The courses info were saved successfully!');
        } else {
            $this->info('No courses info found');
        }
    }
}
