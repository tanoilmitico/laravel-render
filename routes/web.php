<?php
use App\Http\Controllers\ProvaController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AddCustomHeader;
use App\Jobs\SimpleJob;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StripeController; //per pagamenti
/*Route::get('/', function () {
    $job= new SimpleJob ('BELLO');
    $job->handle();
    SimpleJob::dispatch ('sono un job dispacciato')->delay(now()->addMinutes(1));
    return view('posts.form',[
        'pageTitle'=> 'Homepage', 
        'metaTitle'=> 'About nel meta title'
    ]);
});*/

Route::get ('/home', function(){
    return view ('home');
})->middleware('auth')->name('home');
Route::get('/about', function () {
    return view('about', [
        'pageTitle' => 'About entrter',
        'metaTitle' => 'About nel metatitle'
    ]);
})//->middleware(AddCustomHeader::class);
->middleware('auth');
Route::get('/post/{id}', function ($id) {
    $post = Post::findOrFail($id);
    return view('posts.show', ['post' => $post]);
})// per gestire gli id ->where('id','[0-9]+')
->name('post.show');

Route::put ('post/{id}', function (Request $request, $id){
    $post= Post::findOrFail($id);
    $post-> title =$request -> input ('title');
    $post-> content =$request-> input ('content');
    $post -> save();
    return redirect()-> route ('post.show', ['id'=> $post-> id]) -> with('success', 'Post aggiornato con successo');
})-> name('post.update');

Route::delete('/post/{id}', function ($id) {
    $post = Post::findOrFail($id);
    $post->delete();

    return redirect()->route('my.posts')->with('success', 'Post eliminato con successo');
})->name('post.delete');

Route::delete('/posts/delete-multiple', [PostController::class, 'deleteMultiple'])
    ->middleware('auth')
    ->name('posts.deleteMultiple');
//route utente admin
Route::get('/admin/posts', [PostController::class, 'allPosts'])->name('admin.posts')->middleware('auth');


//Route::get('/esempio', function () {
   // $items= ['Item 1', 'Item 2', 'Item 3'];
   // $title = "Esempio di Blade";
   // $numbers =[1,2,3,4,5];
   // $emptyArray =[];
   // $someValue= null;
        //return view ('esempio', compact ('items', 'title', 'numbers','emptyArray', 'someValue'));
//});

//Route::get('/prova', [ProvaController::class, 'provaFunction']);
//Route::post('/prova', [ProvaController::class, 'provaData']);

//Route::get('/posts', function (){
    //recupera tutti i post
    //$posts= Post::all();
    //mostra tutti i post
    //return view('posts.index', ['posts' => $posts]);
    //$user = User::factory()->count(10)->create();
    //$user = User::factory()->count(10)->unverified()->create();
    //$posts = User::factory()->count(10)->unverified()->create();
    //$posts = Post::factory()->count(10)->create();
    //return $posts;
    //$user = User::factory()->create(['name'=>'gaetano prova']);
    //return $user;
    // $users = User::factory()->count(10)->unverified()->create();
   // return $users;
//}) -> name ('posts.index');

//Route::get ('/posts/create', function (){
    //crea un nuovo post con dati fittizi
   // $post = Post::create ([
       // 'created_at'=> now(),
       // 'updated_at'=> now(),
    //]);
    //mostra un messaggio di conferma con l'ID del post creato
    //return view ('posts.create', ['post'=> $post]);
//})-> name('posts.create');

//Route::get ('/posts/delete/{id}', function ($id){
    //recupera e elimina il post con l'ID specificato
    //$post = Post::find ($id);

   // if ($post){
       // $post->delete();
        //$message ="Il post con ID $id è stato eliminato.";
    //} else {
       // $message ="Il posto con ID $id non è stato eliminato.";
    //}
    //mostra un messaggio di conferma dell'eliminazione
    //return view ('posts.delete', ['message'=> $message]);
//})-> name ('posts.delete');
// modifica i post
Route::get('/post/{id}/edit', [PostController::class, 'edit'])->middleware('auth')->name('post.edit');
//salva le modifiche ai post
Route::put('/post/{id}', [PostController::class, 'update'])->middleware('auth')->name('post.update');


//
Route::post('/form', [ValidationController::Class, 'validateForm'])->name ('validateForm');
// Route per la registrazione
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('showRegisterForm');
Route::post('/register', [UserController::class, 'register'])->name('registerUser');

// Route per il login
Route::get('/', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('loginUser');

// Route per il logout
Route::post('/logout', [UserController::class, 'logout'])->name('logoutUser');
// Route per i post
Route::get('/myposts', [PostController::class, 'myPosts'])->middleware('auth')->name('my.posts');
// Mostra il form di creazione del post
Route::get('/posts/create', [PostController::class, 'create'])->middleware('auth')->name('posts.create');

// Salva il post nel database
Route::post('/posts', [PostController::class, 'store'])->middleware('auth')->name('posts.store');

//per pagamenti

Route::post('/checkout/{post}', [StripeController::class, 'checkout'])->name('checkout');
Route::get('/payment/success', fn() => 'Pagamento effettuato con successo!')->name('payment.success');
Route::get('/payment/cancel', fn() => 'Pagamento annullato.')->name('payment.cancel');

