<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listagem de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  </head>
  <body>
  
     <header class="container-fluid p-4 card">
        <nav class="container">
            <ul class="nav d-flex justify-content-center">
                <li class="nav-item"><a href="index.html" class="nav-link">CADASTRO DE PRODUTOS</a></li>
                <li class="nav-item"><a href="produtos.php" class="nav-link">produtos</a></li>
                <li class="nav-item"><a href="#" class="nav-link">About</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main class="container-fluid">
        <section class="container">
            <h3 class="text-center">Lista de Produtos</h3>
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Link</th>
                        <th>preço Fabrica</th>
                        <th>Parcelas</th>
                        <th>Preço Prod</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        include "conexao.php";
                        $select = "SELECT * FROM `prods`";
                        $select = mysqli_query($con,$select);

                        while($exibe = mysqli_fetch_array($select)){
                            ?>
                            
                            <tr>
                                <td><?php echo $exibe['nome'];?></td>
                                <td><?php echo $exibe['link'];?></td>
                                <td><?php echo $exibe['PC'];?></td>
                                <td><?php echo $exibe['percent'];?></td>
                                <td><?php echo $exibe['PP'];?></td>
                            </tr>
                            
                            <?php
                        }
                    ?>
                </tbody>
            </table>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>