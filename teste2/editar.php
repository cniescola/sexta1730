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
                    <li class="nav-item"><a href="contas.php" class="nav-link">Contas</a></li>
                    <li class="nav-item"><a href="editar.php" class="nav-link">Editar Contas</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Contact</a></li>
                </ul>
            </div>
        </div>
    </header>

    <section id="campo-lista" class="container-fluid mt-4">

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

                        $select = mysqli_query($con, $select);

                        while ($exibe = mysqli_fetch_array($select)) {
                        ?>
                            <tr class="conta">
                                <td class="id"><?php echo $exibe["id"] ?></td>
                                <td class="nome"><?php echo $exibe["nome"] ?></td>
                                <td class="email"><?php echo $exibe["email"] ?></td>
                                <td class="tel"><?php echo $exibe["tel"] === "" ? "não cadastrado" : $exibe["tel"] ?></td>
                                <td class="email_contato"><?php echo $exibe["email_contato"] === "" ? "não cadastrado" : $exibe["email_contato"] ?></td>
                            </tr>

                        <?php
                        }

                        ?>

                    </tbody>
                </table>


            </div>

    </section>

    <section class="container-fluid mt-5  d-flex justify-content-center align-items-center">
        <div class="container bg-secondary-subtle p-4  rounded-2  d-flex flex-column justify-content-center align-items-center">

            <div class="row w-100">
                <div class="col">
                    <h3 class="h3 mb-5 text-center">Editar</h3>
                </div>

            </div>

            <div class="row w-100 p-2">
                <div class="col">
                    <label class="form-label">Nome de usuario</label>
                    <input type="text" class="form-control" name="nome">
                </div>
            </div>

            <div class="row w-100 p-2">
                <div class="col">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
            </div>

            <div class="row w-100 p-2">
                <div class="col">
                    <label class="form-label">Senha</label>
                    <input type="password" class="form-control" name="senha">
                </div>
            </div>


            <div class="row w-100 p-2">
                <div class="col">
                    <label class="form-label">Contato</label>
                    <input id="tel" type="tel" placeholder="(12) 12345-6789" class="form-control" name="tel">
                </div>
            </div>

            <div class="row w-100 p-2">
                <div class="col">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="emailCont">
                </div>
            </div>

            <div class="row w-100 p-2">
                <div class="col d-flex justify-content-center mt-5">
                    <button class="btn btn-success" name="editar">Confirmar</button>
                </div>
            </div>
        </div>
        </div>

    </section>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-4.0.0.js"
        integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>


    <script type="text/javascript">
        $('#tel').mask('(00) 00000-0000');

        $(".conta").on("click", function() {

            $('[name="editar"]').attr("id", "0");


            var id = $(this).find(".id").text();
            var nome = $(this).find(".nome").text();
            var email = $(this).find(".email").text();
            var tel = $(this).find(".tel").text();
            var email_contato = $(this).find(".email_contato").text();


            $('[name="editar"]').attr("id", id);
            $('[name="nome"]').val(nome);
            $('[name="email"]').val(email);
            $('[name="tel"]').val(tel === "não cadastrado" ? "" : tel);
            $('[name="emailCont"]').val(email_contato === "não cadastrado" ? "" : email_contato);
            $('[name="senha"]').val('');

        })


        $('[name="editar"]').on("click", function() {

            var id = $(this).attr("id");
            var nome = $('[name="nome"]').val();
            var email = $('[name="email"]').val();
            var tel = $('[name="tel"]').val();
            var email_contato = $('[name="emailCont"]').val();
            var senha = $('[name="senha"]').val();

            var dados = new FormData()

            dados.append("id", id)
            dados.append("nome", nome)
            dados.append("email", email)
            dados.append("senha", senha)
            dados.append("tel", tel)
            dados.append("email_contato", email_contato)

            $.ajax({
                url: "editar.php",
                method: "POST",
                data: dados,
                processData: false,
                contentType: false,
                success: function() {
                    alert("usuario editado com sucesso")
                    location.reload()
                }
            })

            <?php
            if (isset($_POST["id"])) {

                $id = $_POST["id"];
                $nome = $_POST["nome"];
                $email = $_POST["email"];
                $senha = $_POST["senha"];
                $tel = $_POST["tel"];
                $email_contato = $_POST["email_contato"];


                $editar = $senha === "" ? "UPDATE usuario SET nome = '$nome', email = '$email', tel = '$tel', email_contato = '$email_contato' WHERE id = '$id'" : "UPDATE usuario SET nome = '$nome', email = '$email', tel = '$tel', email_contato = '$email_contato', senha = '$senha' WHERE id = '$id'";

                include "conexao.php";

                $editar = mysqli_query($con, $editar);

                if (mysqli_affected_rows($con)) {
                    echo "usuario alterado com sucesso";
                }
            }


            ?>
        })
    </script>

</body>

</html>