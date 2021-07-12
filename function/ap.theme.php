<?php


require_once "../config/database.php";


function LoadHead($nama_situs, $alamat_situs, $deskripsi_situs, $author_situs, $logo_situs)
{

  echo '
	<!DOCTYPE html>
	<html lang="id">

  	<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="' . $deskripsi_situs . '">
    <meta name="author" content="' . $author_situs . '">
    <link rel="icon" href="../theme/content/' . $logo_situs . '">
    <title>' . $nama_situs . '</title>
	';
}
function LoadCss()
{
  echo '    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="../theme/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../theme/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">  
    <link href="../theme/css/kostum.css" rel="stylesheet" type="text/css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
   	</head>
  ';
}
function LoadBody($nama_situs)
{
  echo '
	<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      <div class="container">
        <a class="logo navbar-btn pull-left" href="home" title="Home">
        <a class="navbar-brand" href="home">' . $nama_situs . '</a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="kategoriproduk.php">Kategori
            </a>
          </li>
        </ul>
      </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="home"></i> Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login"> Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register">Daftar</a>
            </li>
           
          </ul>
        </div>
      </div>
    </nav>
	
  
	';
}
function LoadMenu($nama_situs, $logo_situs)
{
  echo '
  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      <div class="container">
        <a class="logo navbar-btn pull-left" href="home" title="Home">
        <a class="navbar-brand" href="home">' . $nama_situs . '</a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="kategoriproduk.php">Kategori
            </a>
          </li>
        </ul>
      </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            
            <li class="nav-item">
              <a alt="Keranjang belanja" title="Keranjang Belanja" class="nav-link" href="keranjang"><i class="fas fa-shopping-cart"></i> Keranjang</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="profile"><i class="fas fa-user"></i> Profile</a>
            </li>
            <li class="nav-item">
              <a href="keranjang?keranjang=riwayat" class="nav-link"><i class="fas fa-shopping-bag"></i> Riwayat</a>
            </li>
            <li class="nav-item">
              <a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Keluar</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
 

  ';
}
function LoadFooter($nama_situs)
{
  echo '

  
  
   <!-- Footer -->

    <footer class="py-5 footer-bg">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; ' . $nama_situs . ' ' . date('Y') . '</p>
      </div>
      <!-- /.container -->
    </footer>
    <!-- Bootstrap core JavaScript -->
    <script src="../theme/vendor/jquery/jquery.min.js"></script>
    <script src="../theme/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    
   </body>
   <script>
  AOS.init();
</script>
<script>
      window.addEventListener(\'scroll\',(e)=>{
        const nav = document.querySelector(\'.navbar\');
        if(window.pageYOffset>0){
          nav.classList.add("add-shadow");
        }else{
          nav.classList.remove("add-shadow");
        }
      });
    </script>
   </html>
  ';
}
function LoadHeadPanel()
{
  echo '
  <!DOCTYPE html>
  <html lang="id">

    <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description">
    <meta name="author">
    <link rel="icon" href="../theme/content/logo.png">
    <title>Admin Panel - Tanilogi</title>
  ';
}
function LoadCssPanel()
{
  echo '    
   
    <link href="../theme/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../theme/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">  
     <link href="../theme/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="../theme/css/sb-admin.css" rel="stylesheet" type="text/css">
    
    
    </head>
  ';
}

function LoadMenuPanel()
{
  echo '
  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-primary static-top">

      <a class="navbar-brand mr-1" href="index.php">Tanilogi</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        
      </form>
     
      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">  
         <div class="float-right">
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Admin <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">    
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </div>
      </ul>

    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">      
        <li class="nav-item active">
          <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-shopping-cart"></i>
          <span>Pesanan</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Pesanan</h6>
          <a class="dropdown-item" href="order.php">Semua Pesanan</a>
          <a class="dropdown-item" href="order.php?order=selesai">Pesanan Selesai</a>
          
      </li>
       <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-plus"></i>
            <span>Produk</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <h6 class="dropdown-header">Produk</h6>
            <a class="dropdown-item" href="produk.php">Semua Produk</a>
            <a class="dropdown-item" href="produk.php?produk=kategori">Kategori Produk</a>
            <a class="dropdown-item" href="produk.tambah.php">Tambah Produk</a>
            
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pengaturan.php">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pengaturan</span>
          </a>
        </li>
       
            

             </ul>

      
  

  ';
}
function LoadFooterPanel()
{
  LoadModal();
  echo '
    </div>
       
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright &copy; '.date("Y").'  Tanilogi</span>
            </div>
          </div>
        </footer>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>



    <!-- Bootstrap core JavaScript-->
    <script src="../theme/vendor/jquery/jquery.min.js"></script>
    <script src="../theme/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../theme/js/modal.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../theme/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script type="text/javascript" src="../plugins/ckeditor2/ckeditor.js"></script>
    <script src="../theme/vendor/chart.js/Chart.min.js"></script>
    <script src="../theme/vendor/datatables/jquery.dataTables.js"></script>
    <script src="../theme/vendor/datatables/dataTables.bootstrap4.js"></script>
    ';
  echo
  "<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
    <!-- Custom scripts for all pages-->
    <script src='../theme/js/sb-admin.min.js'></script>

   <!-- Demo scripts for this page-->
   
    
  </body>

</html>
  ";
}
