<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<nav class="navbar navbar-expand-lg fixed-top pt--10" style="background-color: #45f3ff;">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><img src="review.png" alt="" style="width: 50px"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <b><a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Category
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="movies.php">Movies</a></li>
            <li><a class="dropdown-item" href="books.php">Books</a></li>
          </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a></b>
        </li>
      </ul>
      <form class="d-flex" role="search" action="search.php">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
        <button class="btn btn-light" type="submit">Search</button>
      </form>
      <svg xmlns="http://www.w3.org/2000/svg" 
     width="50" 
     height="50" 
     fill="currentColor" 
     class="bi bi-person-circle ms-3 icon-hover" 
     viewBox="0 0 16 16" 
     style="cursor: pointer; fill: currentColor; transition: fill 0.3s ease;"
     onmouseover="this.style.fill='white';" 
     onmouseout="this.style.fill='currentColor';"
     data-bs-toggle="offcanvas" 
     data-bs-target="#offcanvasWithBothOptions" 
     aria-controls="offcanvasWithBothOptions">
     <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
     <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
</svg>


    </div>
  </div>
</nav>