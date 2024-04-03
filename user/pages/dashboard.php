<div class="container px-4 py-5" id="featured-3">
  <h2 class="pb-2 border-bottom">Ciao <?php echo $user_logged->name ?>, qui puoi gestire il tuo profilo.</h2>
  <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
    <div class="feature col">
      <div class="feature-icon bg-primary bg-gradient">
        <svg class="bi" width="1em" height="1em">
          <use xlink:href="#collection"></use>
        </svg>
      </div>
      <h2>Modifica Dati <i class="fa-regular fa-user"></i></h2>
      <p>In questa sezione potrai aggiornare i tuoi dati Profilo.</p>
      <a href="?page=profile" class="icon-link">
        Vai
        <svg class="bi" width="1em" height="1em">
          <use xlink:href="#chevron-right"></use>
        </svg>
      </a>
    </div>

    <div class="feature col">
      <div class="feature-icon bg-primary bg-gradient">
        <svg class="bi" width="1em" height="1em">
          <use xlink:href="#collection"></use>
        </svg>
      </div>
      <h2>Sezione Ordini <i class="fa-solid fa-dolly"></i></h2>
      <p>In questa sezione potrai visualizzare tutti gli ordini effettuati.</p>
      <a href="?page=orders" class="icon-link">
        Vai
        <svg class="bi" width="1em" height="1em">
          <use xlink:href="#chevron-right"></use>
        </svg>
      </a>
    </div>

    <div class="feature col">
      <div class="feature-icon bg-primary bg-gradient">
        <svg class="bi" width="1em" height="1em">
          <use xlink:href="#collection"></use>
        </svg>
      </div>
      <h2>Indirizzo Fatturazione <i class="fa-solid fa-map-location-dot"></i></h2>
      <p>In questa sezione potrai modificare il tuo Indirizzo di Fatturazione.</p>
      <a href="?page=address-edit" class="icon-link">
        Vai
        <svg class="bi" width="1em" height="1em">
          <use xlink:href="#chevron-right"></use>
        </svg>
      </a>
    </div>

  </div>
</div>