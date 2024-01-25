<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\comment;
use App\Models\gameVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GameController extends Controller
{
    /*
     * Crea y valida los datos de formulario de creación de un videojuego
     */
    function createGame(Request $request)
    {
        $errors = $this->getCustomErrors();
        //Verifica que la versión introducida es correcta
        $regexp = "/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)(?:-((?:0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*)(?:\.(?:0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*))*))?(?:\+([0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*))?$/";
        $request->validate(['name' => 'required|max:35', 'version' => 'required'], $errors);
        if (!preg_match($regexp, $request['version'])) return back()->withErrors(['Proporciona una versión correcta']);//valida la versión
        if ($request->hasFile('imgUpload')) {
            //Valida que se ha subido un archivo permitido
            if (!in_array($request['imgUpload']->getClientOriginalExtension(), ['png', 'jpg', 'jpeg', 'webp','avif'])) return back()->withErrors(['Solo se
        admiten archivos .jpg, .jpeg, .png , .webp y .avif']);
            $image = $request->file('imgUpload');
            //uniqid genera un id único por si se varios usuarios suben un archivo con el mismo nombre.
            $name = uniqid($request['name']) . '.' . $image->getClientOriginalExtension();
            $imgDbName = 'game-thumbnails/' . $name;
            $image->move(public_path('game-thumbnails/'), $name);
        } else $imgDbName = 'icons/game-default.png';
        $data['thumbnail'] = $imgDbName;
        if (!$request->hasFile('file')) return back()->withErrors(['No has subido ningún juego']);
        //si el archivo pesa más de 100Mb, no se permitirá la subida
        if ($request->file('file')->getSize()>100000000 )return back()->withErrors(['El juego pesa más de 100MB']);
        if (!in_array($request['file']->getClientOriginalExtension(), ['zip', 'rar', '7zip'])) return back()->withErrors(['Solo se admiten archivos .zip, .rar y .7zip']);
        /*DATA*/
        $data['name'] = str_replace(' ', ' ', $request['name']);
        $data['description'] = $request['description'];
        $data['idUser'] = auth()->user()->id;
        $data['downloadLink'] = $request->file('file');
        //uniqid genera un id único por si se varios usuarios suben un archivo con el mismo nombre.
        $name = uniqid($data['name']) . '.' . $data['downloadLink']->getClientOriginalExtension();
        $request->file('file')->move(public_path('games/'), $name);
        $gameDbPath = 'games/' . $name;
        $data['downloadLink'] = $gameDbPath;
        /**/

        $data['installInstructions'] = $request['installInstructions'];
        $explode = explode(PHP_EOL, $data['installInstructions']);
        if (strlen($explode[0]) < 1) $data['installInstructions'] = 'No se han especificado detalles';
        //Genera la lista de instrucciones
        else {
            $list = '<ol>';
            foreach ($explode as $elem) {
                $list .= '<li>' . $elem . '</li>';
            }
            $list .= '</ol>';
            $list = strip_tags($list, ['<ol><li>']);
            $data['installInstructions'] = $list;;
        }
        //$data['idGame']=Str::random(60);
        $game = Game::create($data);
        $version['idGame'] = DB::select('select idGame from games order by idGame desc limit 1');
        $version['idGame'] = $version['idGame'][0]->idGame;
        $version['version'] = $request->version;
        $version['content'] = $request->patchNotes;
        $explode = explode(PHP_EOL, $version['content']);
        if (strlen($explode[0]) < 1) $version['content'] = 'No se han especificado detalles';
        //genera la lists de características del videojuego
        else {
            $list = '<ol>';
            foreach ($explode as $elem) {
                $list .= '<li>' . $elem . '</li>';
            }
            $list .= '</ol>';
            $list = strip_tags($list, ['<ol><li>']);
            $version['content'] = $list;;
        }
        $game = DB::table('games')->where('name', $game->name)->get();
        gameVersion::create($version);
        $game = $game->all();
        die(header("Location: " . URL::to('/gamePage/' . $game[0]->idGame)));
    }

    function getCustomErrors()
    {
        return [
            'file.required'=>'No has subido ningún juego',
            'file.max'=>'El archivo pesa más de 20mb',
            'name.required' => 'Nombre requerido',
            'version.required' => 'No has especificado una versión',
            'file.required' => 'No has subido ningún juego',
            'name.max'=>'Título demasiado largo, introduce uno nuevo'
        ];
    }
/*
 * Permite dar me gusta a un juego y añadirlo a favoritos
 */
    function likeGame()
    {
        $likedGames = session('likedGames');
        //si da error, es que ya está guardado en favoritos, por lo que se ejecuta el catch
        try {
            DB::table('likes')->insert([
                'userId' => $_POST['loggedInUser'],
                'idGame' => $_POST['gameId'],
            ]);
            $likedGames   [] = intval($_POST['gameId']);
            session(['likedGames' => $likedGames]);
            return json_encode(1);
        } catch (\Exception $e) {
            DB::table('likes')->where('userId', '=', $_POST['loggedInUser'])->
            where('idGame', '=', $_POST['gameId'])->delete();
            $index = array_search($_POST['gameId'], $likedGames);
            unset($likedGames[$index]);
            $likedGames = array_values($likedGames);
            session(['likedGames' => $likedGames]);
            return json_encode(0);
        }
    }
/*
 * Elimina el videojuego selecconado de la lista de favoritos
 */
    function removeGame()
    {
        $likedGames = session('likedGames');
        DB::table('likes')->where('userId', '=', auth()->user()->id)->
        where('idGame', '=', $_POST['gameId'])->delete();
        $index = array_search($_POST['gameId'], $likedGames);
        unset($likedGames[$index]);
        $likedGames = array_values($likedGames);
        session(['likedGames' => $likedGames]);
        return json_encode(true);
    }

    /*
     * Permite crear notas del parche
     */
    function createPatch(Request $request, $idGame)
    {
        $data = $request->validate(['version' => 'required', 'content' => 'required'],['version.required'=>'Escribe una versión','content.required'=>'Escribe algún contenido']);
        $regexp = "/^(0|[1-9]\d*)\.(0|[1-9]\d*)\.(0|[1-9]\d*)(?:-((?:0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*)(?:\.(?:0|[1-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*))*))?(?:\+([0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*))?$/";
        if (preg_match($regexp, $data['version'])) echo 'true';
        else return back()->withErrors(['Proporciona una versión correcta']);
        $explode = explode(PHP_EOL, $data['content']);
        $list = '<ol>';
        foreach ($explode as $elem) {
            $list .= '<li>' . $elem . '</li>';
        }
        $list .= '</ol>';
        $list = strip_tags($list, ['<ol><li>']);
        $data['content'] = $list;
        $data['idGame'] = $idGame;
        gameVersion::create($data);
        return back();
    }
/*
 * Permite comentar en la página de un juego
 */
    function uploadComment(Request $request, $idGame)
    {
        $data = $request->validate(['text' => 'required']);
        $data['idGame'] = $idGame;
        $data['idUser'] = auth()->user()->id;
        $data['type'] = 'feedback';
        $explode = explode("\r\n", $data['text']);
        $explode = implode('<br>', $explode);
        $data['text'] = strip_tags($explode, '<br>');
        comment::create($data);
        return back();
    }
    /*
     * Borra un comentario
     */
    function deleteComment(Request $request, $idComment)
    {
        DB::table('comments')->where('idUser', '=', auth()->user()->id)->
        where('idComment', '=', $idComment)->delete();
    }
    /*
     * Elimina un juego de la base de datos
     */
function deleteGame($gameId){
        $game=Game::find($gameId);
        $game->delete();
        return redirect(route('profilePage',['userId'=>auth()->user()->id]));
}
/*
 * Actualiza y valida los datos del formulacio de actualización del videojuego
 */
    function updateGame(Request $request, $gameId)
    {
        $errors = $this->getCustomErrors();
        $request->validate(['name' => 'required'], $errors);
        $game = Game::where('idGame', $gameId)->first();
        /*DATA*/
        $data['name'] = str_replace(' ', ' ', $request['name']);
        $data['description'] = $request['description'];
        $data['idUser'] = auth()->user()->id;
        /**/if ($request->hasFile('imgUpload')) {
            if (!in_array($request['imgUpload']->getClientOriginalExtension(), ['png', 'jpg', 'jpeg', 'webp','avif'])) return back()->withErrors(['Solo se
        admiten archivos .jpg, .jpeg, .png , .webp y .avif']);
            $image = $request->file('imgUpload');
            $name = uniqid($request['name']) . '.' . $image->getClientOriginalExtension();
            $imgDbName = 'game-thumbnails/' . $name;
            $image->move(public_path('game-thumbnails/'), $name);
            $data['thumbnail'] = $imgDbName;
            $game->thumbnail=$data['thumbnail'];
        }
        if ($request->hasFile('file')) {
            if ($request->file('file')->getSize()>100000000 )return back()->withErrors(['El juego pesa más de 100MB']);
            if (!in_array($request['file']->getClientOriginalExtension(), ['zip', 'rar', '7zip'])) return back()->withErrors(['Solo se admiten archivos .zip, .rar y .7zip']);
            $data['downloadLink'] = $request->file('file');
            //uniqid genera un id único por si se varios usuarios suben un archivo con el mismo nombre.
            $name = uniqid($data['name']) . '.' . $data['downloadLink']->getClientOriginalExtension();
            $request->file('file')->move(public_path('games/'), $name);
            $gameDbPath = 'games/' . $name;
            $data['downloadLink'] = $gameDbPath;
            $game->downloadLink=$data['downloadLink'];
        }
        $data['installInstructions'] = $request['installInstructions'];
        $explode = explode(PHP_EOL, $data['installInstructions']);
        if (strlen($explode[0]) < 1) $data['installInstructions'] = 'No se han especificado detalles';
        else {
            $list = '<ol>';
            foreach ($explode as $elem) {
                $list .= '<li>' . $elem . '</li>';
            }
            $list .= '</ol>';
            $list = strip_tags($list, ['<ol><li>']);
            $data['installInstructions'] = $list;;
        }
        print_r($data);
        $game->name=$data['name'];
        $game->description=$data['description'];
        $game->idUser=$data['idUser'];
        $game->installInstructions=$data['installInstructions'];
        //$data['idGame']=Str::random(60);
        $game->save();
        return redirect(route('gamePage',['gameId'=>$gameId]));

    }
}

