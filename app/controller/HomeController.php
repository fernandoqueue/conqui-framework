<?php
namespace App\Controller;

use Conqui\Response;
use App\Service\UserServiceProvider;
use Exception;
class HomeController extends Controller
{

    public function __construct()
    {
        $this->isAuthenticated = true;
        $this->nonAuthenticatedRoutes = [];
        $this->middleware = [\App\Middleware\Auth::class];
    }

    public function index()
    {
        if(!$this->gates->allow('view_index')){
            die('Not Authorized');
        }

        
       $data = [];
        return (new Response)->view('home/index','layout/app')
                             ->with($data)
                             ->render();
    }

    public function projects()
    {
       
                            
    }
    public function contact()
    {
       
                            
    }
}