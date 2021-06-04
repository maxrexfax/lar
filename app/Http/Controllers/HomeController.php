<?php

namespace App\Http\Controllers;

use App\Mail\OrderShipped;
use App\Models\Message;
use App\Notifications\OrderCreated;
use App\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($var0 = null, $var00 = null)
    {
        if($var0){//пример работы с опциональными переменными var1, var2
        echo $var0;
        }
        if($var00){
            echo $var00;
        }
        $users = User::orderBy('last_logined_date','desc')->simplePaginate(8);

        return view('home', [
            'users' => $users,
            'cities' => City::orderBy('name','asc')->get(),
        ]);
    }

    public function test()
    {
        $images = File::allFiles('gallery/');
        return View::make('test.test', ['images' => $images]);
    }

    public function download($filename = null)
    {
        if ($filename) {
            //echo asset('storage/'.$filename);
            echo Storage::size('public/'.$filename);
            //return Storage::download('public/'.$filename);
           // Storage::copy('public/file.txt', 'public/new/file.txt');
        }
    }

    public function getUrlToFile($filename = null)
    {
        if ($filename) {
            $url = Storage::url($filename);
            return URL::to('/').$url;
        }
    }

    public function listFiles()
    {
        $allFiles = [];
        $files = File::allFiles('storage/');
        $directories = Storage::allDirectories('');
        $images = File::allFiles('gallery/');
        var_dump($directories);
        return View::make('test.test', [
            'images' => $images,
            /*'allFiles' => $allFiles*/
            'allFiles' => $files
        ]);
    }

    public function resp($incomingUrl = null)
    {
        if($incomingUrl){
            $response = Http::get('http://'.$incomingUrl);
            if($response){
                echo var_dump($response);
            } else {
                echo 'wrong url';
            }

        } else {
            echo 'empty';
        }
    }

    public function serialize($userLogin = null)
    {
        $user = null;
        echo $userLogin;
        if($userLogin){
            $user = User::where('login', $userLogin)->get();
        } else {
            $user = User::first();
        }
       //$user = User::all();
        var_dump($userLogin, $user);
        return $user->attributesToArray();
    }

    public function upload(Request $request)
    {
        $info1 = 'empty';
        $fileName = null;
        var_dump($_POST);
        //die();
        if (!empty($_FILES['file'])) {
            $fileName = time().'.'.$request->file->extension();

            $request->file->move(public_path('gallery/'), $fileName);

            /*return back()
                ->with('success','You have successfully upload file.')
                ->with('file',$fileName);*/
            $info1 = 'if worked';
        } else {
            $info1 = 'else!';
        }
        return View::make('test/upload',[
               'info' => $info1,
            'file'=> $fileName
        ]);
    }

    public function chat()
    {
        return View::make('test/chat',[

        ]);
    }


    public function sendNotification()
    {
        $message = Message::find(1);
        $details = [
            'greeting' => 'Hi Artisan',
            'body' => 'This is my first notification from ItSolutionStuff.com',
            'thanks' => 'Thank you for using ItSolutionStuff.com tuto!',
            'actionText' => 'View My Site',
            'actionURL' => url('/'),
            'order_id' => 101
        ];

        $user = User::find(1);
        $resMail = Mail::to($user)->send(new OrderShipped($message));
        //var_dump($order);
        //var_dump($user);
        echo 'resMail='; var_dump($resMail);

        $resNotification = Notification::send($message, new OrderCreated($message, $details));
        echo 'resNotification='; var_dump($resNotification);

    }
}
