<?php
include_once('autoload.class.php');
date_default_timezone_set('America/Tijuana');
use Adross\App;
use Adross\Database;
use Models\Usuario;
use Models\Informacion_Usuario;
use Models\Peticion;
use Models\Post;

$info = new Informacion_Usuario();
$user = new Usuario();
$app = new App();
$userPost = new Post();
$requestPet = new Peticion();

/*
* TYPE: FUNCTION
* NAME: CheckAsView
* DESCRIPTION: La funcion permite 
* generar vistas protegidas por 
* el login del usuario
*/

function CheckUserAsView($view, $context, $req, $res){
    if(isset($_SESSION['user'])){
        $res->render($view, $context);
    }
    else
    {
        echo "User not logged";
    }
}

/*
* TYPE: FUNCTION
* NAME: CheckAsBoolean
* DESCRIPTION: La funcion permite 
* verificar el login del usuario 
* como verdadero o falso
*/

function CheckUserAsBoolean(){
    if(isset($_SESSION['user'])){
        return true;
    }
    else
    {
        return false;
    }
}

/*
* TYPE: FUNCTION
* NAME: CheckAdminAsView
* DESCRIPTION: La funcion permite 
* generar vistas protegidas por 
* el login del usuario
*/

function CheckAdminAsView($view, $context, $req, $res){
    if(isset($_SESSION['user'])){
        if($_SESSION['user']['Rol'] == 1){
            $res->render($view, $context);
        }
        else
        {
            echo "Error, no administrator rol";
        }
    }
    else
    {
        echo "User not logged";
    }
}

/*
* TYPE: FUNCTION
* NAME: CheckAdminAsBoolean
* DESCRIPTION: La funcion permite 
* verificar el login del usuario 
* como verdadero o falso
*/

function CheckAdminAsBoolean(){
    if(isset($_SESSION['user'])){
        if($_SESSION['user']['Rol'] == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

/*
* TYPE: FUNCTION
* NAME: GetImage
* DESCRIPTION: Obtiene las imagenes 
* subidas por los usuarios como 
* base64 para evitar que accedan 
* a otras imagenes
*/

function GetImage($path){
    if(file_exists($path)){
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $img = 'data:image/'.$type.';base64,'.base64_encode($data);
    return $img;
    }
    else{
        return "";
    }
}

/*
* TYPE: FUNCTION
* NAME: GetImage
* DESCRIPTION: La funcion permite subir una imagen al servidor
* y genera una carpeta por usuario
*/

function UploadImage($field){
    $path = "uploads/".$_SESSION["user"]["Usuario"]."/";
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    $originalName = basename($_FILES[$field]["name"]);
    $originalName = explode(".", $originalName);
    $fileName = $_SESSION["user"]["Usuario"].date("dmyHis").".".$originalName[count($originalName)-1];
    $file = $path.$fileName;
    if(move_uploaded_file($_FILES[$field]["tmp_name"], $file)){
        return $file;
    }
    else{
        return "";
    }

}

/* 
* TYPE: ROUTE
* LOGIN: false
* ROUTE: /
* METHOD: GET
*/

$app->router->get("/", function($req, $res){
    if(CheckUserAsBoolean()){
        header('Location: /auth/home');
    }else{
    $res->render("index", ["title"=>"Petpetition - Inicio"]);
    }
});

/*
* TYPE: ROUTE
* LOGIN: false
* ROUTE: /register
* METHOD: GET
*/

$app->router->get("/register", function($req, $res){
    if(CheckUserAsBoolean()){
        header('Location: /auth/home');
    }else{
    $res->render("register", ["title"=>"Petpetition - Registrar"]);
    }
});

/* 
* TYPE: ROUTE
* LOGIN: false
* ROUTE: /register
* METHOD: POST
*/

$app->router->post("/register", function($req, $res){
    if(CheckUserAsBoolean()){
        header('Location: /auth/home');
    }else{
    global $info;
    $state = true;
    foreach ($info->index() as $row) {
        if ($row['Correo'] == $req["body"]["email"])
            $state = false;
    }
    if ($state) {
        $info->create([
            $req["body"]["name"],
            $req["body"]["lastname"],
            $req["body"]["email"],
            $req["body"]["date"],
            $req["body"]["state"],
            $req["body"]["municipality"],
            $req["body"]["phone"],
        ]);
        $res->render('register_user', ["title" => "Petpetition - Register user", "email" => $req["body"]['email']]);
    } else {
        $res->render('register', ["title" => "Petpetition - Error on register", "message" => "email all ready register"]);
    }
    }
});

/* 
* TYPE: ROUTE
* LOGIN: false
* ROUTE: /registerUser
* METHOD: POST
*/

$app->router->post("/registerUser", function($req, $res){
    if(CheckUserAsBoolean()){
        header('Location: /auth/home');
    }else{
    global $info;
    global $user;
    $_id = 0;
    $usercomposition = date("ymdhis");
    foreach ($info->index() as $row) {
        if ($row['Correo'] == $req["body"]["email"])
            $_id = $row["_id"];
    }
    if ($_id != 0) {
        $user->create([
            $req["body"]["user"] . "#" . $usercomposition,
            hash('sha256', $req["body"]["pass"]),
            $_id,
            "2",
            date('Y-m-d H:i:s')
        ]);
        $res->render('register', ["title" => "Petpetition - Error on register", "message" => "Usuario creado exitosamente", "type" => "success"]);
    } else {
        $res->render('register', ["title" => "Petpetition - Error on register", "message" => "El usuario no se pudo crear, parametros incorrectos"]);
    }
    }
});

/* 
* TYPE: ROUTE
* LOGIN: false
* ROUTE: /false
* METHOD: GET
*/

$app->router->get("/login", function($req, $res){
    if(CheckUserAsBoolean()){
        header('Location: /auth/home');
    }else{
    $res->render("login", ["title"=>"Petpetition - Iniciar sesión"]);
    }
});

/* 
* TYPE: ROUTE
* LOGIN: false
* ROUTE: /login
* METHOD: POST
*/

$app->router->post("/login", function($req, $res){
    if(CheckUserAsBoolean()){
        header('Location: /auth/home');
    }else{
    global $info;
    global $user;
    $_id = 0;
    $pass = hash('sha256', $req["body"]["pass"]);
    $email = $req["body"]["email"];
    foreach ($info->index() as $row) {
        if ($row['Correo'] == $email)
            $_id = $row["_id"];
    }
    if ($_id != 0) {
        $logged = false;
        $_user = null;
        foreach ($user->index() as $userselec) {
            if ($userselec["Informacion"] == $_id && $userselec["Clave"] == $pass) {
                $logged = true;
                $_user = $userselec;
            }
        }
        if ($logged) {
            $_SESSION['user'] = $_user;
            header('Location: /auth/home');
        } else {
            $res->render('login', ["title" => "Petpetition - Error on register", "message" => "Usuario y/o contraseña"]);
        }
    } else {
        $res->render('login', ["title" => "Petpetition - Error on register", "message" => "Correo electronico no registrado"]);
    }
    }
});

/* 
* TYPE: ROUTE
* LOGIN: true
* ROUTE: /auth/home
* METHOD: GET
*/

$app->router->get("/auth/home", function($req, $res){
    global $userPost;
    global $requestPet;
    global $user;
    $post = [];
    foreach($userPost->index() as $_post){
        $postUserInfo = $user->showAllByID($_post["Usuario"])[0]["Usuario"];
        $requestPetStatus = $requestPet->showAllByColumns([["name"=>"Post", "value"=>$_post["_id"]]]);
        $post[] = [
            "_id"=>$_post['_id'],
            "image"=>GetImage($_post["Imagen"]),
            "title"=>$_post["Titulo"],
            "text"=>$_post["Contenido"],
            "category"=>$_post["Categoria"],
            "date"=>$_post["Fecha"],
            "time"=>$_post["Fecha"],
            "user"=> $postUserInfo,
            "num"=>count($requestPetStatus)
        ];
    }
    CheckUserAsView('auth/home', ["title"=>"Petpetition - Panel", "post"=>$post], $req, $res);
});

$app->router->get("/auth/admin", function($req, $res){
    if(CheckUserAsBoolean())
    {
        if(CheckAdminAsBoolean())
        {
            $res->render("auth/admin", []);
        }
        else
        {
            echo "No user as admin";
        }
    }
    else
    {
        echo "Not logged";
    }
});

/*
* TYPE: ROUTE 
* LOGIN: true
* ROUTE: /auth/my_posts
* METHOD: GET
*/

$app->router->get("/auth/my_posts", function($req, $res){
    if(CheckUserAsBoolean()){
        global $userPost;
        global $requestPet;
        $post = [];
        $userPosts = $userPost->showAllByColumns([
            [
                "name"=>"Usuario",
                "value"=>$_SESSION['user']['_id']
            ]
        ]);
        if($userPosts > 0){
            foreach($userPosts as $_post){
                $requestPetStatus = $requestPet->showAllByColumns([["name"=>"Post", "value"=>$_post["_id"]]]);
                $post[] = [
                    "_id"=>$_post['_id'],
                    "image"=>GetImage($_post["Imagen"]),
                    "title"=>$_post["Titulo"],
                    "text"=>$_post["Contenido"],
                    "category"=>$_post["Categoria"],
                    "date"=>$_post["Fecha"],
                    "time"=>$_post["Fecha"],
                    "num"=>count($requestPetStatus)
                ];
            }
            $res->render("auth/my_posts", ["title"=>"Petpetition - Mis adopciones", "post"=>$post]);
        }
    }else{
        header('location: /');
    }
});

/* 
* TYPE: ROUTE
* LOGIN: true
* ROUTE: /auth/post
* METHOD: GET
*/

$app->router->get("/auth/post", function($req, $res){
    CheckUserAsView('auth/post', ["title"=>"Petpetition - Create post"], $req, $res);
});

/* 
* TYPE: ROUTE
* LOGIN: true
* ROUTE: /auth/post
* METHOD: POST
*/

$app->router->post("/auth/post", function($req, $res){
    if(CheckUserAsBoolean()){
        $category = $req["body"]["category"];
        if($category == "Perros" || $category == "Gatos" || $category == "Otros"){
            global $userPost;
            if(
                isset($req["body"]["title"]) && 
                isset($req["body"]["content"]) && 
                isset($req["body"]["category"]) && 
                file_exists($_FILES["image"]["tmp_name"]) && 
                isset($_SESSION["user"]["_id"])
            ){
                $userPost->create([
                    $req["body"]["title"],
                    $req["body"]["content"],
                    date("Y-m-d H:i:s"),
                    $req["body"]["category"],
                    UploadImage("image"),
                    $_SESSION["user"]["_id"]
                ]);
                header('location: /auth/home');
            }
            else
            {
                $res->send("Error, wrong data or not image to upload");
            }
        }
        else
        {
            $res->send("Error, wrong category");
        }
    }else{
        header('location: /');
    }
});

/* 
* TYPE: ROUTE
* LOGIN: true
* ROUTE: /auth/post/applicants
* METHOD: GET
*/

$app->router->get("/auth/post/applicants", function($req, $res){
    if(CheckUserAsBoolean()){
        global $requestPet;
        global $userPost;
        global $user;
        $db = new Database();
        $consulta = $db->Query("SELECT 
        tb_peticion._id as id, 
        tb_usuario._id as id_solicitante, 
        tb_usuario.Usuario as Solicitante, 
        tb_post.Titulo as Titulo,
        tb_post.Imagen as Imagen,
        tb_post.Contenido as Contenido FROM `tb_peticion` 
        INNER JOIN `tb_usuario` ON tb_usuario._id = tb_peticion.Usuario 
        INNER JOIN `tb_post` ON tb_post._id = tb_peticion.Post 
        WHERE tb_post.Usuario = ".$_SESSION['user']['_id']);
        if($consulta>0){
            $temp = [];
            foreach($consulta as $peticion){
                $peticion['Imagen'] = GetImage($peticion["Imagen"]);
                $temp[] = $peticion;
            }
            $res->render('auth/applicants', ["peticiones"=>$temp]);
        }
        else
        {

        }
    }
});

/*
* TYPE: ROUTE
* LOGIN: true
* ROUTE: /auth/post/request
* METHOD: POST
*/

$app->router->post("/auth/post/request", function($req, $res){
    if(CheckUserAsBoolean()){
        global $requestPet;
        if(isset($req["body"]["id"])){
            $userPetRequest = $requestPet->showAllByColumns([
                [
                    "name"=>"Usuario",
                    "value"=>$_SESSION["user"]["_id"]
                ],
                [
                    "name"=>"Post",
                    "value"=>$req["body"]["id"]
                ]
            ]);
            if(count($userPetRequest) == 0){
                $requestPet->create([
                    $_SESSION["user"]["_id"],
                    $req["body"]["id"],
                ]);
                $res->json(["message"=>""]);
            }
            else $res->json(["message"=>"All ready preview request"]);
        }
        else $res->json(["message"=>"Bad body request"]);
    }else $res->json(["message"=>"Not logged"]);
});

/*
* TYPE: ROUTE
* LOGIN: true
* ROUTE: /auth/post/request
* METHOD: POST
*/

$app->router->get("/auth/post/requests", function($req, $res){
    if(CheckUserAsBoolean()){
        global $requestPet;
        global $userPost;
        $userPetRequest = $requestPet->showAllByColumns([
            [
                "name"=>"Usuario",
                "value"=>$_SESSION["user"]["_id"]
            ]
        ]);
        $data = [];
        foreach($userPetRequest as $row){
            $userPostData = $userPost->showAllByID($row["Post"]);
            foreach($userPostData as $post)
            {
                $requestPetStatus = $requestPet->showAllByColumns([["name"=>"Post", "value"=>$post["_id"]]]);
                $data[] = [
                    "_id"=>$post['_id'],
                    "image"=>GetImage($post["Imagen"]),
                    "title"=>$post["Titulo"],
                    "text"=>$post["Contenido"],
                    "category"=>$post["Categoria"],
                    "date"=>$post["Fecha"],
                    "time"=>$post["Fecha"],
                    "num"=>count($requestPetStatus)
                ];
            }
        }
        $res->render("auth/requests", ["title"=>"Petpetition - Peticiones", "post"=>$data]);
    }
});

/*
* TYPE: ROUTE
* LOGIN: true
* ROUTE: /auth/post/delete
* METHOD: POST
*/

$app->router->post("/auth/post/delete", function($req, $res){
    if(CheckUserAsBoolean()){
        global $userPost;
        $id = isset($req["body"]["id"]) ? $req["body"]["id"] : 0;
        if($id!=0){
            $userPostID = $userPost->showAllByID($id);
            if(count($userPostID)>0)
            {
                if($userPostID[0]["Usuario"] == $_SESSION["user"]["_id"]){
                    $userPost->delete($id);
                    if(file_exists($userPostID[0]["Imagen"])){
                        unlink($userPostID[0]["Imagen"]);
                    }
                    $res->json(["message"=>"Post delete"]);
                }
                else
                {
                    $res->json(["message"=>"No access to this post"]);
                }
            }
            else
            {
                $res->json(["message"=>"No post in db"]);
            }
        }
        else
        {
            $res->json(["message"=>"No data in post"]);
        }
    }else{
        header('location: /');
    }
});

/*
* TYPE: ROUTE
* LOGIN: true
* ROUTE: /auth/post/deleteRequest
* METHOD: POST
*/

$app->router->post("/auth/post/deleteRequest", function($req, $res){
    if(CheckUserAsBoolean()){
        global $requestPet;
        $id = isset($req["body"]["id"]) ? $req["body"]["id"] : 0;
        if($id!=0){
            $request = $requestPet->showAllByColumns([
                [
                    "name"=>"Usuario",
                    "value"=>$_SESSION["user"]["_id"],
                ],
                [
                    "name"=>"Post",
                    "value"=>$id
                ]
            ]);
            if(count($request)>0)
            {
                $requestPet->delete($request[0]["_id"]);
                $res->json(["message"=>"Request delete"]);
            }
            else
            {
                $res->json(["message"=>"No post in db"]);
            }
        }
        else
        {
            $res->json(["message"=>"No data in post"]);
        }
    }else{
        header('location: /');
    }
});

/* 
* TYPE: ROUTE
* LOGIN: true
* ROUTE: /auth/logout
* METHOD: GET
*/

$app->router->get("/auth/logout", function($req, $res){
    if(CheckUserAsBoolean()){
        unset($_SESSION['user']);
        header('Location: /');
    }else{
        echo "Not logged to logout";
    }
});
?>