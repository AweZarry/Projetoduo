<?php

$jogos = [];
$dicas = [];
$fotos = [];
$videos = [];
$usuarios = [];

$queryu = "SELECT id_usuario, nome_usuario FROM usuario ORDER BY id_usuario DESC LIMIT 8";
$queryd = "SELECT titdicas, id_dicas, hora FROM dicas ORDER BY hora DESC LIMIT 6";
$queryf = "SELECT titcaptura, id_foto, hora FROM fotos ORDER BY hora DESC LIMIT 6";
$queryv = "SELECT titvideo, id_video, hora FROM videos ORDER BY hora DESC LIMIT 6";
$query = "SELECT n1.*, n1.foto_jogo
          FROM nome n1
          LEFT JOIN nome n2 
          ON n1.nome_jogo = n2.nome_jogo AND n1.id_jogo < n2.id_jogo
          WHERE n2.id_jogo IS NULL
          ORDER BY n1.id_jogo DESC
          LIMIT 6";

$result = $db->query($query);
$resultd = $db->query($queryd);
$resultf = $db->query($queryf);
$resultv = $db->query($queryv);
$resultu = $db->query($queryu);


if ($resultu->rowCount() > 0) {
    while ($row = $resultu->fetch(PDO::FETCH_ASSOC)) {
        $usuarios[] = $row;
    }
}

if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $jogos[] = $row;
    }
}

if ($resultd->rowCount() > 0) {
    while ($row = $resultd->fetch(PDO::FETCH_ASSOC)) {
        $dicas[] = $row;
    }
}

if ($resultf->rowCount() > 0) {
    while ($row = $resultf->fetch(PDO::FETCH_ASSOC)) {
        $fotos[] = $row;
    }
}

if ($resultv->rowCount() > 0) {
    while ($row = $resultv->fetch(PDO::FETCH_ASSOC)) {
        $videos[] = $row;
    }
}

$id_jogo = isset($_GET['id_jogo']) ? $_GET['id_jogo'] : "";

?>

<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #333;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            height: 60px;
            max-height: 70px;
            top: 0;
            z-index: 1000;
            box-shadow: 2px 2px 10px #FFF;
        }

        .navbar-brand {
            display: inline-block;
            color: aliceblue;
            text-decoration: none;
        }

        .navbar-brand img {
            float: left;
            width: 80px;
            height: auto;
            position: relative;
            bottom: 5px;
        }

        .navbar-nav {
            display: inline-block;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            display: inline-block;
            margin-right: 20px;
        }

        .nav-link {
            color: aliceblue;
            text-decoration: none;
            transition: 0.3s;
        }

        .esquerda .nav-link {
            position: relative;
            bottom: 30px;
        }

        .nav-link:hover {
            color: aliceblue;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            min-width: 140px;
            max-width: 140px;
            border: 1px solid #FFF;
            z-index: 1;
        }

        #drop {
            position: absolute;
            top: -10px;
        }

        span.nav-link.dropdown-toggle {
            margin-right: 30px;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-item {
            color: aliceblue;
            text-decoration: none;
            padding: 10px;
            display: block;
            transition: 0.3s;
        }

        .dropdown-item:hover {
            color: aliceblue;
            background-color: #fff;
        }

        .esquerda {
            float: left;
        }

        .direita {
            float: right;
        }

        .pesquisa-input {
            padding: 5px;
            width: 100px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .pesquisa-button {
            padding: 5px;
            font-size: 16px;
            background-color: #191919;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .pesquisa-button:hover {
            background-color: #4e4e4e;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="esquerda">
            <a class="navbar-brand" href="../public/index.php">
                <img src="../public/img/login.png" alt="logo">
            </a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../public/index.php">Início</a>
                </li>
                <li class="nav-item dropdown">
                    <span class="nav-link">Tópicos de Jogos</span>
                    <div class="dropdown-content" id="drop">
                        <?php foreach ($jogos as $jogo): ?>
                            <a class="dropdown-item" href="../view/visu.php?id_jogo=<?= $jogo["id_jogo"] ?>">
                                <?php echo $jogo["nome_jogo"]; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#sobre">Sobre Nós</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../view/rank.php">Ranks</a>
                </li>
            </ul>
        </div>
        <div class="direita">
            <ul>
                <?php if (isset($_SESSION['nome'])): ?>
                    <div class="dropdown">
                        <span class="nav-link dropdown-toggle">Bem-vindo,
                            <?php echo $_SESSION['nome']; ?>!
                        </span>
                        <div class="dropdown-content">
                            <?php if ($_SESSION['adm']): ?>
                                <a class="dropdown-item" href="../view/adm.php">Painel ADM</a>
                            <?php endif; ?>
                            <a class="dropdown-item" href="../view/editarp.php">Editar Perfil</a>
                            <a class="dropdown-item" href="../view/logout.php">Sair</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="nav-item">
                        <a class="nav-link" href="../view/entrar.php">Logar</a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="../view/cadastrar.php">Cadastrar</a>
                    </div>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</body>