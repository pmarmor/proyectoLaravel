<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (!auth()->user() && Cookie::get('remember_me')){
        $rememberToken=Cookie::get('remember_me');
    $userId=   DB::table('users')->where('remember_token', $rememberToken)->value('id');
    auth()->loginUsingId($userId);
    }
    $games = DB::table('games')
        ->select('games.*','users.id','users.username')
        ->join('users','users.id','=','games.idUser')->get();
    return view('welcome',['games'=>$games]);})->name('home');
Route::view('/ayuda','ayuda')->name('ayuda');
Route::view('/acercaDe','acercade')->name('acercade');
/**
 * Login y logout
 */
Route::get('/login', function () {return view('login');})->name("login");
Route::post('/login', [userController::class,'login'])->name("login");
Route::get('/logout', [userController::class,'logout'])->name('logout');
/**
 * Formulario de registro
 */
Route::post('/register', [userController::class,'register'])->name('register');
Route::get('/register', function (){return view('register');})->name('register');
/**
 *
 */
//Route::view('/miPerfil', 'userPage')->name("miPerfil");
/**
 * Panel de control
 */
Route::get('/controlPanel', function () {
    $usuarios = User::paginate(10);
    return view('controlPanel', ['usuarios' => $usuarios]);})->name("controlPanel");
Route::get('/controlPanel/deleteUser/{userId}', [userController::class,"deleteUser"])->name("deleteUser");
Route::post ('/controlPanel/banUser', [userController::class,"banUser"])->name("banUser");
Route::post ('/controlPanel/removeBan', [userController::class,"removeBan"])->name("removeBan");
Route::get('/controlPanel/toggleAdmin/{userId}', [userController::class,"toggleAdmin"])->name("toggleAdmin");
/**
 * Pagina de usuario
 */
Route::get('/userPage/{userId}', function ($userId) {
    $userProfile = User::find($userId);
    $followers=DB::table('follows')->where('userFollowed_id', $userId)->count();
    $uploadedGames=DB::table('games')->where('idUser', $userId)->get();
    $follows=DB::table('follows')->where('userFollows_id', $userId)->count();
    return view('userPage', ['profileUser' => $userProfile, 'followers'=>$followers,'follows'=>$follows,
        'uploadedGames'=>$uploadedGames->all()]);})->name("profilePage");
Route::post('/userPage/handleFollow', [userController::class,"toggleFollow"])->name("handleFollow");
Route::view('/editUser', 'editUser')->name("editUser");
Route::view('/editUser/editPassword', 'editPassword')->name("editPassword");
Route::post('/edituser/editPassword-update', [userController::class,"updatePassword"])->name("updatePassword");
Route::post('/edituser/updateUser', [userController::class,"updateUser"])->name("updateUser");
Route::get('/followingUsers',function (){
    if (!auth()->check()) return redirect('/');
$games=DB::table('games')
    ->join('follows', 'games.idUser', '=', 'follows.userFollowed_Id')
    ->join('users', 'games.idUser', '=', 'users.id')
    ->where('follows.userFollows_id', '=', auth()->user()->id)
    ->select(
        'games.*',
        'users.*',
        'games.name as name',
        'users.name as user_name',
    )
    ->get();
    $users = DB::table('users')
        ->join('follows', 'users.id', '=', 'follows.userFollowed_Id')
        ->where('follows.userFollows_id', '=', auth()->user()->id)
        ->select('users.*')
        ->get();
    return view('followingUsers',['games'=>$games,'users'=>$users]);
})->name("followingUsers");
/**
 * JUEGO
 */
Route::view('/createGame','createGame')->name('createGame');
Route::post('/createGame',[gameController::class,"createGame"])->name('createGame');
Route::get('/gamePage/{gameId}', function ($gameId) {
    $gameInfo=DB::table('games')->where('idGame', $gameId)->get();
    if (count($gameInfo)<1)$gameInfo[]=null;
    $feedback=DB::table('comments')
        ->where('idGame',$gameId)
        ->where('type','feedback')
        ->join('users','users.id','=','comments.idUser')
        ->orderBy('idComment','desc')
        ->get();
    $patchNotes=DB::table('game_versions')
        ->where('idGame', '=', $gameId)
        ->orderBy('version','desc')
        ->get();
    return view('gamePage', ['game' =>$gameInfo[0],'feedback'=>$feedback,'patchNotes'=>$patchNotes]);})->name("gamePage");
Route::get('/favouriteGames',function (){
    if (!auth()->check()) return redirect('/');
if (auth()->check()){
    $games=DB::table('games')
        ->select('games.*', 'users.username')
        ->join('likes', 'games.idGame', '=', 'likes.idGame')
        ->join('users', 'users.id', '=', 'games.idUser')
        ->where('likes.userId', '=', auth()->user()->id)
        ->get();
    $games=$games->all();
}
else $games=[''];
return view('favouriteGames',['games'=>$games]);
})->name('favouriteGames');
Route::post('/favouriteGames',[gameController::class,"likeGame"])->name('addGameToFav');
Route::post('/favouriteGames/delete',[gameController::class,"removeGame"])->name('removeGame');
Route::post('/createPatch/{idGame}',[gameController::class,"createPatch"])->name('createPatch');
Route::post('/uploadComment/{idGame}',[gameController::class,"uploadComment"])->name('uploadComment');
Route::post('/deleteComment/{idComment}',[gameController::class,"deleteComment"])->name('deleteComment');
Route::post('/editGame/{gameId}',[gameController::class,"updateGame"])->name('updateGame');
Route::get('/deleteGame/{gameId}',[gameController::class,"deleteGame"])->name('deleteGame');
Route::get('/editGame/{gameId}',function ($gameId){
    $gameInfo=DB::table('games')->where('idGame', $gameId)->get();
    if (count($gameInfo)<1)$gameInfo[]=null;
    $gameInfo=$gameInfo[0];
    $gameInfo=get_object_vars($gameInfo);
    $gameInfo['installInstructions']=setLineBreak($gameInfo['installInstructions']);
    // Convierte el array a formato JSON
    $jsonData = json_encode($gameInfo);
    // Decodifica el JSON en un objeto stdClass
    $gameInfo= json_decode($jsonData);

    var_dump($gameInfo->installInstructions);
    $patchNotes=DB::table('game_versions')
        ->where('idGame', '=', $gameId)
        ->orderBy('version','desc')
        ->get();
    $patchNotes=$patchNotes->all();
    $patchNotes=get_object_vars($patchNotes[0]);
    $patchNotes['content']=setLineBreak($patchNotes['content']);
    return view('editGame',['game'=>$gameInfo,'version'=>$patchNotes]);
})->name('editGame');

function setLineBreak($value){
    $temp=explode('<li>',$value);
    $temp=implode('/',$temp);
    $temp=strip_tags($temp);
    $temp=explode('/',$temp);
    if ($temp[0]=='')unset($temp[0]);
    return $temp=implode('&#013;',$temp);
}
