<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contas Cadastradas</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <header>
        <div class="container-fluid p-4 card">
            <div class="container">
                <ul class="nav d-flex justify-content-center">
                    <li class="nav-item"><a href="index.html" class="nav-link">Cadastro</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Contas</a></li>
                    <li class="nav-item"><a href="editar.php" class="nav-link">Editar Contas</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Contact</a></li>
                </ul>
            </div>
        </div>
    </header>

    <section class="container-fluid mt-4">

        <div class='container.fluid mt-5 d-flex justify-content-center align-items-center'>
            <div class='container p-4 d-flex flex-column justify-content center bg-secondary-subtle mt-2 rounded-2 shadow'>
                <h1 class="text-center mb-5">Contas Cadastradas</h1>

                <table class="table table-striped table-light rounded-2">

                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">nome</th>
                            <th scope="col">email</th>
                            <th scope="col">telefone</th>
                            <th scope="col">email-contato</th>
                        </tr>
                    </thead>

                    <tbody id="lista">

                        <?php

                            include "conexao.php";

                            $select = "SELECT * FROM `usuario`";

                            $select = mysqli_query($con,$select);

                            while($exibe = mysqli_fetch_array($select) ){
                                ?>
                                <tr>
                                    <td><?php echo $exibe["id"]?></td>
                                    <td><?php echo $exibe["nome"]?></td>
                                    <td><?php echo $exibe["email"]?></td>
                                    <td><?php echo $exibe["tel"]===""? "não cadastrado":$exibe["tel"]?></td>
                                    <td><?php echo $exibe["email_contato"]===""? "não cadastrado":$exibe["email_contato"]?></td>
                                </tr>

                            <?php
                            }

                        ?>

                    </tbody>
                </table>


            </div>

    </section>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>

</html>