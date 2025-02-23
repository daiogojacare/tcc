<?php
session_start();

include('../config.php');

if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true) and (!isset($_SESSION['nivel_acesso']) == 'adm')) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: ../home/login.php');
}

if (!empty($_GET['search'])) {
    $data = $_GET['search'];
    $sql = "SELECT id_pedidos, tamanho, bebidas, retirar_algo, preco, DATE_FORMAT(data_hora_pedido, '%d/%m/%Y %H:%i:%s') as data_hora_pedido, forma_pagamento, cidade, bairro, rua, numero, complemento FROM pedidos WHERE id_pedidos LIKE '%$data%' or tamanho LIKE '%$data%' ORDER BY id_pedidos DESC";
} else {
    $sql = "SELECT id_pedidos, tamanho, bebidas, retirar_algo, preco, DATE_FORMAT(data_hora_pedido, '%d/%m/%Y %H:%i:%s') as data_hora_pedido, forma_pagamento, cidade, bairro, rua, numero, complemento FROM pedidos ORDER BY id_pedidos DESC";
}
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="Website Icon" type="png" href="../fotos/cantinalogo.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script type="text/javascript" src="../js/bibliotecas.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/produtosadm.css">
    <title>Cantina Federal</title>
</head>

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="../fotos/cantinalogo.png" alt="">
            </div>
            <span class="logo_name">Cantina</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li>
                    <a href="marmitasadm.php">
                        <i class="uil uil-truck"></i>
                        <span class="link-name">Delivery</span>
                    </a>
                </li>
                <li>
                    <a href="produtosadm.php">
                        <i class="uil uil-shopping-bag"></i>
                        <span class="link-name">Produtos</span>
                    </a>
                </li>
                <li>
                    <a href="cardapioadm.php">
                        <i class="uil uil-book"></i>
                        <span class="link-name">Marmita Cardápio</span>
                    </a>
                </li>
                <li>
                    <a href="tamanho.php">
                        <i class="uil uil-dollar-alt"></i>
                        <span class="link-name">Marmita Preço</span>
                    </a>
                </li>
            </ul>
            <ul class="logout-mode">
                <li>
                    <a href="../sair.php">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Sair</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
        </div>
        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-truck"></i>
                    <span class="text">Delivery</span>
                </div>
                <h2>Pedidos</h2>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Data e Hora</th>
                                <th scope="col">Pedido</th>
                                <th scope="col">Localização</th>
                                <th scope="col">Forma de Pagamento</th>
                                <th scope="col">Preço</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($user_data = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $user_data['data_hora_pedido'] . "</td>";
                                echo "<td>
                                    <button class='btn btn-sm btn-primary show-details' data-id='" . $user_data['id_pedidos'] . "'>Detalhes</button>
                                </td>";
                                echo "<td>
                                    <button class='btn btn-sm btn-primary show-location' data-id='" . $user_data['id_pedidos'] . "'>Localização</button>
                                </td>";
                                echo "<td>" . $user_data['forma_pagamento'] . "</td>";
                                echo "<td>" . 'R$' . $user_data['preco'] . "</td>";
                                echo "<td>
                                    <a class='btn btn-sm btn-danger' href='deletepedidos.php?id_pedidos=$user_data[id_pedidos]' title='Deletar'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                            <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                                        </svg>
                                    </a>
                                </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade custom-modal" id="detailsModal" tabindex="-1" role="dialog"
        aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Detalhes do Pedido</h5>
                    <button type="button" class="close" id="closeDetailsModal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tamanho</th>
                                <th>Bebidas</th>
                                <th>Retirar Algo</th>
                            </tr>
                        </thead>
                        <tbody id="detailsData">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade custom-modal" id="locationModal" tabindex="-1" role="dialog"
        aria-labelledby="locationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="locationModalLabel">Informações de Localização</h5>
                    <button type="button" class="close" id="closeModal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Cidade</th>
                                <th>Bairro</th>
                                <th>Rua</th>
                                <th>Número</th>
                                <th>Complemento</th>
                            </tr>
                        </thead>
                        <tbody id="locationData">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/produtosadm.js"></script>
    <script>
        const showDetailsButtons = document.querySelectorAll('.show-details');
        const detailsDataContainer = document.getElementById('detailsData');

        showDetailsButtons.forEach(button => {
            button.addEventListener('click', () => {
                const pedidoID = button.getAttribute('data-id');
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'get_details_data.php?id=' + pedidoID, true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        const detailsData = JSON.parse(xhr.responseText);
                        if (detailsData) {
                            detailsDataContainer.innerHTML = `
                            <tr>
                                <td>${detailsData.tamanho}</td>
                                <td>${detailsData.bebidas}</td>
                                <td>${detailsData.retirar_algo}</td>
                            </tr>
                        `;

                            $('#detailsModal').modal('show');
                        }
                    }
                };

                xhr.send();
            });
        });

        document.getElementById('closeDetailsModal').addEventListener('click', function () {
            $('#detailsModal').modal('hide');
        });
    </script>
    <script>
        const showLocationButtons = document.querySelectorAll('.show-location');
        const locationDataContainer = document.getElementById('locationData');

        showLocationButtons.forEach(button => {
            button.addEventListener('click', () => {
                const pedidoID = button.getAttribute('data-id');
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'get_location_data.php?id=' + pedidoID, true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        const locationData = JSON.parse(xhr.responseText);
                        if (locationData) {
                            locationDataContainer.innerHTML = `
                                <tr>
                                    <td>${locationData.cidade}</td>
                                    <td>${locationData.bairro}</td>
                                    <td>${locationData.rua}</td>
                                    <td>${locationData.numero}</td>
                                    <td>${locationData.complemento}</td>
                                </tr>
                            `;

                            $('#locationModal').modal('show');
                        }
                    }
                };

                xhr.send();
            });
        });

        document.getElementById('closeModal').addEventListener('click', function () {
            $('#locationModal').modal('hide');
        });
    </script>
    <script>
        function refreshPage() {
            location.reload();
        }

        setInterval(refreshPage, 60000); 
    </script>
</body>

</html>