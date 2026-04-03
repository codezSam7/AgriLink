<footer class="bg-dark text-white py-5 mt-auto">
  <div class="container">
    <div class="row g-5">
      <!-- Brand -->
      <div class="col-lg-4 col-md-6">
        <a href="index.php" class="d-inline-block mb-3">
          <h2 class="fw-bold text-success mb-1 fs-3">AgriLink</h2>
        </a>
        <p class="text-white-75 mb-4" style="max-width: 340px;">
          Connecting farmers directly to families who value fresh, traceable food.
        </p>
        <small class="text-white-50">
          Building a transparent and fair food system across Nigeria.
        </small>
      </div>

      <!-- Quick Links -->
      <div class="col-lg-2 col-md-3 col-6">
        <h6 class="text-success fw-semibold mb-3">Platform</h6>
        <ul class="list-unstyled small">
          <li class="mb-2"><a href="<?= BASE_URL ?>products.php" class="text-white-75 text-decoration-none hover-link">Products</a></li>
          <li class="mb-2"><a href="<?= BASE_URL ?>farmers/farmers.php" class="text-white-75 text-decoration-none hover-link">Farmers</a></li>
          <li class="mb-2"><a href="<?= BASE_URL ?>logistics.php" class="text-white-75 text-decoration-none hover-link">Logistics</a></li>
          <li class="mb-2"><a href="<?= BASE_URL ?>contact.php" class="text-white-75 text-decoration-none hover-link">Contact</a></li>
        </ul>
      </div>

      <!-- Support -->
      <div class="col-lg-3 col-md-3 col-6">
        <h6 class="text-success fw-semibold mb-3">Support</h6>
        <ul class="list-unstyled small">
          <li class="mb-2"><a href="#" class="text-white-75 text-decoration-none hover-link">FAQs</a></li>
          <li class="mb-2"><a href="#" class="text-white-75 text-decoration-none hover-link">How It Works</a></li>
          <li class="mb-2"><a href="#" class="text-white-75 text-decoration-none hover-link">Farmer Guidelines</a></li>
          <li class="mb-2"><a href="#" class="text-white-75 text-decoration-none hover-link">Terms of Service</a></li>
          <li class="mb-2"><a href="#" class="text-white-75 text-decoration-none hover-link">Privacy Policy</a></li>
        </ul>
      </div>

      <!-- Contact & Social -->
      <div class="col-lg-3 col-md-6">
        <h6 class="text-success fw-semibold mb-3">Get in Touch</h6>
        <address class="small text-white-75 mb-4">
          support@agrilink.com<br>
          +234 704 429 7202<br>
          Ikeja, Lagos • Nigeria
        </address>

        <div class="d-flex gap-3">
          <a href="#" class="text-white-75 fs-4 hover-social"><i class="bi bi-facebook"></i></a>
          <a href="#" class="text-white-75 fs-4 hover-social"><i class="bi bi-instagram"></i></a>
          <a href="#" class="text-white-75 fs-4 hover-social"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="text-white-75 fs-4 hover-social"><i class="bi bi-whatsapp"></i></a>
        </div>
      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="mt-5 pt-4 border-top border-secondary">
      <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-start small text-white-50">
          &copy; <?= date('Y') ?> AgriLink. All rights reserved.
        </div>
        <div class="col-md-6 text-center text-md-end small mt-3 mt-md-0">
          <a href="#" class="text-white-75 text-decoration-none me-3 hover-link">Privacy</a>
          <a href="#" class="text-white-75 text-decoration-none me-3 hover-link">Terms</a>
          <a href="#" class="text-white-75 text-decoration-none hover-link">Cookies</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Back to Top -->
  <button id="backToTop" class="btn btn-success btn-sm rounded-circle shadow position-fixed bottom-0 end-0 m-4 d-none"
    style="width:50px; height:50px; z-index: 2000;">
    <i class="bi bi-arrow-up fs-5"></i>
  </button>
</footer>

<style>
  .hover-link:hover {
    color: #1fa97a !important;
    text-decoration: underline !important;
  }

  .hover-social {
    transition: all 0.25s ease;
  }

  .hover-social:hover {
    color: #1fa97a !important;
    transform: translateY(-3px);
  }
</style>

<script>
  // Back to top
  const backToTop = document.getElementById('backToTop');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 450) {
      backToTop.classList.add('d-flex', 'align-items-center', 'justify-content-center');
      backToTop.classList.remove('d-none');
    } else {
      backToTop.classList.add('d-none');
    }
  });

  backToTop?.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
</script>