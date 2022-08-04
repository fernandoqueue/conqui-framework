<div class="container-fluid">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Fifth navbar example">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarsExample05">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" style="font-size: 1.5rem" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="font-size: 1.5rem" href="#">Portfolio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="font-size: 1.5rem" href="#">Contact</a>
          </li>
        </ul>
        <ul class="navbar-nav mb-2 mb-lg-0">
          <?php if(\Conqui\Authentication::check()): ?>
            <li class="nav-item">
              <form id="logoutform" action="<?= \Conqui\URL::route('logout') ?>" method="post">
                <input type="hidden" name="token" value="<?=\Conqui\CSRF::get()?>">
              </form>
              <a class="nav-link" style="font-size: 1.5rem" onclick="document.getElementById('logoutform').submit()" href="#">Logout</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" style="font-size: 1.5rem" href="#">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" style="font-size: 1.5rem" href="#">Register</a>
            </li>
          <?php endif;?>
        </ul>
        <!-- <form role="search">
          <input class="form-control" type="search" placeholder="Search" aria-label="Search">
        </form> -->
      </div>
    </div>
    </nav>

    <div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <div class="col-12" style="text-align:center;">
            <h1 style="">Fernando Quintero</h2>
        </div>
      <div class="col-10 col-sm-8 col-lg-6">
        <img src="images/bootstrap-themes.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
      </div>
      <div class="col-lg-6">
        <h1 class="display-5 fw-bold lh-1 mb-3">Full Stack Developer</h1>
        <p class="lead">Quickly design and customize responsive mobile-first sites with Bootstrap, the world’s most popular front-end open source toolkit, featuring Sass variables and mixins, responsive grid system, extensive prebuilt components, and powerful JavaScript plugins.</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
          <button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Primary</button>
          <button type="button" class="btn btn-outline-secondary btn-lg px-4">Default</button>
        </div>
      </div>
    </div>
  </div>


</div>

<script>
  function logout(e){
    e.stopPropagation();
    e.preventDefault();
  }
</script>