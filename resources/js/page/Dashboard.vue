<template>
    <section id="hero">
    <div class="hero-container">
      <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

        <div class="carousel-inner" role="listbox">

          <!-- Slide 1 -->
          <div class="carousel-item active" style="background-image: url(assets/img/slide/lindts-2.jpg);">
            <div class="carousel-container">
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown title-design"><span>Lindt's</span> Restaurant</h2>
                <p class="animate__animated animate__fadeInUp">
                  Real. Fresh. Food.
Healthy and modern.
From farm to plate.
Directly from mother earth.
Eat natural – eat organic.
Choose healthy. Be strong. Live long.
We’re fresher! We’re tastier!
Living the green life.
Food that’s good for your heart.
Health is wealth. Eat good.
                </p>
                <div>
                  <router-link  :to="{name:'menu'}" class="btn-menu animate__animated animate__fadeInUp scrollto">Our Menu</router-link>
                  <router-link :to="{name:'reservation'}" class="btn-book animate__animated animate__fadeInUp scrollto">Book Your Reservation</router-link>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a> -->

      </div>
    </div>
  </section><!-- End Hero -->

</template>

<script>
export default {

}
</script>

<style>

</style>
