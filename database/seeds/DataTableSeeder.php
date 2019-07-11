<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Course;
class DataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create(['name'=>'admin','email'=>'ahmed.sedemy@gmail.com','password'=> bcrypt(123456789)]);

        $data = array(
            array('code'=>'PHM011', 'name'=> "Mathematics (1)", 'work'=> 80 , 'oral'=>0  , 'exam'=>220),
            array('code'=>'PHM021', 'name'=> "Physics (1)", 'work'=> 60 , 'oral'=>60  , 'exam'=>180),
            array('code'=>'PHM031', 'name'=> "Mechanics (1)", 'work'=> 60 , 'oral'=>0  , 'exam'=>140),
            array('code'=>'PHM041', 'name'=> "Chemistry", 'work'=> 30 , 'oral'=>30  , 'exam'=>90),
            array('code'=>'CSE011', 'name'=> "Computer Technology", 'work'=> 25 , 'oral'=>0  , 'exam'=>50),
            array('code'=>'MDP021', 'name'=> "Engineering Drawing & Projection", 'work'=> 100 , 'oral'=>0  , 'exam'=>150),
            array('code'=>'MDP022', 'name'=> "Production Technology & Engineering History", 'work'=> 100 , 'oral'=>35  , 'exam'=>40),
            array('code'=>'HUM099', 'name'=> "حقوق الإنسان", 'work'=> 0 , 'oral'=>0  , 'exam'=>50),
            array('code'=>'HUMx11', 'name'=> "Technical English Language", 'work'=> 15 , 'oral'=>0  , 'exam'=>35),
            array('code'=>'PHM111', 'name'=> "Mathematics (2)", 'work'=> 70 , 'oral'=>0  , 'exam'=>180),
        );
        
        Course::insert($data); 
        
    }
}
