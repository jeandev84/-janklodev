<?php
namespace App\Migration;


use Jan\Component\Database\Migration\Migration;
use Jan\Foundation\Facade\Database\Schema;
use Jan\Component\Database\Schema\BluePrint;


/**
 * Class Version20211024002333
 *
 * @package Jan\Component\Database\Migration
*/
class Version20211024002333 extends Migration
{

    /**
     * @return void
    */
    public function up()
    {
        Schema::create('news', function (BluePrint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('content');
            $table->datetime('published_at');
            // ...
        });
    }


    /**
     * @return void
    */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}