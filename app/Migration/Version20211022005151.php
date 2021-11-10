<?php
namespace App\Migration;


use Jan\Component\Database\Migration\Migration;
use Jan\Foundation\Facade\Database\Schema;
use Jan\Component\Database\Schema\BluePrint;


/**
 * Class Version20211022005151
 *
 * @package Jan\Component\Database\Migration
*/
class Version20211022005151 extends Migration
{

    /**
     * @return void
    */
    public function up()
    {
        Schema::create('users', function (BluePrint $table) {
            $table->increments('id');
            $table->string('email', 200);
            $table->string('password');
            $table->string('username'); // unique
            $table->string('surname');
            $table->string('name');
            $table->string('patronymic')->nullable();
            $table->string('region');
            $table->string('city');
            // ...
        });
    }


    /**
     * @return void
    */
    public function down()
    {
        Schema::dropIfExists('users');
    }

    /**
     * @return array
     */
    public function getAttributesToSave(): array
    {
        return [];
    }
}