<?php
namespace App\Http\Controller\Admin;

use App\Http\Controller\Common\BaseController;


class DashboardController extends BaseController
{
     public function index()
     {
         return $this->render('admin/dashboard/index.php');
     }
}